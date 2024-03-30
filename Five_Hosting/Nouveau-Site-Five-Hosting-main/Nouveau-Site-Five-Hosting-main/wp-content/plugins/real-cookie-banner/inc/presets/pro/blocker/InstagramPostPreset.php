<?php

namespace DevOwl\RealCookieBanner\presets\pro\blocker;

use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\presets\pro\InstagramPostPreset as PresetsInstagramPostPreset;
use DevOwl\RealCookieBanner\presets\AbstractBlockerPreset;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Instgram (post) blocker preset.
 */
class InstagramPostPreset extends \DevOwl\RealCookieBanner\presets\AbstractBlockerPreset {
    const IDENTIFIER = \DevOwl\RealCookieBanner\presets\pro\InstagramPostPreset::IDENTIFIER;
    const VERSION = 2;
    // Documented in AbstractPreset
    public function common() {
        $name = 'Instagram (Post)';
        return [
            'id' => self::IDENTIFIER,
            'version' => self::VERSION,
            'name' => $name,
            'attributes' => [
                'hosts' => [
                    '*instagram.com*',
                    '*cdninstagram.com*',
                    'blockquote[class="instagram-media"]',
                    // [Plugin Comp] https://wordpress.org/plugins/meks-easy-instagram-widget/
                    'div[class="meks-instagram-widget"]',
                    // [Theme Comp] https://themeforest.net/item/woodmart-woocommerce-wordpress-theme/20264492
                    'div[style*="cdninstagram.com"]',
                    'div[class*="instagram-widget"]'
                ]
            ],
            'logoFile' => \DevOwl\RealCookieBanner\Core::getInstance()->getBaseAssetsUrl('logos/instagram.png')
        ];
    }
}
