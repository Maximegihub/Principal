<?php

namespace DevOwl\RealCookieBanner\scanner;

use DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\match\SelectorSyntaxMatch;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\AbstractBlockable;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\BlockedResult;
use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\Cache;
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\presets\BlockerPresets;
use DevOwl\RealCookieBanner\settings\Blocker;
use DevOwl\RealCookieBanner\Utils;
use DevOwl\RealCookieBanner\view\blockable\BlockerPostType;
use DevOwl\RealCookieBanner\Vendor\DevOwl\RealQueue\Core as RealQueueCore;
use DevOwl\RealCookieBanner\Vendor\DevOwl\RealQueue\queue\Job;
use stdClass;
use WP_User;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * This isn't really a "cookie" scanner, it is a scanner which detects external URLs,
 * scripts, iframes for the current page request. Additionally, it can automatically
 * detect usable content blocker presets which we can recommend to the user.
 */
class Scanner {
    use UtilsProvider;
    const QUERY_ARG_TOKEN = 'rcb-scan';
    const QUERY_ARG_JOB_ID = 'rcb-scan-job';
    const REAL_QUEUE_TYPE = 'rcb-scan';
    /**
     * See `findByRobots.txt`: This simulates to be the current blog to be public
     * so the `robots.txt` exposes a sitemap and also activates the sitemap.
     */
    const QUERY_ARG_FORCE_SITEMAP = 'rcb-force-sitemap';
    const IGNORE_LINK_REL = ['profile', 'author'];
    /**
     * Scan results.
     *
     * @var ScanEntry[]
     */
    private $results = [];
    /**
     * A list of excluded hosts.
     *
     * @param string[]
     */
    private $excludeHosts = [];
    private $persist;
    private $query;
    private $onChangeDetection;
    /**
     * C'tor.
     *
     * @codeCoverageIgnore
     */
    private function __construct() {
        // Exclude current host
        $currentHost = \parse_url(home_url(), \PHP_URL_HOST);
        $this->excludeHosts[] = $currentHost;
        $this->excludeHosts[] = \sprintf('www.%s', $currentHost);
        $this->excludeHosts[] = \preg_replace('/^www\\./', '', $currentHost);
        $this->query = new \DevOwl\RealCookieBanner\scanner\Query();
        $this->onChangeDetection = new \DevOwl\RealCookieBanner\scanner\OnChangeDetection($this);
    }
    /**
     * Force to enable the content blocker even when the content blocker is deactivated.
     *
     * @param boolean $enabled
     */
    public function force_blocker_enabled($enabled) {
        return isset($_GET[self::QUERY_ARG_TOKEN]) &&
            current_user_can(\DevOwl\RealCookieBanner\Vendor\DevOwl\RealQueue\Core::MINIMUM_QUERY_CAPABILITY)
            ? \true
            : $enabled;
    }
    /**
     * All presets and external URLs got catched, let's persist them to database.
     */
    public function teardown() {
        $query = $this->getQuery();
        // Get Job for this scan process
        $jobId = $_GET[self::QUERY_ARG_JOB_ID] ?? null;
        $job =
            $jobId > 0
                ? \DevOwl\RealCookieBanner\Core::getInstance()
                    ->getRealQueue()
                    ->getQuery()
                    ->fetchById($jobId)
                : null;
        // Memorize currently ignored hosts so we can re-ignore them
        $ignoredHosts = $query->getIgnoredHosts();
        // Memorize all found presets and external URL hosts so we can diff on them
        list($beforePresets, $beforeExternalHosts) = $query->getScannedCombinedResults();
        // Delete all known scan-entries for the current URL
        $query->removeSourceUrls([\DevOwl\RealCookieBanner\scanner\ScanEntry::getCurrentSourceUrl()]);
        // Add new scan entries
        $persist = new \DevOwl\RealCookieBanner\scanner\Persist($this->results);
        $persist->removePresetsWithNonMatchingMustHosts();
        $persist->deduplicate();
        // $persist->removePresetsWithoutExternalUrl();
        $persist->removeExternalUrlsCoveredByPreset();
        // Re-ignore
        foreach ($this->results as $entry) {
            $entry->calculateFields();
            if (\in_array($entry->blocked_url_host, $ignoredHosts, \true)) {
                $entry->ignored = \true;
            }
        }
        $persist->persist();
        list($afterPresets, $afterExternalHosts) = $query->getScannedCombinedResults();
        $this->doActionAddedRemoved($beforePresets, $beforeExternalHosts, $afterPresets, $afterExternalHosts);
        // Print result as HTML comment
        \printf('<!--rcb-scan:%s-->', \json_encode($persist->getEntries()));
        // Mark Job as succeed
        if ($job !== null) {
            $job->updateProcess(\true);
        }
    }
    /**
     * `do_action` when a result from the scanner got removed or added.
     *
     * @param string[] $beforePresets
     * @param string[] $beforeExternalHosts
     * @param string[] $afterPresets
     * @param string[] $afterExternalHosts
     */
    protected function doActionAddedRemoved($beforePresets, $beforeExternalHosts, $afterPresets, $afterExternalHosts) {
        $changed = \false;
        $addedPresets = [];
        $removedPresets = [];
        $addedExternalHosts = [];
        $removedExternalHosts = [];
        // Check if new preset / external URL host was found
        foreach ($afterPresets as $afterPreset) {
            if (!\in_array($afterPreset, $beforePresets, \true)) {
                /**
                 * A new preset was found for the scanner.
                 *
                 * @param {string} $preset
                 * @param {ScanEntry[]} $scanEntries
                 * @hook RCB/Scanner/Preset/Found
                 * @since 2.6.0
                 */
                do_action('RCB/Scanner/Preset/Found', $afterPreset, $this->results);
                $changed = \true;
                $addedPresets[] = $afterPreset;
            }
        }
        foreach ($afterExternalHosts as $afterExternalHost) {
            if (!\in_array($afterExternalHost, $beforeExternalHosts, \true)) {
                /**
                 * A new external host was found for the scanner.
                 *
                 * @param {string} $host
                 * @param {ScanEntry[]} $scanEntries
                 * @hook RCB/Scanner/ExternalHost/Found
                 * @since 2.6.0
                 */
                do_action('RCB/Scanner/ExternalHost/Found', $afterExternalHost, $this->results);
                $changed = \true;
                $addedExternalHosts[] = $afterExternalHost;
            }
        }
        // Check if preset / external URL host got removed
        foreach ($beforePresets as $beforePreset) {
            if (!\in_array($beforePreset, $afterPresets, \true)) {
                /**
                 * A preset was removed from the scanner results as it is no longer found on your site.
                 *
                 * @param {string} $preset
                 * @param {ScanEntry[]} $scanEntries
                 * @hook RCB/Scanner/Preset/Removed
                 * @since 2.6.0
                 */
                do_action('RCB/Scanner/Preset/Removed', $beforePreset, $this->results);
                $changed = \true;
                $removedPresets[] = $beforePreset;
            }
        }
        foreach ($beforeExternalHosts as $beforeExternalHost) {
            if (!\in_array($beforeExternalHost, $afterExternalHosts, \true)) {
                /**
                 * An external host was removed from the scanner results as it is no longer found on your site.
                 *
                 * @param {string} $host
                 * @param {ScanEntry[]} $scanEntries
                 * @hook RCB/Scanner/ExternalHost/Removed
                 * @since 2.6.0
                 */
                do_action('RCB/Scanner/ExternalHost/Removed', $beforeExternalHost, $this->results);
                $changed = \true;
                $removedExternalHosts[] = $beforeExternalHost;
            }
        }
        if ($changed) {
            /**
             * New items (presets and external hosts) got added or removed from the scanner result.
             *
             * @param {string[]} $addedPresets
             * @param {string[]} $addedExternalHosts
             * @param {string[]} $removedPresets
             * @param {string[]} $removedExternalHosts
             * @param {ScanEntry[]} $scanEntries
             * @hook RCB/Scanner/Result/Updated
             * @since 2.6.0
             */
            do_action(
                'RCB/Scanner/Result/Updated',
                $addedPresets,
                $addedExternalHosts,
                $removedPresets,
                $removedExternalHosts,
                $this->results
            );
        }
    }
    /**
     * Add all known and non-disabled content blocker presets.
     *
     * @param AbstractBlockable[] $blockables
     */
    public function resolve_blockables($blockables) {
        // Remove all known blockables because we want to show all found services (and label them with "Already exists")
        foreach ($blockables as $key => $blockable) {
            if ($blockable instanceof \DevOwl\RealCookieBanner\view\blockable\BlockerPostType) {
                unset($blockables[$key]);
            }
        }
        $presets = new \DevOwl\RealCookieBanner\presets\BlockerPresets();
        foreach ($presets->getAllFromCache() as $preset) {
            if ($preset['disabled']) {
                continue;
            }
            $identifier = $preset['identifier'];
            if (isset($preset[\DevOwl\RealCookieBanner\settings\Blocker::META_NAME_HOSTS])) {
                $blockables[] = new \DevOwl\RealCookieBanner\scanner\PresetBlockable(
                    $identifier,
                    $preset[\DevOwl\RealCookieBanner\settings\Blocker::META_NAME_HOSTS],
                    $preset['extended'] ?? null,
                    $preset['mustHosts'] ?? []
                );
            }
        }
        return $blockables;
    }
    /**
     * Memorize when a content got blocked through a non-created preset.
     *
     * @param BlockedResult $isBlocked
     * @param string $linkAttribute
     * @param string $link
     */
    public function is_blocked($isBlocked, $linkAttribute, $link) {
        // Check for some edge cases we want to exclude
        $attributes = $isBlocked->getAttributes();
        $tag = $isBlocked->getTag();
        $markup = $isBlocked->getMarkup();
        if (
            $tag === 'link' &&
            isset($attributes['rel']) &&
            \in_array($attributes['rel'], self::IGNORE_LINK_REL, \true)
        ) {
            return $isBlocked;
        }
        if (!$this->probablyMemorizeIsBlocked($isBlocked, $link, $tag)) {
            $this->probablyMemorizeExternalUrl($isBlocked, $link, $tag, $markup);
        }
        return $isBlocked;
    }
    /**
     * Memorize when an inline script got blocked through a non-created preset.
     *
     * @param BlockedResult $isBlocked
     */
    public function is_blocked_inline_script($isBlocked) {
        $this->probablyMemorizeIsBlocked($isBlocked, null, 'script');
        return $isBlocked;
    }
    /**
     * Memorize when an inline style got blocked through a non-created preset.
     *
     * @param BlockedResult $isBlocked
     * @param string $url
     */
    public function is_blocked_inline_style_rule($isBlocked, $url) {
        $this->probablyMemorizeIsBlocked($isBlocked, $url, 'style');
        return $isBlocked;
    }
    /**
     * Memorize when a custom element by CSS Selector got blocked through a non-created preset.
     *
     * @param BlockedResult $isBlocked
     * @param SelectorSyntaxMatch $m
     */
    public function is_blocked_selector_syntax($isBlocked, $m) {
        $this->probablyMemorizeIsBlocked($isBlocked, null, $m->getTag());
        return $isBlocked;
    }
    /**
     * Probably memorize an external URL when it got not blocked through preset nor created content blocker.
     *
     * @param BlockedResult $isBlocked
     * @param string $url
     * @param string $tag
     * @param string $markup
     */
    protected function probablyMemorizeExternalUrl($isBlocked, $url, $tag, $markup) {
        if (
            !$isBlocked->isBlocked() &&
            !\in_array($tag, ['a'], \true) &&
            \is_array($parseUrl = \parse_url($url)) &&
            isset($parseUrl['host']) &&
            \filter_var(\sprintf('http://%s', $parseUrl['host']), \FILTER_VALIDATE_URL) &&
            !\in_array($parseUrl['host'], $this->excludeHosts, \true)
        ) {
            $this->results[] = $entry = new \DevOwl\RealCookieBanner\scanner\ScanEntry();
            $entry->blocked_url = $url;
            $entry->tag = $tag;
            if (!empty($markup)) {
                $entry->markup = \trim($markup);
            }
        }
    }
    /**
     * Probably memorize a blocked content.
     *
     * @param BlockedResult $isBlocked
     * @param string $url
     * @param string $tag
     */
    protected function probablyMemorizeIsBlocked($isBlocked, $url, $tag) {
        $found = 0;
        // At least one non-existing created preset was used to block this content
        foreach ($isBlocked->getBlocked() as $blockable) {
            if ($blockable instanceof \DevOwl\RealCookieBanner\scanner\PresetBlockable) {
                $this->results[] = $entry = new \DevOwl\RealCookieBanner\scanner\ScanEntry();
                $entry->blockable = $blockable;
                $entry->preset = $blockable->getIdentifier();
                $entry->blocked_url = $url;
                $entry->tag = $tag;
                $entry->expressions = $isBlocked->getBlockedExpressions();
                // Inline scripts, styles and `SelectorSyntaxBlocker` support also the markup
                $markup = $isBlocked->getMarkup();
                if (!empty($markup)) {
                    $entry->markup = \trim($markup);
                }
                $found++;
            }
        }
        return $found > 0;
    }
    /**
     * Check if the current page request should be scanned.
     */
    public function isActive() {
        return isset($_GET[self::QUERY_ARG_TOKEN]) &&
            \DevOwl\RealCookieBanner\Core::getInstance()
                ->getRealQueue()
                ->currentUserAllowedToQuery();
    }
    /**
     * Force sitemaps in
     */
    public function probablyForceSitemaps() {
        if (!isset($_GET[\DevOwl\RealCookieBanner\scanner\Scanner::QUERY_ARG_FORCE_SITEMAP])) {
            return;
        }
        $cbEnableSitemaps = function ($val) {
            return \function_exists('wp_get_current_user') &&
                current_user_can(\DevOwl\RealCookieBanner\Core::MANAGE_MIN_CAPABILITY)
                ? \true
                : $val;
        };
        $cbStylesheetUrl = function ($url) {
            return add_query_arg([self::QUERY_ARG_FORCE_SITEMAP => 1], $url);
        };
        add_filter('pre_option_blog_public', $cbEnableSitemaps, 999);
        add_filter('wp_sitemaps_enabled', $cbEnableSitemaps, 999);
        add_filter(
            'wp_sitemaps_index_entry',
            function ($entry) {
                if (isset($entry['loc'])) {
                    $entry['loc'] = add_query_arg([self::QUERY_ARG_FORCE_SITEMAP => 1], $entry['loc']);
                }
                return $entry;
            },
            \PHP_INT_MAX
        );
        add_filter('wp_sitemaps_stylesheet_index_url', $cbStylesheetUrl, \PHP_INT_MAX);
        add_filter('wp_sitemaps_stylesheet_url', $cbStylesheetUrl, \PHP_INT_MAX);
    }
    /**
     * Add URLs to the queue so they get scanned.
     *
     * @param string[] $urls
     * @param boolean $purgeUnused  If `true`, the difference of the previous scanned URLs gets
     *                              automatically purged if they do no longer exist in the URLs (pass only if you have the complete sitemap!)
     */
    public function addUrlsToQueue($urls, $purgeUnused = \false) {
        $queue = \DevOwl\RealCookieBanner\Core::getInstance()->getRealQueue();
        $persist = $queue->getPersist();
        $query = $queue->getQuery();
        $persist->startTransaction();
        // Only sitemap crawlers should be grouped
        if ($purgeUnused) {
            $persist->startGroup();
        }
        foreach ($urls as $url) {
            if (\filter_var($url, \FILTER_VALIDATE_URL)) {
                // Check if a Job with this URL already exists
                if (!$purgeUnused) {
                    $found = $query->read(['type' => 'all', 'dataContains' => \json_encode($url)]);
                    if (\count($found) > 0) {
                        continue;
                    }
                }
                $job = new \DevOwl\RealCookieBanner\Vendor\DevOwl\RealQueue\queue\Job($queue);
                $job->worker = \DevOwl\RealCookieBanner\Vendor\DevOwl\RealQueue\queue\Job::WORKER_CLIENT;
                $job->type = self::REAL_QUEUE_TYPE;
                $job->data = new \stdClass();
                $job->data->url = $url;
                $job->retries = 3;
                $persist->addJob($job);
            }
        }
        if ($purgeUnused) {
            // This is a complete sitemap
            $this->purgeUnused($urls);
            \DevOwl\RealCookieBanner\Cache::getInstance()->invalidate();
        }
        return $persist->commit();
    }
    /**
     * Read a group of all known site URLs and delete them if they no longer exist in the passed URLs.
     *
     * @param string[] $urls
     */
    public function purgeUnused($urls) {
        $knownUrls = $this->getQuery()->getScannedSourceUrls();
        $deleted = \array_values(\array_diff($knownUrls, $urls));
        $this->getQuery()->removeSourceUrls($deleted);
        return \count($deleted);
    }
    /**
     * Get human-readable label for RCB queue jobs.
     *
     * @param string $label
     * @param string $originalType
     */
    public function real_queue_job_label($label, $originalType) {
        switch ($originalType) {
            case self::REAL_QUEUE_TYPE:
                return __('Real Cookie Banner: Scan of your pages', RCB_TD);
            case \DevOwl\RealCookieBanner\scanner\AutomaticScanStarter::REAL_QUEUE_TYPE:
                return __('Real Cookie Banner: Automatic scan of complete website', RCB_TD);
            default:
                return $label;
        }
    }
    /**
     * Get actions for RCB queue jobs.
     *
     * @param array[] $actions
     * @param string $type
     */
    public function real_queue_job_actions($actions, $type) {
        switch ($type) {
            case self::REAL_QUEUE_TYPE:
            case \DevOwl\RealCookieBanner\scanner\AutomaticScanStarter::REAL_QUEUE_TYPE:
                $actions[] = [
                    'url' => __('https://devowl.io/support/', RCB_TD),
                    'linkText' => __('Contact support', RCB_TD)
                ];
                break;
            default:
        }
        return $actions;
    }
    /**
     * Get human-readable description for a RCB queue jobs.
     *
     * @param string $description
     * @param string $type
     * @param int[] $remaining
     */
    public function real_queue_error_description($description, $type, $remaining) {
        switch ($type) {
            case self::REAL_QUEUE_TYPE:
                return \sprintf(
                    // translators:
                    __('%1$d pages failed to be scanned.', RCB_TD),
                    $remaining['failure']
                );
            case \DevOwl\RealCookieBanner\scanner\AutomaticScanStarter::REAL_QUEUE_TYPE:
                return __(
                    'Real Cookie Banner tried to automatically scan your entire website for services and external URLs.',
                    RCB_TD
                );
            default:
                return $description;
        }
    }
    /**
     * Remove some capabilities and roles from the current user for the running page request.
     * For example, some Google Analytics plugins do only print out the analytics code when
     * not `manage_options` (e.g. WooCommerce Google Analytics).
     *
     * @param array $caps
     * @see https://regex101.com/r/3U3miS/1
     */
    public function reduceCurrentUserPermissions() {
        global $current_user;
        add_action('user_has_cap', function ($caps) {
            $caps['administrator'] = \false;
            $caps['manage_options'] = \false;
            return $caps;
        });
        if ($current_user instanceof \WP_User && \count($current_user->roles) > 0) {
            $current_user->roles = \array_filter($current_user->roles, function ($role) {
                return !\in_array($role, ['administrator'], \true);
            });
            // We never should write back roles back to database!
            // In general, never update a user meta as it is not needed while scanning a site.
            add_filter('update_user_metadata', '__return_false', \PHP_INT_MAX);
            add_filter('add_user_metadata', '__return_false', \PHP_INT_MAX);
        }
    }
    /**
     * Bypass website blockers like "Coming soon" plugins.
     */
    public function bypassWebsiteBlockers() {
        // [Plugin comp] https://wordpress.org/plugins/cmp-coming-soon-maintenance/
        add_filter('pre_option_niteoCS_status', function () {
            return '0';
        });
        // [Plugin comp] https://wordpress.org/plugins/under-construction-page/
        add_filter('ucp_is_construction_mode_enabled', '__return_false');
    }
    /**
     * Getter.
     *
     * @codeCoverageIgnore
     */
    public function getQuery() {
        return $this->query;
    }
    /**
     * Getter.
     *
     * @codeCoverageIgnore
     */
    public function getOnChangeDetection() {
        return $this->onChangeDetection;
    }
    /**
     * New instance.
     *
     * @codeCoverageIgnore
     */
    public static function instance() {
        return new \DevOwl\RealCookieBanner\scanner\Scanner();
    }
}
