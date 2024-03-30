<?php

namespace DevOwl\RealCookieBanner\presets\free\blocker;

use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\presets\AbstractBlockerPreset;
use DevOwl\RealCookieBanner\presets\free\GoogleFontsPreset as FreeGoogleFontsPreset;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Google Fonts blocker preset.
 */
class GoogleFontsPreset extends \DevOwl\RealCookieBanner\presets\AbstractBlockerPreset {
    const IDENTIFIER = \DevOwl\RealCookieBanner\presets\free\GoogleFontsPreset::IDENTIFIER;
    const VERSION = 2;
    /**
     * Web Font Loader compatibility.
     *
     * @see https://app.clickup.com/t/aq01tu
     */
    const WEB_FONT_LOADER_URL = '*ajax.googleapis.com/ajax/libs/webfont/1/webfont.js*';
    // Documented in AbstractPreset
    public function common() {
        $name = 'Google Fonts';
        return [
            'id' => self::IDENTIFIER,
            'version' => self::VERSION,
            'name' => $name,
            'logoFile' => \DevOwl\RealCookieBanner\Core::getInstance()->getBaseAssetsUrl('logos/google-fonts.png'),
            'attributes' => [
                'name' => $name,
                'hosts' => ['*fonts.googleapis.com*', self::WEB_FONT_LOADER_URL, '*fonts.gstatic.com*'],
                'cookies' => [\DevOwl\RealCookieBanner\presets\free\blocker\GoogleFontsPreset::IDENTIFIER],
                'visual' => \false
            ]
        ];
    }
}
