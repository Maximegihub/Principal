<?php

namespace DevOwl\RealCookieBanner\presets\pro\blocker;

use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\presets\pro\CustomTwitterFeedPreset as PresetsCustomTwitterFeedPreset;
use DevOwl\RealCookieBanner\presets\AbstractBlockerPreset;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Custom Twitter Feed (Custom Twitter Feeds (Tweets Widget)) blocker preset.
 */
class CustomTwitterFeedPreset extends \DevOwl\RealCookieBanner\presets\AbstractBlockerPreset {
    const IDENTIFIER = \DevOwl\RealCookieBanner\presets\pro\CustomTwitterFeedPreset::IDENTIFIER;
    const VERSION = 1;
    // Documented in AbstractPreset
    public function common() {
        $name = 'Custom Twitter Feeds';
        return [
            'id' => self::IDENTIFIER,
            'version' => self::VERSION,
            'name' => $name,
            'description' => 'Tweets Widget by Smash Balloon',
            'attributes' => [
                'hosts' => [
                    'div[class*="ctf "]',
                    '*twimg.com*',
                    '*wp-content/plugins/custom-twitter-feeds/js/*',
                    '*wp-content/plugins/custom-twitter-feeds-pro/js/*'
                ]
            ],
            'logoFile' => \DevOwl\RealCookieBanner\Core::getInstance()->getBaseAssetsUrl(
                'logos/smash-balloon-custom-twitter-feeds.png'
            ),
            'needs' => \DevOwl\RealCookieBanner\presets\pro\CustomTwitterFeedPreset::needs()
        ];
    }
}
