<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\Customize;

use DevOwl\RealCookieBanner\Vendor\MatthiasWeb\Utils\Assets as UtilsAssets;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Assets management, use it in your assets class.
 */
trait Assets {
    public static $TYPE_CUSTOMIZE = 'customize_controls_print_scripts';
    /**
     * Probably enqueue customize helpers in your frontend. There are two types
     * of customize helpers:
     *
     * - Customize preview: Your website on right frame
     * - Customize manager: Configure customize settings on the left sidebar
     *
     * @param string[] $scriptDeps Append the customize handle to this array
     * @param boolean $force
     */
    public function probablyEnqueueCustomizeHelpers(&$scriptDeps = null, $force = \false) {
        /**
         * Assets
         *
         * @var UtilsAssets
         */
        $assets = $this;
        $isSidebar = current_action() === self::$TYPE_CUSTOMIZE;
        if ($isSidebar || $force) {
            $assets->enqueueComposerStyle('customize', []);
        }
        if ($isSidebar || is_customize_preview() || $force) {
            $handle = $assets->enqueueComposerScript('customize', []);
            if ($handle !== \false && $scriptDeps !== null) {
                \array_push($scriptDeps, $handle);
            }
            return $handle;
        }
        return \false;
    }
    /**
     * Enqueue scripts in customize (not preview!)
     */
    public function customize_controls_print_scripts() {
        $this->enqueue_scripts_and_styles(self::$TYPE_CUSTOMIZE);
    }
}
