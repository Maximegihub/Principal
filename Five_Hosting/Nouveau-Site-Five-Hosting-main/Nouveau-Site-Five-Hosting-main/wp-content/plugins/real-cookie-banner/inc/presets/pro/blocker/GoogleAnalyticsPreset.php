<?php

namespace DevOwl\RealCookieBanner\presets\pro\blocker;

use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\presets\pro\GoogleAnalyticsPreset as PresetsGoogleAnalyticsPreset;
use DevOwl\RealCookieBanner\presets\AbstractBlockerPreset;
use DevOwl\RealCookieBanner\presets\middleware\BlockerHostsOptionsMiddleware;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Google Analytics (Universal Analytics) blocker preset.
 */
class GoogleAnalyticsPreset extends \DevOwl\RealCookieBanner\presets\AbstractBlockerPreset {
    const IDENTIFIER = \DevOwl\RealCookieBanner\presets\pro\GoogleAnalyticsPreset::IDENTIFIER;
    const VERSION = 1;
    const HOSTS_GROUP_PROPERTY_ID_NAME = 'property-id';
    const HOSTS_GROUP_SCRIPT_NAME = 'script';
    const HOSTS_GROUP_SCRIPT = [
        [
            '*google-analytics.com/analytics.js*',
            [
                \DevOwl\RealCookieBanner\presets\middleware\BlockerHostsOptionsMiddleware::LOGICAL_MUST =>
                    self::HOSTS_GROUP_SCRIPT_NAME
            ]
        ],
        [
            '*googletagmanager.com/gtag/js?*',
            [
                \DevOwl\RealCookieBanner\presets\middleware\BlockerHostsOptionsMiddleware::LOGICAL_MUST =>
                    self::HOSTS_GROUP_SCRIPT_NAME
            ]
        ],
        [
            '*google-analytics.com/ga.js*',
            [
                \DevOwl\RealCookieBanner\presets\middleware\BlockerHostsOptionsMiddleware::LOGICAL_MUST =>
                    self::HOSTS_GROUP_SCRIPT_NAME
            ]
        ],
        // Comp: RankMath
        [
            'script[id="google_gtagjs"]',
            [
                \DevOwl\RealCookieBanner\presets\middleware\BlockerHostsOptionsMiddleware::LOGICAL_MUST =>
                    self::HOSTS_GROUP_SCRIPT_NAME
            ]
        ]
    ];
    // Documented in AbstractPreset
    public function common() {
        $name = 'Google Analytics';
        return [
            'id' => self::IDENTIFIER,
            'version' => self::VERSION,
            'name' => $name,
            'description' => 'Universal Analytics',
            'attributes' => [
                'hosts' => \array_merge(
                    [
                        [
                            '"UA-*"',
                            [
                                \DevOwl\RealCookieBanner\presets\middleware\BlockerHostsOptionsMiddleware::LOGICAL_MUST =>
                                    self::HOSTS_GROUP_PROPERTY_ID_NAME
                            ]
                        ],
                        [
                            "'UA-*'",
                            [
                                \DevOwl\RealCookieBanner\presets\middleware\BlockerHostsOptionsMiddleware::LOGICAL_MUST =>
                                    self::HOSTS_GROUP_PROPERTY_ID_NAME
                            ]
                        ],
                        [
                            'ga(',
                            [
                                \DevOwl\RealCookieBanner\presets\middleware\BlockerHostsOptionsMiddleware::LOGICAL_MUST =>
                                    self::HOSTS_GROUP_PROPERTY_ID_NAME
                            ]
                        ],
                        [
                            'gtag(',
                            [
                                \DevOwl\RealCookieBanner\presets\middleware\BlockerHostsOptionsMiddleware::LOGICAL_MUST =>
                                    self::HOSTS_GROUP_PROPERTY_ID_NAME
                            ]
                        ]
                    ],
                    self::HOSTS_GROUP_SCRIPT
                )
            ],
            'logoFile' => \DevOwl\RealCookieBanner\Core::getInstance()->getBaseAssetsUrl('logos/google-analytics.png')
        ];
    }
}
