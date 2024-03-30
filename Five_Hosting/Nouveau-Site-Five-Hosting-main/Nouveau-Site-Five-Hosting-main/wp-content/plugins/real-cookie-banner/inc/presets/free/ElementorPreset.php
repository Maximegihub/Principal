<?php

namespace DevOwl\RealCookieBanner\presets\free;

use DevOwl\RealCookieBanner\comp\language\Hooks;
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\presets\AbstractCookiePreset;
use DevOwl\RealCookieBanner\presets\middleware\DisablePresetByNeedsMiddleware;
use DevOwl\RealCookieBanner\presets\PresetIdentifierMap;
use DevOwl\RealCookieBanner\settings\General;
use DevOwl\RealCookieBanner\Utils;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Elementor page builder cookie preset.
 */
class ElementorPreset extends \DevOwl\RealCookieBanner\presets\AbstractCookiePreset {
    const IDENTIFIER = \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ELEMENTOR;
    const SLUG_FREE = 'elementor';
    const SLUG_PRO = 'elementor-pro';
    const VERSION = 1;
    // Documented in AbstractPreset
    public function common() {
        $name = 'Elementor';
        $cookieHost = \DevOwl\RealCookieBanner\Utils::host(\DevOwl\RealCookieBanner\Utils::HOST_TYPE_CURRENT);
        return [
            'id' => self::IDENTIFIER,
            'version' => self::VERSION,
            'name' => $name,
            'logoFile' => \DevOwl\RealCookieBanner\Core::getInstance()->getBaseAssetsUrl('logos/elementor.png'),
            'needs' => self::needs(),
            'recommended' => \true,
            'attributes' => [
                'name' => $name,
                'group' => __('Essential', \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED),
                'purpose' => __(
                    'Elementor is a software used to create the layout of this website. Cookies are used to store the number of page views and active sessions of the user. The collected data is not used for analysis purposes, but only to ensure that, for example, hidden elements are not displayed again during multiple active sessions.',
                    \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED
                ),
                'provider' => get_bloginfo('name'),
                'providerPrivacyPolicy' => \DevOwl\RealCookieBanner\settings\General::getInstance()->getPrivacyPolicyUrl(
                    ''
                ),
                'technicalDefinitions' => [
                    [
                        'type' => 'local',
                        'name' => 'elementor',
                        'host' => $cookieHost,
                        'durationUnit' => 'y',
                        'sessionDuration' => \false,
                        'duration' => 0
                    ],
                    [
                        'type' => 'session',
                        'name' => 'elementor',
                        'host' => $cookieHost,
                        'durationUnit' => 'y',
                        'sessionDuration' => \false,
                        'duration' => 0
                    ]
                ]
            ]
        ];
    }
    // Documented in AbstractPreset
    public function managerNone() {
        return \false;
    }
    // Documented in AbstractPreset
    public function managerGtm() {
        return \false;
    }
    // Documented in AbstractPreset
    public function managerMtm() {
        return \false;
    }
    // Self-explanatory
    public static function needs() {
        return \DevOwl\RealCookieBanner\presets\middleware\DisablePresetByNeedsMiddleware::generateNeedsForSlugs([
            self::SLUG_PRO,
            self::SLUG_FREE
        ]);
    }
}
