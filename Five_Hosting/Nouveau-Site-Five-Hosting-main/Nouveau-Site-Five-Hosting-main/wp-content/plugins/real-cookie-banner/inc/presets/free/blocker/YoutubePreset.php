<?php

namespace DevOwl\RealCookieBanner\presets\free\blocker;

use DevOwl\RealCookieBanner\comp\language\Hooks;
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\presets\AbstractBlockerPreset;
use DevOwl\RealCookieBanner\presets\free\YoutubePreset as FreeYoutubePreset;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Youtube blocker preset.
 */
class YoutubePreset extends \DevOwl\RealCookieBanner\presets\AbstractBlockerPreset {
    const IDENTIFIER = \DevOwl\RealCookieBanner\presets\free\YoutubePreset::IDENTIFIER;
    const VERSION = 2;
    // Documented in AbstractPreset
    public function common() {
        $name = 'YouTube';
        return [
            'id' => self::IDENTIFIER,
            'version' => self::VERSION,
            'name' => $name,
            'logoFile' => \DevOwl\RealCookieBanner\Core::getInstance()->getBaseAssetsUrl('logos/youtube.png'),
            'attributes' => [
                'name' => $name,
                'description' => __(
                    'Video from YouTube has been blocked because you did not allow to load it.',
                    \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED
                ),
                'hosts' => [
                    '*youtube.com*',
                    '*youtu.be*',
                    '*youtube-nocookie.com*',
                    '*ytimg.com*',
                    // [Plugin Comp] Elementor
                    'div[data-settings*="youtube_url"]'
                ],
                'cookies' => [\DevOwl\RealCookieBanner\presets\free\YoutubePreset::IDENTIFIER]
            ]
        ];
    }
}
