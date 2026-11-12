<?php

namespace App\Security;

use DOMDocument;
use DOMElement;
use DOMNode;

class HtmlSanitizer
{
    private const ALLOWED_TAGS = [
        'p', 'br', 'hr',
        'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
        'strong', 'b', 'em', 'i', 'u', 's',
        'blockquote', 'pre', 'code',
        'ul', 'ol', 'li',
        'a', 'img',
        'table', 'thead', 'tbody', 'tr', 'th', 'td',
        'figure', 'figcaption', 'span',
    ];

    private const ALLOWED_ATTRIBUTES = [
        'a' => ['href', 'title', 'target', 'rel'],
        'img' => ['src', 'alt', 'title', 'width', 'height'],
        '*' => ['class'],
    ];

    /**
     * Strips dangerous HTML tags, event handlers, javascript: URIs, and inline scripts.
     */
    public static function sanitize(?string $html): string
    {
        if (! is_string($html) || trim($html) === '') {
            return '';
        }

        $dom = new DOMDocument('1.0', 'UTF-8');
        $previousErrorState = libxml_use_internal_errors(true);

        $wrapped = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body><div id="__cbc_root__">'
            .$html
            .'</div></body></html>';

        $dom->loadHTML($wrapped, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NONET);
        libxml_clear_errors();
        libxml_use_internal_errors($previousErrorState);

        $root = $dom->getElementById('__cbc_root__');
        if (! $root) {
            return e(strip_tags($html));
        }

        self::sanitizeNode($root);

        $output = '';
        foreach ($root->childNodes as $child) {
            $output .= $dom->saveHTML($child);
        }

        return $output;
    }

    private static function sanitizeNode(DOMNode $node): void
    {
        $children = [];
        foreach ($node->childNodes as $child) {
            $children[] = $child;
        }

        foreach ($children as $child) {
            if ($child instanceof DOMElement) {
                $tag = strtolower($child->tagName);

                if (! in_array($tag, self::ALLOWED_TAGS, true)) {
                    $node->removeChild($child);
                    continue;
                }

                self::sanitizeAttributes($child, $tag);
                self::sanitizeNode($child);
            }
        }
    }

    private static function sanitizeAttributes(DOMElement $element, string $tag): void
    {
        $allowedForTag = array_merge(
            self::ALLOWED_ATTRIBUTES['*'] ?? [],
            self::ALLOWED_ATTRIBUTES[$tag] ?? [],
        );

        $toRemove = [];
        foreach ($element->attributes as $attribute) {
            $attrName = strtolower($attribute->name);
            if (str_starts_with($attrName, 'on') || ! in_array($attrName, $allowedForTag, true)) {
                $toRemove[] = $attribute->name;
            }
        }

        foreach ($toRemove as $attrName) {
            $element->removeAttribute($attrName);
        }

        if ($tag === 'a') {
            $href = $element->getAttribute('href');
            if ($href !== '' && ! UrlValidator::isSafeDisplayLink($href)) {
                $element->removeAttribute('href');
            }

            if (strtolower($element->getAttribute('target')) === '_blank') {
                $element->setAttribute('rel', 'noopener noreferrer');
            }
        }

        if ($tag === 'img') {
            $src = $element->getAttribute('src');
            if ($src === '' || ! UrlValidator::isSafeMediaPath($src)) {
                $element->parentNode?->removeChild($element);
            }
        }
    }
}

