<?php

namespace DevOwl\RealCookieBanner\presets\free;

use DevOwl\RealCookieBanner\comp\language\Hooks;
use DevOwl\RealCookieBanner\MyConsent;
use DevOwl\RealCookieBanner\presets\AbstractCookiePreset;
use DevOwl\RealCookieBanner\presets\PresetIdentifierMap;
use DevOwl\RealCookieBanner\settings\Consent;
use DevOwl\RealCookieBanner\settings\General;
use DevOwl\RealCookieBanner\Utils;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Real Cookie Banner cookie preset.
 */
class RealCookieBannerPreset extends \DevOwl\RealCookieBanner\presets\AbstractCookiePreset {
    const IDENTIFIER = \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::REAL_COOKIE_BANNER;
    const VERSION = 2;
    // Documented in AbstractPreset
    public function common() {
        $name = 'Real Cookie Banner';
        return [
            'id' => self::IDENTIFIER,
            'version' => self::VERSION,
            'name' => $name,
            'logoFile' => 'real-cookie-banner.svg',
            'hidden' => \true,
            'attributes' => [
                'name' => $name,
                'group' => __('Essential', \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED),
                'purpose' => __(
                    'Real Cookie Banner asks the user to consent to the cookies used on this website. The cookies store the UUID (pseudonym identification of the user) and the selection of the agreed cookie groups and cookies.',
                    \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED
                ),
                'provider' => get_bloginfo('name'),
                'providerPrivacyPolicy' => \DevOwl\RealCookieBanner\settings\General::getInstance()->getPrivacyPolicyUrl(
                    ''
                ),
                'technicalDefinitions' => [
                    [
                        'type' => 'http',
                        'name' => \DevOwl\RealCookieBanner\MyConsent::COOKIE_NAME_USER_PREFIX . '*',
                        'host' => \DevOwl\RealCookieBanner\Utils::host(
                            \DevOwl\RealCookieBanner\Utils::HOST_TYPE_MAIN_WITH_ALL_SUBDOMAINS
                        ),
                        'duration' => \DevOwl\RealCookieBanner\settings\Consent::getInstance()->getCookieDuration(),
                        'durationUnit' => 'd',
                        'sessionDuration' => \false
                    ],
                    [
                        'type' => 'http',
                        'name' => 'PHPSESSID',
                        'host' => \DevOwl\RealCookieBanner\Utils::host(
                            \DevOwl\RealCookieBanner\Utils::HOST_TYPE_CURRENT
                        ),
                        'durationUnit' => 'y',
                        'duration' => 0,
                        'sessionDuration' => \true
                    ]
                ],
                'codeOptOutDelete' => \false
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
}
