<?php

namespace App\Security;

use App\Models\User;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;

class TotpService
{
    private const BASE32_ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
    private const PERIOD = 30;
    private const DIGITS = 6;

    public function generateSecret(int $length = 32): string
    {
        $secret = '';
        $alphabetLength = strlen(self::BASE32_ALPHABET);

        for ($i = 0; $i < $length; $i++) {
            $secret .= self::BASE32_ALPHABET[random_int(0, $alphabetLength - 1)];
        }

        return $secret;
    }

    public function getProvisioningUri(string $issuer, string $accountName, string $secret): string
    {
        $encodedIssuer = rawurlencode($issuer);
        $encodedAccount = rawurlencode($accountName);
        $label = $encodedIssuer.':'.$encodedAccount;

        return sprintf(
            'otpauth://totp/%s?secret=%s&issuer=%s&algorithm=SHA1&digits=%d&period=%d',
            $label,
            $secret,
            $encodedIssuer,
            self::DIGITS,
            self::PERIOD,
        );
    }

    public function renderQrDataUri(string $provisioningUri, int $size = 220): string
    {
        $renderer = new ImageRenderer(
            new RendererStyle($size, 2),
            new SvgImageBackEnd(),
        );
        $writer = new Writer($renderer);
        $svg = $writer->writeString($provisioningUri);

        return 'data:image/svg+xml;base64,'.base64_encode($svg);
    }

    public function verifyCode(User $user, string $secret, string $code, int $window = 1): bool
    {
        $normalized = preg_replace('/[\s\-]+/', '', trim($code)) ?? '';
        if (! preg_match('/^\d{6}$/', $normalized)) {
            return false;
        }

        $currentSlice = (int) floor(time() / self::PERIOD);

        for ($offset = -$window; $offset <= $window; $offset++) {
            $slice = $currentSlice + $offset;
            $expected = $this->generateTotpAtSlice($secret, $slice);

            if (hash_equals($expected, $normalized)) {
                $replayKey = "security:totp_used:{$user->id}:{$slice}";
                // Atomic add prevents code reuse/replay within the 30-second window
                if (! Cache::add($replayKey, true, now()->addSeconds(self::PERIOD * 3))) {
                    return false;
                }

                return true;
            }
        }

        return false;
    }

    public function generateTotpAtSlice(string $secret, int $timeSlice): string
    {
        $binaryKey = $this->base32Decode($secret);
        $packedSlice = pack('N*', 0).pack('N*', $timeSlice);
        $hmac = hash_hmac('sha1', $packedSlice, $binaryKey, true);

        $offset = ord($hmac[19]) & 0x0F;
        $binary = (
            ((ord($hmac[$offset]) & 0x7F) << 24) |
            ((ord($hmac[$offset + 1]) & 0xFF) << 16) |
            ((ord($hmac[$offset + 2]) & 0xFF) << 8) |
            (ord($hmac[$offset + 3]) & 0xFF)
        );

        $otp = $binary % (10 ** self::DIGITS);

        return str_pad((string) $otp, self::DIGITS, '0', STR_PAD_LEFT);
    }

    /**
     * Generates cryptographically random recovery codes and bcrypt/argon2id hashed storage payloads.
     *
     * @return array{plain: array<int, string>, hashed: array<int, string>}
     */
    public function generateRecoveryCodes(int $count = 8): array
    {
        $plain = [];
        $hashed = [];
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $maxIndex = strlen($chars) - 1;

        for ($i = 0; $i < $count; $i++) {
            $segments = [];
            for ($s = 0; $s < 3; $s++) {
                $part = '';
                for ($c = 0; $c < 4; $c++) {
                    $part .= $chars[random_int(0, $maxIndex)];
                }
                $segments[] = $part;
            }

            $code = implode('-', $segments);
            $plain[] = $code;
            $hashed[] = Hash::make($code);
        }

        return [
            'plain' => $plain,
            'hashed' => $hashed,
        ];
    }

    public function consumeRecoveryCode(User $user, string $inputCode): bool
    {
        $normalized = strtoupper(preg_replace('/\s+/', '', trim($inputCode)) ?? '');
        $storedHashes = $user->two_factor_recovery_codes;

        if (! is_array($storedHashes) || $normalized === '') {
            return false;
        }

        foreach ($storedHashes as $index => $hashedCode) {
            if (is_string($hashedCode) && Hash::check($normalized, $hashedCode)) {
                unset($storedHashes[$index]);
                $user->two_factor_recovery_codes = array_values($storedHashes);
                $user->save();

                return true;
            }
        }

        return false;
    }

    private function base32Decode(string $secret): string
    {
        $clean = strtoupper(rtrim(preg_replace('/\s+/', '', $secret) ?? '', '='));
        if ($clean === '') {
            throw new InvalidArgumentException('TOTP secret must not be empty.');
        }

        $bits = '';
        $length = strlen($clean);
        for ($i = 0; $i < $length; $i++) {
            $pos = strpos(self::BASE32_ALPHABET, $clean[$i]);
            if ($pos === false) {
                throw new InvalidArgumentException('Invalid Base32 character in TOTP secret.');
            }
            $bits .= str_pad(decbin($pos), 5, '0', STR_PAD_LEFT);
        }

        $binary = '';
        foreach (str_split($bits, 8) as $byte) {
            if (strlen($byte) === 8) {
                $binary .= chr((int) bindec($byte));
            }
        }

        return $binary;
    }
}

