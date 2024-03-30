<?php

namespace DevOwl\RealCookieBanner\view\shortcode;

use DevOwl\RealCookieBanner\base\UtilsProvider;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Shortcode to print the consent UUID of the current user.
 */
class PrintUuidShortcode {
    use UtilsProvider;
    const TAG = 'rcb-consent-print-uuid';
    /**
     * Render shortcode HTML.
     *
     * @param mixed $atts
     * @return string
     */
    public static function render($atts) {
        $atts = shortcode_atts(['fallback' => ''], $atts, self::TAG);
        return \sprintf('<span class="%s" data-fallback="%s"></span>', self::TAG, esc_attr($atts['fallback']));
    }
}
