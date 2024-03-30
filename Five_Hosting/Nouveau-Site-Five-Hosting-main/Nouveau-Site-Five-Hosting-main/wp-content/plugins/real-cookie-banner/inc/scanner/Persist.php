<?php

namespace DevOwl\RealCookieBanner\scanner;

use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants;
use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\view\Blocker;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Persist multiple `ScanEntry`'s from the `Scanner` results to the database.
 *
 * It also provides functionality to avoid duplicate found presets (e.g. MonsterInsights over Google Analytics),
 * and deduplicate coexisting presets (e.g. CF7 with reCaptcha over Google reCaptcha).
 */
class Persist {
    use UtilsProvider;
    const TABLE_NAME = 'scan';
    /**
     * Fields which should be updated via `ON DUPLICATE KEY UPDATE`.
     */
    const DECLARATION_OVERWRITE_FIELDS = ['post_id', 'markup', 'markup_hash'];
    private $entries;
    /**
     * C'tor.
     *
     * @codeCoverageIgnore
     * @param ScanEntry[] $entries
     */
    public function __construct($entries) {
        $this->entries = $entries;
    }
    /**
     * Persist current entries to the database.
     */
    public function persist() {
        $this->insertToDatabase();
    }
    /**
     * Insert entries to database.
     */
    protected function insertToDatabase() {
        global $wpdb;
        if (\count($this->entries) === 0) {
            return;
        }
        $table_name = $this->getTableName(self::TABLE_NAME);
        $rows = [];
        foreach ($this->entries as $entry) {
            // Generate `VALUES` SQL
            // phpcs:disable WordPress.DB.PreparedSQL
            $rows[] = \str_ireplace(
                ["'NULL'", '= NULL'],
                ['NULL', 'IS NULL'],
                $wpdb->prepare(
                    '%s, %s, %s, %s, %s, %s, %s, %d, %s, %s, %d, %s',
                    $entry->preset,
                    $entry->blocked_url ?? 'NULL',
                    $entry->blocked_url_host ?? 'NULL',
                    $entry->blocked_url_hash,
                    $entry->markup ?? 'NULL',
                    $entry->markup_hash ?? '',
                    $entry->tag,
                    $entry->post_id ?? 'NULL',
                    $entry->source_url,
                    $entry->source_url_hash,
                    $entry->ignored ? 1 : 0,
                    current_time('mysql')
                )
            );
            // phpcs:enable WordPress.DB.PreparedSQL
        }
        // Allow to update fields if already exists
        $overwriteSql = [];
        foreach (self::DECLARATION_OVERWRITE_FIELDS as $field) {
            $overwriteSql[] = \sprintf('%1$s=VALUES(%1$s)', $field);
        }
        // Chunk to boost performance
        $chunks = \array_chunk($rows, 150);
        foreach ($chunks as $sqlInsert) {
            $sql =
                "INSERT INTO {$table_name}\n                    (`preset`, `blocked_url`, `blocked_url_host`, `blocked_url_hash`, `markup`, `markup_hash`, `tag`, `post_id`, `source_url`, `source_url_hash`, `ignored`, `created`)\n                    VALUES (" .
                \implode('),(', $sqlInsert) .
                ')
                    ON DUPLICATE KEY UPDATE ' .
                \join(', ', $overwriteSql);
            // phpcs:disable WordPress.DB.PreparedSQL
            $wpdb->query($sql);
            // phpcs:enable WordPress.DB.PreparedSQL
        }
    }
    /**
     * Deduplicate coexisting presets. Examples:
     *
     * - CF7 with reCaptcha over Google reCaptcha
     * - MonsterInsights > Google Analytics (`extended`)
     */
    public function deduplicate() {
        $removeByIdentifier = [];
        foreach ($this->entries as $key => $value) {
            $foundBetterPreset = $this->alreadyExistsInOtherFoundPreset($value);
            if ($foundBetterPreset !== \false) {
                unset($this->entries[$key]);
                continue;
            }
            // Scenario: MonsterInsights > Google Analytics
            $blockable = $value->blockable ?? null;
            if (\is_null($blockable)) {
                continue;
            }
            $extended = $blockable->getExtended();
            if (!\is_null($extended)) {
                $removeByIdentifier[] = $extended;
                continue;
            }
        }
        foreach ($this->entries as $key => $value) {
            if (\in_array($value->preset, $removeByIdentifier, \true)) {
                unset($this->entries[$key]);
            }
        }
        // Reset indexes
        $this->entries = \array_values($this->entries);
    }
    /**
     * Remove all entries with `mustHosts` and there is not a scan entry with the needed host.
     */
    public function removePresetsWithNonMatchingMustHosts() {
        $removeByIdentifier = [];
        foreach ($this->entries as $key => $scanEntry) {
            if (!isset($scanEntry->preset) || \in_array($scanEntry->preset, $removeByIdentifier, \true)) {
                continue;
            }
            $blockable = $scanEntry->blockable ?? null;
            if (\is_null($blockable)) {
                continue;
            }
            $mustHosts = $blockable->getMustHosts();
            if (\is_null($mustHosts)) {
                continue;
            }
            // Collect all found host expressions for this preset
            $foundExpressions = [];
            foreach ($this->entries as $anotherEntry) {
                if ($anotherEntry->preset === $scanEntry->preset) {
                    $foundExpressions = \array_merge($foundExpressions, $anotherEntry->expressions);
                }
            }
            foreach ($mustHosts as $mustHostsBlockable) {
                $originalHosts = $mustHostsBlockable->getOriginalHosts();
                // Check if one of our must's exists in found expressions
                $mustHostExists = !empty(\array_intersect($originalHosts, $foundExpressions));
                if (!$mustHostExists) {
                    $removeByIdentifier[] = $scanEntry->preset;
                }
            }
        }
        foreach ($this->entries as $key => $value) {
            if (\in_array($value->preset, $removeByIdentifier, \true)) {
                unset($this->entries[$key]);
            }
        }
        // Reset indexes
        $this->entries = \array_values($this->entries);
    }
    /**
     * Remove entries which does not have found an external URL, cause they do not matter us.
     * Example: WordPress User Login (`form[name="login-form"]`).
     *
     * This should not be applied to script and styles cause they can load external URL, too (e.g. WordPress Emojis).
     *
     * Use this function with caution! Only use this function if you really want to remove presets without external URLs.
     * If you do this, e.g. entries will no longer be list in your scanner tab if you expand a preset.
     */
    public function removePresetsWithoutExternalUrl() {
        foreach ($this->entries as $key => $value) {
            if (!empty($value->tag) && \in_array($value->tag, ['script', 'style'], \true)) {
                continue;
            }
            if (!isset($value->preset) || !empty($value->blocked_url)) {
                continue;
            }
            /**
             * For usual, blocker presets without external URLs (e.g. only `SyntaxSelector`)
             * are considered as skipped cause they do not really block anything.
             *
             * This filter is currently not in use!
             *
             * @param {boolean} $skip
             * @param {ScanEntry} $scanEntry
             * @return {boolean}
             * @hook RCB/Scanner/SkipPresetWithoutExternalUrl/$identifier
             * @since 2.6.0
             */
            $skip = apply_filters(
                'RCB/Scanner/SkipPresetWithoutExternalUrl/' . $value->preset,
                $this->hasPresetFoundExternalUrl($value),
                $value
            );
            if (!$skip) {
                // We did not found any external URL for this blocked preset, ignore it
                unset($this->entries[$key]);
            }
        }
        // Reset indexes
        $this->entries = \array_values($this->entries);
    }
    /**
     * Remove external URLs which got covered by a preset. When is this the case? When using a
     * `SelectorSyntaxBlocker` with e.g. `link[href=""]` (for example WordPress emojis).
     */
    public function removeExternalUrlsCoveredByPreset() {
        add_filter('RCB/Blocker/Enabled', '__return_true');
        foreach ($this->entries as $key => $entry) {
            if (!empty($entry->markup) && !empty($entry->tag) && !empty($entry->blocked_url) && empty($entry->preset)) {
                $markup = apply_filters('Consent/Block/HTML', $entry->markup);
                $isBlocked =
                    \strpos(
                        $markup,
                        \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants::HTML_ATTRIBUTE_CAPTURE_PREFIX
                    ) !== \false;
                if ($isBlocked) {
                    unset($this->entries[$key]);
                }
            }
        }
        remove_filter('RCB/Blocker/Enabled', '__return_true');
        // Reset indexes
        $this->entries = \array_values($this->entries);
    }
    /**
     * Find depending on a scan entry, if the same preset has any
     *
     * @param ScanEntry $scanEntry
     * @return false|ScanEntry The found entry which better describes this scan entry
     */
    protected function hasPresetFoundExternalUrl($scanEntry) {
        foreach ($this->entries as $existing) {
            if ($existing->preset === $scanEntry->preset && !empty($existing->blocked_url)) {
                return $existing;
            }
        }
        return \false;
    }
    /**
     * Check if a given preset already exists in another scan result.
     *
     * @param ScanEntry $scanEntry
     * @return false|ScanEntry The found entry which better suits this preset
     */
    protected function alreadyExistsInOtherFoundPreset($scanEntry) {
        $blockable = $scanEntry->blockable ?? null;
        if (\is_null($blockable)) {
            return \false;
        }
        foreach ($this->entries as $existing) {
            if ($existing !== $scanEntry && isset($existing->blockable)) {
                $currentHosts = $blockable->getOriginalHosts();
                $existingHosts = $existing->blockable->getOriginalHosts();
                if (\count($existingHosts) > \count($currentHosts)) {
                    // Only compare when our opposite scan entry has more hosts to block
                    // This avoids to alert false-positives when using `extends` middleware
                    $foundSame = 0;
                    foreach ($currentHosts as $currentHost) {
                        if (\in_array($currentHost, $existingHosts, \true)) {
                            $foundSame++;
                        }
                    }
                    if ($foundSame === \count($currentHosts)) {
                        return $existing;
                    }
                }
            }
        }
        return \false;
    }
    /**
     * Get the persistable entries.
     *
     * @codeCoverageIgnore
     */
    public function getEntries() {
        return $this->entries;
    }
}
