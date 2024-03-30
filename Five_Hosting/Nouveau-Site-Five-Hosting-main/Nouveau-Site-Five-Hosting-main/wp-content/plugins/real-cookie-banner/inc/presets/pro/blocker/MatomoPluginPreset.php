<?php

namespace DevOwl\RealCookieBanner\presets\pro\blocker;

use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\presets\pro\MatomoPluginPreset as PresetsMatomoPluginPreset;
use DevOwl\RealCookieBanner\presets\AbstractBlockerPreset;
use DevOwl\RealCookieBanner\presets\PresetIdentifierMap;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Matomo Plugin blocker preset.
 */
class MatomoPluginPreset extends \DevOwl\RealCookieBanner\presets\AbstractBlockerPreset {
    const IDENTIFIER = \DevOwl\RealCookieBanner\presets\pro\MatomoPluginPreset::IDENTIFIER;
    const VERSION = 1;
    // Documented in AbstractPreset
    public function common() {
        $name = 'Matomo';
        return [
            'id' => self::IDENTIFIER,
            'version' => self::VERSION,
            'name' => $name,
            'description' => 'WordPress Plugin',
            'attributes' => [
                'extends' => \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MATOMO,
                'extendsHostsEnd' => [
                    // Matomo supports `src` and inline embed
                    '*wp-content\\/uploads\\/matomo\\/matomo.js*',
                    '*wp-content/uploads/matomo/matomo.js*',
                    // REST API tracker
                    '*wp-json/matomo*',
                    '*wp-json\\/matomo*',
                    // <noscript> tag
                    '*wp-content/plugins/matomo/app/matomo.php*'
                ]
            ],
            'logoFile' => \DevOwl\RealCookieBanner\Core::getInstance()->getBaseAssetsUrl('logos/matomo.png'),
            'needs' => \DevOwl\RealCookieBanner\presets\pro\MatomoPluginPreset::needs()
        ];
    }
}
