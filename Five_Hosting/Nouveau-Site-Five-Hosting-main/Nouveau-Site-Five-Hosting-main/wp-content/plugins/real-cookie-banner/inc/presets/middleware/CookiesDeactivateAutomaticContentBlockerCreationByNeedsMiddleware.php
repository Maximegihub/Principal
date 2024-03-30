<?php

namespace DevOwl\RealCookieBanner\presets\middleware;

// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Middleware that adds a `attributes.deactivateAutomaticContentBlockerCreationByNeeds` attribute and automatically
 * set `attributes.deactivateAutomaticContentBlockerCreation` determined by active plugins.
 */
class CookiesDeactivateAutomaticContentBlockerCreationByNeedsMiddleware {
    const PROPERTY = 'deactivateAutomaticContentBlockerCreationByNeeds';
    const PROPERTY_TO_SET = 'deactivateAutomaticContentBlockerCreation';
    /**
     * See class description.
     *
     * @param array $preset
     */
    public function middleware(&$preset) {
        if (isset($preset['attributes'], $preset['attributes'][self::PROPERTY])) {
            $preset['attributes'][
                self::PROPERTY_TO_SET
            ] = !\DevOwl\RealCookieBanner\presets\middleware\DisablePresetByNeedsMiddleware::check(
                $preset['attributes'][self::PROPERTY],
                $preset['id'],
                'cookie'
            );
            unset($preset['attributes'][self::PROPERTY]);
        }
        return $preset;
    }
}
