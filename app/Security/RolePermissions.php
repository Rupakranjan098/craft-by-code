<?php

namespace App\Security;

use App\Models\User;

class RolePermissions
{
    /**
     * Explicit role -> permission capability matrix (Least Privilege RBAC).
     */
    public const MATRIX = [
        'super_admin' => ['*'],
        'admin' => [
            'dashboard.view',
            'content.manage',
            'inquiries.view',
            'inquiries.manage',
            'settings.manage',
            'security.view',
            'security.manage',
            'backups.manage',
            'users.manage',
            'api.tokens.manage',
        ],
        'editor' => [
            'dashboard.view',
            'content.manage',
            'inquiries.view',
        ],
        'viewer' => [
            'dashboard.view',
            'inquiries.view',
        ],
        'user' => [],
    ];

    public static function isBackofficeRole(?string $role): bool
    {
        return in_array($role, ['super_admin', 'admin', 'editor', 'viewer'], true);
    }

    public static function userHasPermission(User $user, string $permission): bool
    {
        $rolePerms = self::MATRIX[$user->role] ?? [];
        if (in_array('*', $rolePerms, true) || in_array($permission, $rolePerms, true)) {
            return true;
        }

        $customPerms = is_array($user->permissions) ? $user->permissions : [];
        return in_array('*', $customPerms, true) || in_array($permission, $customPerms, true);
    }
}

