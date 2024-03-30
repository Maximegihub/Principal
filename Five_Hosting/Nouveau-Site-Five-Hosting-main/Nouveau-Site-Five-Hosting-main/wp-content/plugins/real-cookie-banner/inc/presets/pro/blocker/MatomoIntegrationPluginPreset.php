<?php

namespace DevOwl\RealCookieBanner\presets\pro\blocker;

use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\presets\pro\MatomoIntegrationPluginPreset as PresetsMatomoIntegrationPluginPreset;
use DevOwl\RealCookieBanner\presets\AbstractBlockerPreset;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * WP-Matomo Integration (former WP-Piwik) blocker preset.
 */
class MatomoIntegrationPluginPreset extends \DevOwl\RealCookieBanner\presets\AbstractBlockerPreset {
    const IDENTIFIER = \DevOwl\RealCookieBanner\presets\pro\MatomoIntegrationPluginPreset::IDENTIFIER;
    const VERSION = 1;
    // Documented in AbstractPreset
    public function common() {
        $name = 'WP-Matomo Integration';
        return [
            'id' => self::IDENTIFIER,
            'version' => self::VERSION,
            'name' => $name,
            'description' => __('former WP-Piwik', RCB_TD),
            'attributes' => ['hosts' => ['*window._paq*', '*matomo.js*', '*matomo.php*']],
            'logoFile' => \DevOwl\RealCookieBanner\Core::getInstance()->getBaseAssetsUrl(
                'logos/wp-matomo-integration.png'
            ),
            'needs' => \DevOwl\RealCookieBanner\presets\pro\MatomoIntegrationPluginPreset::needs()
        ];
    }
}
