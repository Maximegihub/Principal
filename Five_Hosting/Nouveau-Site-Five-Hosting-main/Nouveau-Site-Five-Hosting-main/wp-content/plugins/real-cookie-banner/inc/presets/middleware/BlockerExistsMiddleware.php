<?php

namespace DevOwl\RealCookieBanner\presets\middleware;

use DevOwl\RealCookieBanner\presets\AbstractCookiePreset;
use DevOwl\RealCookieBanner\settings\Blocker;
use WP_Post;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Middleware to add a tag with label when the preset already exists.
 */
class BlockerExistsMiddleware {
    /**
     * See class description.
     *
     * @param array $preset
     * @param AbstractCookiePreset $instance Preset instance
     * @param WP_Post[] $existingBlocker
     * @param WP_Post[] $existingCookies
     */
    public function middleware(&$preset, $instance, $existingBlocker, $existingCookies) {
        $labelAlreadyExists = __('Already exists', RCB_TD);
        foreach ($existingBlocker as $blocker) {
            if ($blocker->metas[\DevOwl\RealCookieBanner\settings\Blocker::META_NAME_PRESET_ID] === $preset['id']) {
                $tooltipAlreadyExists = __('You have already created a Content Blocker with this template.', RCB_TD);
                $preset['tags'][$labelAlreadyExists] = $tooltipAlreadyExists;
                return $preset;
            }
        }
        // Mark hidden blocker presets as "Already exists" when the first service is created
        // This is useful especially for the scanner
        foreach ($existingCookies as $cookie) {
            if ($cookie->metas[\DevOwl\RealCookieBanner\settings\Blocker::META_NAME_PRESET_ID] === $preset['id']) {
                $tooltipAlreadyExists = __('You have already created a Service (Cookie) with this template.', RCB_TD);
                $preset['tags'][$labelAlreadyExists] = $tooltipAlreadyExists;
                break;
            }
        }
        return $preset;
    }
}
