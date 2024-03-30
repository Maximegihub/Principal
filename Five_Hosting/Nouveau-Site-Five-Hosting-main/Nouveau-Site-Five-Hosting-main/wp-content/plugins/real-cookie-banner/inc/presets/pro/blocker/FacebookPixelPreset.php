<?php

namespace DevOwl\RealCookieBanner\presets\pro\blocker;

use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\presets\pro\FacebookPixelPreset as PresetsFacebookPixelPreset;
use DevOwl\RealCookieBanner\presets\AbstractBlockerPreset;
use DevOwl\RealCookieBanner\presets\middleware\BlockerHostsOptionsMiddleware;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Facebook Pixel blocker preset.
 */
class FacebookPixelPreset extends \DevOwl\RealCookieBanner\presets\AbstractBlockerPreset {
    const IDENTIFIER = \DevOwl\RealCookieBanner\presets\pro\FacebookPixelPreset::IDENTIFIER;
    const VERSION = 1;
    const HOSTS_GROUP_SDK_FUNCTION_NAME = 'sdk-function';
    const HOSTS_GROUP_SDK_SCRIPT = [
        // This script should not be in a logical-must group, as it cannot exist standalone
        '*connect.facebook.net*'
    ];
    // Documented in AbstractPreset
    public function common() {
        $name = 'Facebook Pixel';
        return [
            'id' => self::IDENTIFIER,
            'version' => self::VERSION,
            'name' => $name,
            'attributes' => [
                'hosts' => \array_merge(
                    [
                        [
                            'fbq(\'',
                            [
                                \DevOwl\RealCookieBanner\presets\middleware\BlockerHostsOptionsMiddleware::LOGICAL_MUST =>
                                    self::HOSTS_GROUP_SDK_FUNCTION_NAME
                            ]
                        ],
                        [
                            'fbq("',
                            [
                                \DevOwl\RealCookieBanner\presets\middleware\BlockerHostsOptionsMiddleware::LOGICAL_MUST =>
                                    self::HOSTS_GROUP_SDK_FUNCTION_NAME
                            ]
                        ],
                        // <noscript> <img> tag
                        [
                            'img[alt="fbpx"]',
                            [
                                \DevOwl\RealCookieBanner\presets\middleware\BlockerHostsOptionsMiddleware::LOGICAL_MUST =>
                                    self::HOSTS_GROUP_SDK_FUNCTION_NAME
                            ]
                        ],
                        [
                            'img[alt="facebook_pixel"]',
                            [
                                \DevOwl\RealCookieBanner\presets\middleware\BlockerHostsOptionsMiddleware::LOGICAL_MUST =>
                                    self::HOSTS_GROUP_SDK_FUNCTION_NAME
                            ]
                        ]
                    ],
                    self::HOSTS_GROUP_SDK_SCRIPT
                )
            ],
            'logoFile' => \DevOwl\RealCookieBanner\Core::getInstance()->getBaseAssetsUrl('logos/facebook.png')
        ];
    }
}
