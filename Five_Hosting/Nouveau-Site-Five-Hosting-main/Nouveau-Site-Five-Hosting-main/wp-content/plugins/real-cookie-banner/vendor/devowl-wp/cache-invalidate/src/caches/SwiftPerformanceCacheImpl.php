<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches;

use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\AbstractCache;
use Swift_Performance_Cache;
use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\ExcludeAssets;
/**
 * Swift Performance.
 *
 * @see https://wordpress.org/plugins/swift-performance-lite/
 * @codeCoverageIgnore
 */
class SwiftPerformanceCacheImpl extends \DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\AbstractCache {
    const IDENTIFIER = 'swift-performance';
    // Documented in AbstractCache
    public function isActive() {
        return \class_exists(\Swift_Performance_Cache::class);
    }
    // Documented in AbstractCache
    public function invalidate() {
        \error_log('invalidate');
        return \Swift_Performance_Cache::clear_all_cache();
    }
    /**
     * Exclude JavaScript and CSS assets.
     *
     * @param ExcludeAssets $excludeAssets
     */
    public function excludeAssetsHook($excludeAssets) {
        foreach ([['script', 'js'], ['style', 'css']] as $row) {
            list($type, $mime) = $row;
            add_filter(\sprintf('swift_performance_option_exclude-%ss', $type), function ($excluded) use (
                $mime,
                $excludeAssets
            ) {
                if (\is_array($excluded)) {
                    $path = $excludeAssets->getAllUrlPath($mime);
                    return \array_merge($excluded, $path);
                }
                return $excluded;
            });
        }
    }
    // Documented in AbstractCache
    public function label() {
        return 'Swift Performance';
    }
}
