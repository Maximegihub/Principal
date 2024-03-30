<?php

namespace DevOwl\RealCookieBanner\scanner;

use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants;
use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\settings\Blocker;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Query scan results.
 */
class Query {
    use UtilsProvider;
    const MIME_TYPE_JAVASCRIPT = 'text/javascript';
    const MIME_TYPE_CSS = 'text/css';
    const MIME_TYPE_HTML = 'text/html';
    /**
     * C'tor.
     *
     * @codeCoverageIgnore
     */
    public function __construct() {
        // Silence is golden.
    }
    /**
     * Get markup by ID. This also returns the mime type used for the blocked content.
     * This can also be `null` when the scanned element is only blocked by URL (e.g. not
     * by inline script, style or `SelectorSyntaxBlocker`).
     *
     * @param int|int[] $ids
     */
    public function getMarkup($ids) {
        global $wpdb;
        $table_name = $this->getTableName(\DevOwl\RealCookieBanner\scanner\Persist::TABLE_NAME);
        $multiple = \is_array($ids);
        $ids = \array_map('intval', $multiple ? $ids : [$ids]);
        $where = \sprintf('id IN (%s)', \join(',', $ids));
        $sql = \sprintf(
            "SELECT\n                id,\n                tag,\n                CASE\n                    WHEN markup LIKE '<%%' THEN '%s'\n                    WHEN tag = 'script' THEN '%s'\n                    WHEN tag = 'style' THEN '%s'\n                    ELSE '%s'\n                END AS mime,\n                markup,\n                markup_hash\n            FROM {$table_name} WHERE {$where}",
            self::MIME_TYPE_HTML,
            self::MIME_TYPE_JAVASCRIPT,
            self::MIME_TYPE_CSS,
            self::MIME_TYPE_HTML
        );
        // phpcs:disable WordPress.DB.PreparedSQL
        $result = $multiple ? $wpdb->get_results($sql, ARRAY_A) : $wpdb->get_row($sql, ARRAY_A);
        // phpcs:enable WordPress.DB.PreparedSQL
        // Cast
        if ($multiple) {
            foreach ($result as &$row) {
                $row['id'] = \intval($row['id']);
            }
        } else {
            $result['id'] = \intval($result['id']);
        }
        return $result;
    }
    /**
     * Get all (known) scanned pages.
     */
    public function getScannedSourceUrls() {
        global $wpdb;
        $table_name = $this->getTableName(\DevOwl\RealCookieBanner\scanner\Persist::TABLE_NAME);
        // phpcs:disable WordPress.DB.PreparedSQL
        $rows = $wpdb->get_col("SELECT source_url FROM {$table_name} GROUP BY source_url");
        // phpcs:enable WordPress.DB.PreparedSQL
        return $rows;
    }
    /**
     * Get all ignored hosts. This is needed e.g. to re-ignore new scan entries.
     */
    public function getIgnoredHosts() {
        global $wpdb;
        $table_name = $this->getTableName(\DevOwl\RealCookieBanner\scanner\Persist::TABLE_NAME);
        // phpcs:disable WordPress.DB.PreparedSQL
        $rows = $wpdb->get_col(
            "SELECT blocked_url_host FROM {$table_name} WHERE ignored = 1 GROUP BY blocked_url_host"
        );
        // phpcs:enable WordPress.DB.PreparedSQL
        return $rows;
    }
    /**
     * Remove scanned entries by source urls. This can be useful if you know a page got deleted.
     *
     * @param string[] $urls
     * @return int
     */
    public function removeSourceUrls($urls) {
        global $wpdb;
        if (\count($urls) > 0) {
            $table_name = $this->getTableName(\DevOwl\RealCookieBanner\scanner\Persist::TABLE_NAME);
            $urls = \array_map(function ($url) use ($wpdb) {
                return $wpdb->prepare('%s', $url);
            }, $urls);
            $sqlIn = \join(',', $urls);
            // phpcs:disable WordPress.DB.PreparedSQL
            return $wpdb->query("DELETE FROM {$table_name} WHERE source_url IN ({$sqlIn})");
            // phpcs:enable WordPress.DB.PreparedSQL
        }
        return 0;
    }
    /**
     * Ignore blocked URLs by host.
     *
     * @param string[] $hosts
     * @param boolean $state Set to `false` to unignore the host
     * @return int
     */
    public function ignoreBlockedUrlHosts($hosts, $state = \true) {
        global $wpdb;
        if (\count($hosts) > 0) {
            $table_name = $this->getTableName(\DevOwl\RealCookieBanner\scanner\Persist::TABLE_NAME);
            $hosts = \array_map(function ($url) use ($wpdb) {
                return $wpdb->prepare('%s', $url);
            }, $hosts);
            $sqlIn = \join(',', $hosts);
            // phpcs:disable WordPress.DB.PreparedSQL
            return $wpdb->query(
                $wpdb->prepare(
                    "UPDATE {$table_name} SET ignored = %d WHERE blocked_url_host IN ({$sqlIn})",
                    $state ? 1 : 0
                )
            );
            // phpcs:enable WordPress.DB.PreparedSQL
        }
        return 0;
    }
    /**
     * Get a list of found presets and external URL hosts.
     */
    public function getScannedCombinedResults() {
        global $wpdb;
        $table_name = $this->getTableName(\DevOwl\RealCookieBanner\scanner\Persist::TABLE_NAME);
        // phpcs:disable WordPress.DB.PreparedSQL
        $result = $wpdb->get_row(
            "SELECT\n                GROUP_CONCAT(DISTINCT IF(preset <> '', preset, NULL) ORDER BY preset) AS presets,\n                GROUP_CONCAT(DISTINCT IF(preset = '', blocked_url_host, NULL) ORDER BY blocked_url_host) AS externalHosts\n            FROM {$table_name}",
            ARRAY_A
        );
        // phpcs:enable WordPress.DB.PreparedSQL
        return [\explode(',', $result['presets']), \explode(',', $result['externalHosts'])];
    }
    /**
     * Get scanned presets with details about the amount of found times, if ignored
     * by the user, and the last scanned.
     */
    public function getScannedPresets() {
        global $wpdb;
        $table_name = $this->getTableName(\DevOwl\RealCookieBanner\scanner\Persist::TABLE_NAME);
        // phpcs:disable WordPress.DB.PreparedSQL
        $rows = $wpdb->get_results(
            "SELECT\n                preset,\n                COUNT(*) AS foundCount,\n                COUNT(DISTINCT source_url) AS foundOnSitesCount,\n                IF(SUM(ignored) > 0, 1, 0) AS ignored,\n                MAX(created) AS lastScanned\n            FROM {$table_name} scan\n            WHERE preset <> ''\n            GROUP BY preset\n            ORDER BY preset",
            ARRAY_A
        );
        // phpcs:enable WordPress.DB.PreparedSQL
        $result = [];
        foreach ($rows as $row) {
            $preset = $row['preset'];
            // Cast result
            $result[$preset] = [
                'foundCount' => \intval($row['foundCount']),
                'foundOnSitesCount' => \intval($row['foundOnSitesCount']),
                'ignored' => \intval($row['ignored']) > 0,
                'lastScanned' => mysql2date('c', $row['lastScanned'], \false)
            ];
        }
        return $result;
    }
    /**
     * Get scanned external URLs aggregated by host.
     */
    public function getScannedExternalUrls() {
        global $wpdb;
        $table_name = $this->getTableName(\DevOwl\RealCookieBanner\scanner\Persist::TABLE_NAME);
        $regex = $this->getExistingUrlRegularExpressions();
        $regexSql = $this->transformRegularExpressionsToMySQL($regex, 'blocked_url');
        // phpcs:disable WordPress.DB.PreparedSQL
        $rows = $wpdb->get_results(
            "SELECT\n                blocked_url_host AS host,\n                COUNT(*) AS foundCount,\n                COUNT(DISTINCT source_url) AS foundOnSitesCount,\n                SUM(IF({$regexSql}, 1, 0)) AS blockedCount,\n                IF(SUM(ignored) > 0, 1, 0) AS ignored,\n                MAX(created) AS lastScanned,\n                GROUP_CONCAT(DISTINCT tag) AS tags\n            FROM {$table_name} scan\n            WHERE blocked_url_host IS NOT NULL\n                AND preset = ''\n            GROUP BY blocked_url_host\n            ORDER BY blocked_url_host",
            ARRAY_A
        );
        // phpcs:enable WordPress.DB.PreparedSQL
        // Cast properties
        $result = [];
        foreach ($rows as &$row) {
            $host = $row['host'];
            // Cast result
            $result[$host] = [
                'host' => $host,
                'foundCount' => \intval($row['foundCount']),
                'foundOnSitesCount' => \intval($row['foundOnSitesCount']),
                'blockedCount' => \intval($row['blockedCount']),
                'ignored' => \intval($row['ignored']) > 0,
                'lastScanned' => mysql2date('c', $row['lastScanned'], \false),
                'tags' => \explode(',', $row['tags'])
            ];
        }
        return $result;
    }
    /**
     * Get scanned external URLs by host. This includes source page and complete
     * blocked URL instead of only host.
     *
     * @param string $by Can be `host` or `preset`
     * @param string $value
     */
    public function getAllScannedExternalUrlsBy($by, $value) {
        global $wpdb;
        $table_name = $this->getTableName(\DevOwl\RealCookieBanner\scanner\Persist::TABLE_NAME);
        $regex = $this->getExistingUrlRegularExpressions();
        $regexSql = $this->transformRegularExpressionsToMySQL($regex, 'blocked_url');
        // phpcs:disable WordPress.DB.PreparedSQL
        $sql =
            "SELECT id,\n                blocked_url AS blockedUrl,\n                IF(markup <> '', 1, 0) AS markup,\n                source_url AS sourceUrl,\n                IF({$regexSql}, 1, 0) AS blocked,\n                ignored,\n                created AS lastScanned,\n                tag\n            FROM {$table_name} scan\n            WHERE " .
            ($by === 'host'
                ? $wpdb->prepare("blocked_url_host = %s AND preset = ''", $value)
                : $wpdb->prepare('preset = %s', $value)) .
            ' ORDER BY blocked_url';
        $rows = $wpdb->get_results($sql, ARRAY_A);
        // phpcs:enable WordPress.DB.PreparedSQL
        // Collect markup ids so we can run the content blocker on the HTML
        $checkMarkup = [];
        // Cast properties
        $result = [];
        foreach ($rows as &$row) {
            $id = \intval($row['id']);
            // Cast result
            $row = [
                'id' => $id,
                'blockedUrl' => $row['blockedUrl'],
                'markup' => \intval($row['markup']) > 0,
                'sourceUrl' => $row['sourceUrl'],
                'blocked' => \intval($row['blocked']) > 0,
                'ignored' => \intval($row['ignored']) > 0,
                'lastScanned' => mysql2date('c', $row['lastScanned'], \false),
                'tag' => $row['tag']
            ];
            $result[] = $row;
            if ($row['markup'] && !$row['blocked'] && empty($row['blockedUrl'])) {
                $checkMarkup[] = $row['id'];
            }
        }
        if (\count($checkMarkup)) {
            $this->checkIfMarkupIsBlocked($checkMarkup, $result);
        }
        return $result;
    }
    /**
     * Check server-side via PHP if the markup got blocked by an existing content blocker.
     *
     * @param int[] $ids
     * @param array $result
     */
    protected function checkIfMarkupIsBlocked($ids, &$result) {
        global $wpdb;
        $table_name = $this->getTableName(\DevOwl\RealCookieBanner\scanner\Persist::TABLE_NAME);
        add_filter('RCB/Blocker/Enabled', '__return_true');
        // We need to ensure to not block too many memory so lets get distinct MD5 hashes
        // of the markups and afterwards check it instead of getting markups directly by our record IDs
        $sql = \sprintf(
            "SELECT\n                tag,\n                CASE\n                    WHEN markup LIKE '<%%' THEN '%s'\n                    WHEN tag = 'script' THEN '%s'\n                    WHEN tag = 'style' THEN '%s'\n                    ELSE '%s'\n                END AS mime,\n                markup,\n                markup_hash,\n                GROUP_CONCAT(id) AS ids\n            FROM {$table_name}\n            WHERE id IN (%s)\n            GROUP BY markup_hash",
            self::MIME_TYPE_HTML,
            self::MIME_TYPE_JAVASCRIPT,
            self::MIME_TYPE_CSS,
            self::MIME_TYPE_HTML,
            \join(',', $ids)
        );
        // phpcs:disable WordPress.DB.PreparedSQL
        $distinctMarkups = $wpdb->get_results($sql, ARRAY_A);
        // phpcs:enable WordPress.DB.PreparedSQL
        foreach ($distinctMarkups as $distinctMarkup) {
            if ($distinctMarkup['mime'] !== self::MIME_TYPE_HTML) {
                $distinctMarkup['markup'] = \sprintf(
                    '<%1$s>%2$s</%1$s>',
                    $distinctMarkup['tag'],
                    $distinctMarkup['markup']
                );
            }
            $distinctMarkup['markup'] = apply_filters('Consent/Block/HTML', $distinctMarkup['markup']);
            $isBlocked =
                \strpos(
                    $distinctMarkup['markup'],
                    \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants::HTML_ATTRIBUTE_COOKIE_IDS .
                        '='
                ) !== \false;
            if ($isBlocked) {
                $recordIds = \array_map('intval', \explode(',', $distinctMarkup['ids']));
                foreach ($result as &$row) {
                    if (\in_array($row['id'], $recordIds, \true)) {
                        $row['blocked'] = \true;
                    }
                }
            }
        }
        remove_filter('RCB/Blocker/Enabled', '__return_true');
    }
    /**
     * Provide a count for all scan results.
     *
     * @param array $revision
     */
    public function revisionCurrent($revision) {
        global $wpdb;
        $table_name = $this->getTableName(\DevOwl\RealCookieBanner\scanner\Persist::TABLE_NAME);
        // phpcs:disable WordPress.DB.PreparedSQL
        $counts = $wpdb->get_col(
            "SELECT COUNT(*) FROM (SELECT COUNT(*) FROM {$table_name} WHERE preset <> '' GROUP BY preset) t\n        UNION ALL SELECT COUNT(*) FROM (SELECT COUNT(*) FROM {$table_name} WHERE blocked_url_host IS NOT NULL AND preset = '' GROUP BY blocked_url_host) t"
        );
        // phpcs:enable WordPress.DB.PreparedSQL
        $revision['all_scanner_result_presets_count'] = \intval($counts[0]);
        $revision['all_scanner_result_external_urls_count'] = \intval($counts[1]);
        return $revision;
    }
    /**
     * Calculate all existing regular expressions for blocked URLs.
     */
    protected function getExistingUrlRegularExpressions() {
        global $wpdb;
        // Get all existing hosts from existing posts
        // phpcs:disable WordPress.DB.PreparedSQL
        $hosts = $wpdb->get_col(
            $wpdb->prepare(
                "SELECT meta_value FROM {$wpdb->postmeta} pm\n            INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id\n            WHERE p.post_type = %s AND pm.meta_key = %s",
                \DevOwl\RealCookieBanner\settings\Blocker::CPT_NAME,
                \DevOwl\RealCookieBanner\settings\Blocker::META_NAME_HOSTS
            )
        );
        // phpcs:enable WordPress.DB.PreparedSQL
        // The hosts is multiline (coming from textarea), let's split into an array
        $hostsArray = [];
        foreach ($hosts as $host) {
            $hostsArray = \array_merge($hostsArray, \explode("\n", $host));
        }
        $blockable = new \DevOwl\RealCookieBanner\scanner\PresetBlockable(null, $hostsArray);
        $regex = $blockable->getRegularExpressions();
        return $regex;
    }
    /**
     * Transform a set of regular expression strings to a valid SQL statement. The regular
     * expressions are combined with `OR` so you can check e.g. an URL column if it matches.
     *
     * @param string[] $regex
     * @param string $column
     */
    protected function transformRegularExpressionsToMySQL($regex, $column) {
        global $wpdb;
        $result = [];
        foreach ($regex as $r) {
            $result[] = \sprintf(
                '%s REGEXP %s',
                $column,
                $wpdb->prepare(
                    '%s',
                    // Trim `//` first and last character for regular expressions as SQL does not support it
                    \trim(
                        // Some MySQL versions do not support line breaks in varchar
                        \str_replace('((?:.|\\n)*)', '(.*)', $r),
                        '/'
                    )
                )
            );
        }
        return \count($result) > 0 ? \join(' OR ', $result) : '1=0';
    }
}
