<?php

namespace DevOwl\RealCookieBanner\presets\free\blocker;

use DevOwl\RealCookieBanner\presets\free\WordPressCommentsPreset as PresetsWordPressCommentsPreset;
use DevOwl\RealCookieBanner\presets\AbstractBlockerPreset;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * WordPress Comments blocker preset.
 */
class WordPressCommentsPreset extends \DevOwl\RealCookieBanner\presets\AbstractBlockerPreset {
    const IDENTIFIER = \DevOwl\RealCookieBanner\presets\free\WordPressCommentsPreset::IDENTIFIER;
    const VERSION = 1;
    // Documented in AbstractPreset
    public function common() {
        $name = __('WordPress Comments', RCB_TD);
        return [
            'id' => self::IDENTIFIER,
            'version' => self::VERSION,
            'name' => $name,
            'logoFile' => admin_url('images/wordpress-logo.svg'),
            'hidden' => \true,
            'attributes' => [
                'hosts' => ['form[action*="wp-comments-post.php"]'],
                'cookies' => [\DevOwl\RealCookieBanner\presets\free\WordPressCommentsPreset::IDENTIFIER]
            ]
        ];
    }
}
