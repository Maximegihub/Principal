<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate;

/**
 * Implement a cache mechanism / plugin.
 */
abstract class AbstractCache {
    /**
     * Check if the caching mechanism / plugin is active and available.
     *
     * @return boolean
     */
    abstract public function isActive();
    /**
     * Trigger a cache invalidation.
     *
     * @return mixed
     */
    abstract public function invalidate();
    /**
     * Returns `true` if the plugin does not support excluding assets but has the feature in general.
     * Returns `void` if the does not have this feature or when excluding is supported.
     *
     * @return void|boolean
     */
    public function failureExcludeAssets() {
        // Silence is golden.
    }
    /**
     * Exclude JavaScript and CSS assets.
     *
     * @param ExcludeAssets $excludeAssets
     * @return void|false Returns `false` if the plugin does not support excluding assets but has the feature in general
     */
    public function excludeAssetsHook($excludeAssets) {
        // Silence is golden.
    }
    /**
     * Get the label.
     */
    abstract public function label();
}
