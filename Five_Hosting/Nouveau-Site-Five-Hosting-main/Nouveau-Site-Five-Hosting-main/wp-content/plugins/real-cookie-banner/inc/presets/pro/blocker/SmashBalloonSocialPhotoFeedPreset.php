<?php

namespace DevOwl\RealCookieBanner\presets\pro\blocker;

use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\presets\pro\SmashBalloonSocialPhotoFeedPreset as PresetsSmashBalloonSocialPhotoFeedPreset;
use DevOwl\RealCookieBanner\presets\AbstractBlockerPreset;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Smash Balloon Social Photo Feed preset -> Instagram blocker preset.
 */
class SmashBalloonSocialPhotoFeedPreset extends \DevOwl\RealCookieBanner\presets\AbstractBlockerPreset {
    const IDENTIFIER = \DevOwl\RealCookieBanner\presets\pro\SmashBalloonSocialPhotoFeedPreset::IDENTIFIER;
    const VERSION = \DevOwl\RealCookieBanner\presets\pro\blocker\GoogleAnalyticsPreset::VERSION;
    // Documented in AbstractPreset
    public function common() {
        $name = 'Smash Balloon Social Photo Feed';
        return [
            'id' => self::IDENTIFIER,
            'version' => self::VERSION,
            'name' => $name,
            'description' => 'Instagram Feed',
            'attributes' => [
                'extends' => \DevOwl\RealCookieBanner\presets\pro\blocker\InstagramPostPreset::IDENTIFIER,
                'extendsHostsEnd' => [
                    'div[id="sb_instagram"]',
                    'div[class*="sbi_header_text"]',
                    'link[id="sb_instagram_styles-css"]',
                    '*/wp-content/plugins/instagram-feed/js/*',
                    '*/wp-content/plugins/instagram-feed-pro/js/*'
                ]
            ],
            'logoFile' => \DevOwl\RealCookieBanner\Core::getInstance()->getBaseAssetsUrl(
                'logos/smash-balloon-social-post-feed.png'
            ),
            'needs' => \DevOwl\RealCookieBanner\presets\pro\SmashBalloonSocialPhotoFeedPreset::needs()
        ];
    }
}
