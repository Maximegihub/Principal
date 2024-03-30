<?php

namespace DevOwl\RealCookieBanner\presets\middleware;

use DevOwl\RealCookieBanner\settings\Cookie;
use DevOwl\RealCookieBanner\Utils;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Middleware to enable `attributes.disableTechnicalHandlingThroughPlugin` in cookie and content blocker presets.
 */
class DisableTechnicalHandlingThroughPluginMiddleware {
    /**
     * Pass preset metadata with attributes and disable the technical handling attributes when
     * a given plugin is active.
     *
     * @param array $preset
     */
    public function middleware(&$preset) {
        if (isset($preset['attributes']) && isset($preset['attributes']['disableTechnicalHandlingThroughPlugin'])) {
            $plugins = $preset['attributes']['disableTechnicalHandlingThroughPlugin'];
            foreach ($plugins as $plugin) {
                if (\DevOwl\RealCookieBanner\Utils::isPluginActive($plugin)) {
                    // Deactivate all technical handling
                    foreach (\DevOwl\RealCookieBanner\settings\Cookie::TECHNICAL_HANDLING_META_COLLECTION as $key) {
                        if (isset($preset['attributes'][$key])) {
                            unset($preset['attributes'][$key]);
                        }
                    }
                    // Show a notice to the user
                    $oldNotice = $preset['attributes']['technicalHandlingNotice'] ?? '';
                    $preset['attributes']['technicalHandlingNotice'] =
                        \sprintf(
                            // translators:
                            __(
                                'You don\'t have to define a technical handling here, because this is done by the plugin <strong>%s</strong>.',
                                RCB_TD
                            ),
                            \DevOwl\RealCookieBanner\Utils::getActivePluginsMap()[$plugin]
                        ) . (empty($oldNotice) ? '' : \sprintf('<br /><br />%s', $oldNotice));
                    break;
                }
            }
            unset($preset['attributes']['disableTechnicalHandlingThroughPlugin']);
        }
        return $preset;
    }
}
