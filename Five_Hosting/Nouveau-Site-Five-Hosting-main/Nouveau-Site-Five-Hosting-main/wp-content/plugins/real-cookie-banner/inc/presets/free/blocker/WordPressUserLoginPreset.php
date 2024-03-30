<?php

namespace DevOwl\RealCookieBanner\presets\free\blocker;

use DevOwl\RealCookieBanner\comp\language\Hooks;
use DevOwl\RealCookieBanner\presets\AbstractBlockerPreset;
use DevOwl\RealCookieBanner\presets\free\WordPressUserLoginPreset as FreeWordPressUserLoginPreset;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * WordPress User Login blocker preset.
 */
class WordPressUserLoginPreset extends \DevOwl\RealCookieBanner\presets\AbstractBlockerPreset {
    const IDENTIFIER = \DevOwl\RealCookieBanner\presets\free\WordPressUserLoginPreset::IDENTIFIER;
    const VERSION = 1;
    // Documented in AbstractPreset
    public function common() {
        return [
            'id' => self::IDENTIFIER,
            'version' => self::VERSION,
            'name' => __('WordPress User Login', RCB_TD),
            'logoFile' => admin_url('images/wordpress-logo.svg'),
            'attributes' => [
                'name' => __('WordPress User Login', \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED),
                'description' => __(
                    'In order to log in, you must allow us to load additional services for security and convenience reasons.',
                    \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED
                ),
                'hosts' => ['form[name="loginform"]'],
                'cookies' => [\DevOwl\RealCookieBanner\presets\free\WordPressUserLoginPreset::IDENTIFIER],
                'visual' => \true
            ]
        ];
    }
}
