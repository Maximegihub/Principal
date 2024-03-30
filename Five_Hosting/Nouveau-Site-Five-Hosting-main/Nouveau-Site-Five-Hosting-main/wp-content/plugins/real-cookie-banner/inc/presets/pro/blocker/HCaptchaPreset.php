<?php

namespace DevOwl\RealCookieBanner\presets\pro\blocker;

use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\presets\AbstractBlockerPreset;
use DevOwl\RealCookieBanner\presets\pro\HCaptchaPreset as ProHCaptchaPreset;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * hCaptcha blocker preset.
 */
class HCaptchaPreset extends \DevOwl\RealCookieBanner\presets\AbstractBlockerPreset {
    const IDENTIFIER = \DevOwl\RealCookieBanner\presets\pro\HCaptchaPreset::IDENTIFIER;
    const VERSION = 1;
    // Documented in AbstractPreset
    public function common() {
        $name = 'hCaptcha';
        return [
            'id' => self::IDENTIFIER,
            'version' => self::VERSION,
            'name' => $name,
            'hidden' => \true,
            'attributes' => [
                'hosts' => [
                    '*hcaptcha.com*',
                    'link[id="hcaptcha-style-css"]',
                    '*wp-content/plugins/hcaptcha-for-forms-and-more*'
                ],
                'cookies' => [\DevOwl\RealCookieBanner\presets\pro\HCaptchaPreset::IDENTIFIER]
            ],
            'logoFile' => \DevOwl\RealCookieBanner\Core::getInstance()->getBaseAssetsUrl('logos/hcaptcha.png')
        ];
    }
}
