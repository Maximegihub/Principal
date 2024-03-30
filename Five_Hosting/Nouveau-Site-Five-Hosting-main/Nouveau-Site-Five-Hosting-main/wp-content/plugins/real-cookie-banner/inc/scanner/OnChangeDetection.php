<?php

namespace DevOwl\RealCookieBanner\scanner;

use DevOwl\RealCookieBanner\base\UtilsProvider;
use WP_Post;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Automatically detect changes to pages and posts, or CPT's and scan them again.
 */
class OnChangeDetection {
    use UtilsProvider;
    private $scanner;
    /**
     * C'tor.
     *
     * @param Scanner $scanner
     * @codeCoverageIgnore
     */
    public function __construct($scanner) {
        $this->scanner = $scanner;
    }
    /**
     * A post got updated or created, add it to our queue.
     *
     * @param int $post_id
     * @param WP_Post $post
     */
    public function save_post($post_id, $post) {
        $this->fromPost($post);
    }
    /**
     * The `post_updated` hook is fired before `save_post` so we can identify if the slug has been changed (parent or slug).
     *
     * @param int $post_id
     * @param WP_Post $post_after
     * @param WP_Post $post_before
     */
    public function post_updated($post_id, $post_after, $post_before) {
        $permalinkAfter = $this->getPermalink($post_after);
        $permalinkBefore = $this->getPermalink($post_before);
        if ($permalinkAfter !== $permalinkBefore) {
            $this->scanner->getQuery()->removeSourceUrls([$permalinkBefore]);
        }
    }
    /**
     * A post got deleted. Remove the URL from the scan results.
     *
     * @param int $post_id
     */
    public function delete_post($post_id) {
        $post = get_post($post_id);
        if ($post) {
            $link = $this->getPermalink($post);
            if (!empty($link)) {
                $this->scanner->getQuery()->removeSourceUrls([$link]);
            }
        }
    }
    /**
     * A post got moved to the trash. Remove the URL from the scan results.
     *
     * @param int $post_id
     */
    public function wp_trash_post($post_id) {
        $link = $this->getPermalink(get_post($post_id));
        if (!empty($link)) {
            $this->scanner->getQuery()->removeSourceUrls([$link]);
        }
    }
    /**
     * Check if the post can be queried publicly and add it to our queue.
     *
     * @param WP_Post $post
     */
    protected function fromPost($post) {
        if (is_post_type_viewable($post->post_type)) {
            $link = $this->getPermalink($post);
            if (!empty($link)) {
                if ($post->post_status === 'publish') {
                    $this->scanner->addUrlsToQueue([$link]);
                } else {
                    // Handle e.g. "Draft" like a deletion
                    $this->scanner->getQuery()->removeSourceUrls([$link]);
                }
            }
        }
    }
    /**
     * Always create a clone of the post cause we need to force the `post_status` to get the valid permalink.
     *
     * @param WP_Post $post
     * @see https://wordpress.stackexchange.com/a/42988/83335
     */
    protected function getPermalink($post) {
        $clone = clone $post;
        if ($clone->post_status === 'trash') {
            $clone->post_name = \preg_replace('/__trashed$/', '', $clone->post_name);
        }
        $clone->post_status = 'publish';
        $clone->post_name = sanitize_title($clone->post_name ? $clone->post_name : $clone->post_title, $clone->ID);
        return get_permalink($clone);
    }
    /**
     * Getter.
     *
     * @codeCoverageIgnore
     */
    public function getQuery() {
        return $this->query;
    }
}
