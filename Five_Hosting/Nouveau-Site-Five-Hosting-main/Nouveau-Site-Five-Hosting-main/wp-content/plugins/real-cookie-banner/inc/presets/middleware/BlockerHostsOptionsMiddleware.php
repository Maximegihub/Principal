<?php

namespace DevOwl\RealCookieBanner\presets\middleware;

use DevOwl\RealCookieBanner\presets\AbstractBlockerPreset;
use DevOwl\RealCookieBanner\presets\AbstractCookiePreset;
use WP_Post;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Middleware that adds a `mustHosts` attribute to the blocker metadata from `hosts` options.
 *
 * Available options:
 *
 * ```
 * "hosts" => [
 *     ["*google.com/recaptcha*", [
 *         // This is necessary for the scanner: If a host is marked as must, the URL must exist when scanning
 *         // In this case `recaptcha` is the "must-group", that means one of the hosts must be available within the group
 *         BlockerHostsOptionsMiddleware::LOGICAL_MUST => self::IDENTIFIER // can be another string if you want to group multiple hosts with OR in a group
 *     ]]
 * ]
 * ```
 */
class BlockerHostsOptionsMiddleware {
    const LOGICAL_MUST = 'must';
    /**
     * See class description.
     *
     * @param array $preset
     * @param AbstractBlockerPreset|AbstractCookiePreset $unused0
     * @param WP_Post[] $unused1
     * @param WP_Post[] $unused2
     * @param array $result
     */
    public function middleware(&$preset, $unused0, $unused1, $unused2, &$result) {
        if (isset($preset['attributes'], $preset['attributes']['hosts'])) {
            // Allow middleware also for extended blockers
            if (
                isset($preset['extended']) &&
                isset($result[$preset['extended']], $result[$preset['extended']]['mustHosts'])
            ) {
                $preset['mustHosts'] = $result[$preset['extended']]['mustHosts'];
            }
            foreach ($preset['attributes']['hosts'] as $key => $host) {
                if (\is_array($host)) {
                    $preset['attributes']['hosts'][$key] = $host[0];
                    $options = wp_parse_args($host[1], [self::LOGICAL_MUST => \false]);
                    // `must`
                    if ($options[self::LOGICAL_MUST] !== \false) {
                        $preset['mustHosts'][$options[self::LOGICAL_MUST]][] = $host[0];
                    }
                }
            }
        }
        return $preset;
    }
}
