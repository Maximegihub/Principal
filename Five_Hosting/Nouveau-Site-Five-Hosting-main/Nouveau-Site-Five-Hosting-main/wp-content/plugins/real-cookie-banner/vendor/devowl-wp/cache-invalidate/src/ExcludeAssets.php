<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate;

use _WP_Dependency;
use DevOwl\RealCookieBanner\Vendor\MatthiasWeb\Utils\PluginReceiver;
/**
 * Use this class to exclude JavaScript and Stylesheets from caching plugins.
 * Initialize this class in your `init` action!
 *
 * @see https://app.clickup.com/t/h75rh2
 */
class ExcludeAssets {
    private $pluginReceiver;
    /**
     * Handles to block.
     */
    private $handles = ['js' => [], 'css' => []];
    /**
     * C'tor.
     *
     * @param PluginReceiver $pluginReceiver
     * @codeCoverageIgnore
     */
    public function __construct($pluginReceiver) {
        $this->pluginReceiver = $pluginReceiver;
        $this->init();
    }
    /**
     * Initialize the hook for active cache plugins and pass down
     * the `WP_Dependency` to the abstract implementation.
     */
    public function init() {
        $activeCaches = \DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\CacheInvalidator::getInstance()->getCaches();
        foreach ($activeCaches as $cache) {
            $cache->excludeAssetsHook($this);
        }
    }
    /**
     * Checks if the current WordPress instance has a plugin active which does in general
     * support the exclusion of assets, but doing this will result in a defect page or is
     * not supported programmatically atm.
     */
    public function hasFailureSupportPluginActive() {
        $activeCaches = \DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\CacheInvalidator::getInstance()->getCaches();
        foreach ($activeCaches as $cache) {
            if ($cache->failureExcludeAssets() === \true) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * Get all URL path without query arguments and leading slash.
     *
     * @param string $type Can be `css` or `js`
     */
    public function getAllUrlPath($type) {
        $result = [];
        foreach ($this->getDependencies($type) as $dep) {
            $path = $this->getUrlPath($dep);
            if ($path !== \false) {
                $result[] = $path;
            }
        }
        return $result;
    }
    /**
     * Get only the URL path without query arguments and leading slash.
     *
     * @param _WP_Dependency $dep
     */
    public function getUrlPath($dep) {
        $path = \parse_url($dep->src, \PHP_URL_PATH);
        return \is_string($path) ? \trim($path, '/') : \false;
    }
    /**
     * Get `_WP_Dependency` for all available assets.
     *
     * @param string $type Can be `css` or `js`
     * @return _WP_Dependency[]
     */
    public function getDependencies($type) {
        $result = [];
        $wp_dependencies = $type === 'js' ? wp_scripts() : wp_styles();
        foreach ($this->handles[$type] as $handle) {
            $dep = $wp_dependencies->query($handle);
            if ($dep instanceof \_WP_Dependency) {
                $result[] = $dep;
            }
        }
        return $result;
    }
    /**
     * Exclude a given handle.
     *
     * @param string $type Can be `css` or `js`
     * @param string|string[] $handles Registered handle via `wp_enqueue_script`
     */
    public function byHandle($type, $handles) {
        $handles = \is_array($handles) ? $handles : [$handles];
        // Add `vendor-` also to the handles for `probablyEnqueueChunk` compatibility
        foreach ($handles as $handle) {
            \array_unshift($handles, \sprintf('vendor-%s', $handle));
            \array_unshift(
                $handles,
                \sprintf(
                    '%s-vendor-%s',
                    $this->pluginReceiver->getPluginConstant(
                        \DevOwl\RealCookieBanner\Vendor\MatthiasWeb\Utils\PluginReceiver::$PLUGIN_CONST_SLUG
                    ),
                    $handle
                )
            );
        }
        $this->handles[$type] = \array_merge($this->handles[$type], $handles);
    }
    /**
     * Getter.
     *
     * @codeCoverageIgnore
     */
    public function getHandles() {
        return $this->handles;
    }
}
