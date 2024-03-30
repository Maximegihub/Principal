<?php

namespace DevOwl\RealCookieBanner\presets\pro\blocker;

use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\presets\AbstractBlockerPreset;
use DevOwl\RealCookieBanner\presets\pro\GoogleAds;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Google Ads blocker preset.
 */
class GoogleAdsPreset extends \DevOwl\RealCookieBanner\presets\AbstractBlockerPreset {
    const IDENTIFIER = \DevOwl\RealCookieBanner\presets\pro\GoogleAds::IDENTIFIER;
    const VERSION = 2;
    // Documented in AbstractPreset
    public function common() {
        return [
            'id' => self::IDENTIFIER,
            'version' => self::VERSION,
            'name' => 'Google Ads',
            'description' => __('Conversion Tracking and Remarketing', RCB_TD),
            'hidden' => \true,
            'attributes' => [
                'hosts' => ['*gtag/js?id=AW-*', 'gtag("config", "AW-*");', 'gtag(\'config\', \'AW-*\');'],
                'cookies' => [\DevOwl\RealCookieBanner\presets\pro\GoogleAds::IDENTIFIER]
            ],
            'logoFile' => \DevOwl\RealCookieBanner\Core::getInstance()->getBaseAssetsUrl('logos/google-a-ds.png')
        ];
    }
}
