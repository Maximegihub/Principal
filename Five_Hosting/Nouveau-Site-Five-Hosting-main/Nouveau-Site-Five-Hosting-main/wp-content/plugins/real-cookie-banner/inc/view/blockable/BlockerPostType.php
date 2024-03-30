<?php

namespace DevOwl\RealCookieBanner\view\blockable;

use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\AbstractBlockable;
use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\lite\settings\TcfVendorConfiguration;
use DevOwl\RealCookieBanner\settings\Blocker;
use WP_Post;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Describe a blockable item by `WP_Post` custom post type.
 */
class BlockerPostType extends \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\AbstractBlockable {
    use UtilsProvider;
    private $post;
    /**
     * C'tor.
     *
     * @param WP_Post $post
     * @codeCoverageIgnore
     */
    public function __construct($post) {
        $this->post = $post;
        $this->appendFromStringArray($post->metas[\DevOwl\RealCookieBanner\settings\Blocker::META_NAME_HOSTS]);
    }
    // Documented in Blockable
    public function getBlockerId() {
        return $this->getPost()->ID;
    }
    // Documented in Blockable
    public function getRequiredIds() {
        $metas = $this->getPost()->metas;
        $criteria = $metas[\DevOwl\RealCookieBanner\settings\Blocker::META_NAME_CRITERIA];
        $cookieIds = [];
        switch ($criteria) {
            case \DevOwl\RealCookieBanner\settings\Blocker::CRITERIA_TCF_VENDORS:
                // Map Custom Post Type Post ID to vendor ID
                $tcfVendorConfigurations = \DevOwl\RealCookieBanner\lite\settings\TcfVendorConfiguration::getInstance()->getOrdered();
                $cookieIds = \array_map(function ($postId) use ($tcfVendorConfigurations) {
                    foreach ($tcfVendorConfigurations as $tcfVendorConfiguration) {
                        if ($tcfVendorConfiguration->ID === $postId) {
                            return $tcfVendorConfiguration->metas[
                                \DevOwl\RealCookieBanner\lite\settings\TcfVendorConfiguration::META_NAME_VENDOR_ID
                            ];
                        }
                    }
                    return 0;
                }, $metas[\DevOwl\RealCookieBanner\settings\Blocker::META_NAME_TCF_VENDORS]);
                break;
            default:
                $cookieIds = $metas[\DevOwl\RealCookieBanner\settings\Blocker::META_NAME_COOKIES];
                break;
        }
        return $cookieIds;
    }
    // Documented in Blockable
    public function getCriteria() {
        return $this->getPost()->metas[\DevOwl\RealCookieBanner\settings\Blocker::META_NAME_CRITERIA];
    }
    /**
     * Getter.
     *
     * @codeCoverageIgnore
     */
    public function getPost() {
        return $this->post;
    }
}
