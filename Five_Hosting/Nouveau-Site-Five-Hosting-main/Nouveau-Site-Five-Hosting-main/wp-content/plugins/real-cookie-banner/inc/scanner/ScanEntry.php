<?php

namespace DevOwl\RealCookieBanner\scanner;

use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\Utils;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * A scan result which can be persisted to the database.
 */
class ScanEntry {
    use UtilsProvider;
    /**
     * The preset blockable which caused this scan entry to be found. This
     * property is only filled for the scan process itself!
     *
     * @var PresetBlockable
     */
    public $blockable;
    /**
     * The expression of the `host` which is used while found this scan entry. This
     * property is only filled for the scan process itself!
     *
     * @var string[]
     */
    public $expressions = [];
    /**
     * ID.
     *
     * @var int
     */
    public $id;
    /**
     * Preset identifier for the content blocker.
     *
     * @var string
     */
    public $preset = '';
    /**
     * The found blocked URL.
     *
     * @var string
     */
    public $blocked_url;
    /**
     * The found blocked URL (only the host) for grouping purposes.
     *
     * @var string
     */
    public $blocked_url_host;
    /**
     * The found blocked URL as hash to be used as `UNIQUE KEY`.
     *
     * @var string
     */
    public $blocked_url_hash = '';
    /**
     * Markup of the blocked element. This is only set for inline scripts, inline styles
     * and presets with `SelectorSyntaxBlocker`.
     *
     * @var string
     */
    public $markup;
    /**
     * Hash of the markup. Useful to make distinct queries.
     *
     * @var string
     */
    public $markup_hash;
    /**
     * The blockable HTML tag.
     *
     * @var string
     */
    public $tag;
    /**
     * The `post_id` of `wp_posts` this entry refers to.
     *
     * @var int
     */
    public $post_id;
    /**
     * The source URL this entry was found.
     *
     * @var string
     */
    public $source_url;
    /**
     * The source URL this entry was found as hash to be used as `UNIQUE KEY`.
     *
     * @var string
     */
    public $source_url_hash;
    /**
     * Got his entry ignored?
     *
     * @var boolean
     */
    public $ignored;
    /**
     * Created time (ISO).
     *
     * @var string
     */
    public $created;
    /**
     * Calculate some fields. This is necessary, so we do not need to always calculate
     * hashes and hosts.
     */
    public function calculateFields() {
        if (!empty($this->blocked_url)) {
            $this->blocked_url_hash = \md5($this->blocked_url);
            $this->blocked_url_host = \parse_url($this->blocked_url, \PHP_URL_HOST);
            $this->blocked_url_host = \preg_replace('/^www\\./', '', $this->blocked_url_host);
        }
        $post_id = get_the_ID();
        if ($post_id !== \false) {
            $this->post_id = $post_id;
        }
        $this->source_url = self::getCurrentSourceUrl();
        $this->source_url_hash = \md5($this->source_url);
        if (!empty($this->markup)) {
            $this->markup_hash = \md5($this->markup);
        }
    }
    /**
     * Get the current source URL usable for a newly created `ScanEntry`.
     */
    public static function getCurrentSourceUrl() {
        $result = remove_query_arg(
            \DevOwl\RealCookieBanner\scanner\Scanner::QUERY_ARG_TOKEN,
            \DevOwl\RealCookieBanner\Utils::getRequestUrl()
        );
        return remove_query_arg(\DevOwl\RealCookieBanner\scanner\Scanner::QUERY_ARG_JOB_ID, $result);
    }
}
