<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag;

use DOMDocument;
/**
 * Utility helpers.
 */
class Utils {
    /**
     * Check if a string starts with a given needle.
     *
     * @param string $haystack The string to search in
     * @param string $needle The starting string
     * @see https://stackoverflow.com/a/834355/5506547
     */
    public static function startsWith($haystack, $needle) {
        $length = \strlen($needle);
        return \substr($haystack, 0, $length) === $needle;
    }
    /**
     * Check if a string starts with a given needle.
     *
     * @param string $haystack The string to search in
     * @param string $needle The starting string
     * @see https://stackoverflow.com/a/834355/5506547
     */
    public static function endsWith($haystack, $needle) {
        $length = \strlen($needle);
        if (!$length) {
            return \true;
        }
        return \substr($haystack, -$length) === $needle;
    }
    /**
     * Check if passed string is JSON.
     *
     * @param string $string
     * @see https://stackoverflow.com/a/6041773/5506547
     * @return array|false
     */
    public static function isJson($string) {
        $result = \json_decode($string, ARRAY_A);
        return \json_last_error() === \JSON_ERROR_NONE ? $result : \false;
    }
    /**
     * Check if a passed string is HTML.
     *
     * @param string $string
     * @see https://subinsb.com/php-check-if-string-is-html/
     */
    public static function isHtml($string) {
        return \is_string($string) && $string !== \strip_tags($string);
    }
    /**
     * A modified version of `preg_replace_callback` that is executed multiple times until no
     * longer match is given.
     *
     * @param string $pattern
     * @param callable $callback
     * @param string $subject
     * @see https://www.php.net/manual/en/function.preg-replace-callback.php
     */
    public static function preg_replace_callback_recursive($pattern, $callback, $subject) {
        $f = function ($matches) use ($pattern, $callback, &$f) {
            $current = $matches[0];
            $result = $callback($matches);
            if ($current !== $result) {
                return \preg_replace_callback($pattern, $f, $result);
            }
            return $result;
        };
        return \preg_replace_callback($pattern, $f, $subject);
    }
    /**
     * Parse a HTML attributes string to an associative array.
     *
     * @param string $str
     */
    public static function parseHtmlAttributes($str) {
        // Check if string has potential escaped entities so we need to parse the tag with a real parser
        $hasEntities = \preg_match('/&\\w+;/', $str);
        if ($hasEntities && \class_exists(\DOMDocument::class)) {
            $dom = new \DOMDocument();
            // Suppress warnings about unknown tags (https://stackoverflow.com/a/41845049/5506547)
            \libxml_clear_errors();
            $previous = \libxml_use_internal_errors(\true);
            // Load content as UTF-8 content (see https://stackoverflow.com/a/8218649/5506547)
            $dom->loadHTML(\sprintf('<?xml encoding="utf-8" ?><div %s></div>', $str));
            $node = $dom->documentElement->firstChild->firstChild;
            // dom -> html -> body -> div
            $attributes = [];
            foreach ($node->attributes as $attrName => $attrNode) {
                $attributes[$attrName] = $attrNode->nodeValue;
            }
            \libxml_clear_errors();
            \libxml_use_internal_errors($previous);
        } else {
            // Fallback to broken attribute parser to improve performance significantly
            $attributes = shortcode_parse_atts($str);
        }
        if (empty($attributes)) {
            $attributes = [];
        }
        // Fix single-attributes, e. g. `<input disabled />` (without value)
        foreach ($attributes as $key => $value) {
            if (\is_numeric($key)) {
                unset($attributes[$key]);
                $attributes[$value] = \true;
            }
        }
        return $attributes;
    }
    /**
     * Transform a given associate attributes array to a DOM attributes string.
     *
     * @param array $attributes
     */
    public static function htmlAttributes($attributes) {
        return \join(
            ' ',
            \array_map(function ($key) use ($attributes) {
                if (\is_bool($attributes[$key])) {
                    return $attributes[$key] ? $key : '';
                }
                return $key . '="' . esc_attr($attributes[$key]) . '"';
            }, \array_keys($attributes))
        );
    }
}
