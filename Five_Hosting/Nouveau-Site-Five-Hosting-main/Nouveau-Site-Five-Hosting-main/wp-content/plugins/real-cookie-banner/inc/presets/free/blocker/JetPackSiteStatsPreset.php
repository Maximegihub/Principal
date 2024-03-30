<?php

namespace DevOwl\RealCookieBanner\presets\free\blocker;

use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\presets\AbstractBlockerPreset;
use DevOwl\RealCookieBanner\presets\free\JetpackSiteStatsPreset as FreeJetpackSiteStatsPreset;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Jetpack Site Stats blocker preset.
 */
class JetPackSiteStatsPreset extends \DevOwl\RealCookieBanner\presets\AbstractBlockerPreset {
    const IDENTIFIER = \DevOwl\RealCookieBanner\presets\free\JetpackSiteStatsPreset::IDENTIFIER;
    const VERSION = 3;
    // Documented in AbstractPreset
    public function common() {
        $name = 'Jetpack Site Stats';
        return [
            'id' => self::IDENTIFIER,
            'version' => self::VERSION,
            'name' => $name,
            'logoFile' => \DevOwl\RealCookieBanner\Core::getInstance()->getBaseAssetsUrl('logos/jetpack.png'),
            'needs' => \DevOwl\RealCookieBanner\presets\free\JetpackSiteStatsPreset::needs(),
            'attributes' => [
                'name' => $name,
                'hosts' => ['*pixel.wp.com*', '*stats.wp.com*'],
                'cookies' => [\DevOwl\RealCookieBanner\presets\free\JetpackSiteStatsPreset::IDENTIFIER],
                'visual' => \false
            ]
        ];
    }
}
