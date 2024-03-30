<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker;

/**
 * Utility helpers.
 */
class Utils {
    const TEMP_REGEX_AVOID_UNMASK = 'PLEACE_REPLACE_ME_AGAIN';
    /**
     * Create a pattern for `preg_match_all` usage.
     *
     * @param string $name
     */
    public static function createRegexpPatternFromWildcardName($name) {
        $name = \str_replace('*', self::TEMP_REGEX_AVOID_UNMASK, $name);
        $regex = \sprintf(
            '/^%s$/',
            \str_replace(self::TEMP_REGEX_AVOID_UNMASK, '((?:.|\\n)*)', \preg_quote($name, '/'))
        );
        // Remove duplicate `(.*)` identifiers to avoid "catastrophical backtrace"
        return \preg_replace('/(\\((\\(\\?:\\.\\|\\\\n\\)\\*)\\))+/m', '((?:.|\\n)*)', $regex);
    }
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
}
