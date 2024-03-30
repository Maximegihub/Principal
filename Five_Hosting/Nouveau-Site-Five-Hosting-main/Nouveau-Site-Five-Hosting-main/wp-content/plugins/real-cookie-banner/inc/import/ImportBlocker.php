<?php

namespace DevOwl\RealCookieBanner\import;

use DevOwl\RealCookieBanner\lite\settings\TcfVendorConfiguration;
use DevOwl\RealCookieBanner\presets\BlockerPresets;
use DevOwl\RealCookieBanner\presets\middleware\AdoptTierFromClassNamespaceMiddleware;
use DevOwl\RealCookieBanner\settings\Blocker;
use DevOwl\RealCookieBanner\settings\Cookie;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Trait to handle the importer for content blocker in the `Import` class.
 */
trait ImportBlocker {
    /**
     * Import content blocker from JSON.
     *
     * @param array $blockers
     */
    protected function doImportBlocker($blockers) {
        $currentBlockers = \DevOwl\RealCookieBanner\import\Export::instance()
            ->appendBlocker()
            ->finish()['blocker'];
        $blockerStatus = $this->getBlockerStatus();
        foreach ($blockers as $index => $blocker) {
            if (!$this->handleCorruptBlocker($blocker, $index)) {
                continue;
            }
            // Collect data
            $metas = $blocker['metas'];
            $post_name = $blocker['post_name'];
            $post_content = $blocker['post_content'];
            $post_status = $blockerStatus === 'keep' ? $blocker['post_status'] : $blockerStatus;
            $post_title = $blocker['post_title'];
            $countAllAssociations = 0;
            $associatedCount = 0;
            if (\is_array($metas)) {
                // Fix meta: hosts
                if (isset($metas['hosts']) && \is_array($metas['hosts'])) {
                    $metas['hosts'] = \join("\n", $metas['hosts']);
                }
                // Fix meta: tcfVendors
                if ($this->isPro() && isset($metas['tcfVendors']) && \is_array($metas['tcfVendors'])) {
                    $countAllAssociations += \count($metas['tcfVendors']);
                    $metas['tcfVendors'] = $this->correctAssociationIdsForBlocker(
                        $metas['tcfVendors'],
                        'mapTcfVendorConfigurations',
                        \DevOwl\RealCookieBanner\lite\settings\TcfVendorConfiguration::CPT_NAME
                    );
                    $associatedCount += \count($metas['tcfVendors']);
                    $metas['tcfVendors'] = \join(',', $metas['tcfVendors']);
                }
                // Fix meta: cookies
                if (isset($metas['cookies']) && \is_array($metas['cookies'])) {
                    $countAllAssociations += \count($metas['cookies']);
                    $metas['cookies'] = $this->correctAssociationIdsForBlocker(
                        $metas['cookies'],
                        'mapCookies',
                        \DevOwl\RealCookieBanner\settings\Cookie::CPT_NAME
                    );
                    $associatedCount += \count($metas['cookies']);
                    $metas['cookies'] = \join(',', $metas['cookies']);
                }
            }
            // Find current blocker with same post_name
            $found = \false;
            foreach ($currentBlockers as $currentBlocker) {
                if ($currentBlocker['post_name'] === $post_name) {
                    $found = $currentBlocker;
                    break;
                }
            }
            // Check if this is a PRO template
            if (
                !$this->isPro() &&
                isset($metas[\DevOwl\RealCookieBanner\settings\Blocker::META_NAME_PRESET_ID]) &&
                !empty($metas[\DevOwl\RealCookieBanner\settings\Blocker::META_NAME_PRESET_ID])
            ) {
                $presetWithAttributes = (new \DevOwl\RealCookieBanner\presets\BlockerPresets())->getWithAttributes(
                    $metas[\DevOwl\RealCookieBanner\settings\Blocker::META_NAME_PRESET_ID]
                );
                if (
                    $presetWithAttributes === \false ||
                    $presetWithAttributes['tier'] !==
                        \DevOwl\RealCookieBanner\presets\middleware\AdoptTierFromClassNamespaceMiddleware::TIER_FREE
                ) {
                    $this->addMessageCreateFailureImportingProInFreeVersion($post_title);
                    continue;
                }
            }
            if ($this->isBlockerSkipExisting() && $found) {
                $this->addMessageSkipExistingBlocker($post_name);
                continue;
            }
            // Always create the entry
            $create = wp_insert_post(
                [
                    'post_type' => \DevOwl\RealCookieBanner\settings\Blocker::CPT_NAME,
                    'post_content' => $post_content,
                    'post_title' => $post_title,
                    'post_status' => $post_status,
                    'meta_input' => $metas
                ],
                \true
            );
            if (is_wp_error($create)) {
                $this->addMessageCreateFailure($post_name, __('Content Blocker', RCB_TD), $create);
                continue;
            }
            $this->probablyAddMessageDuplicateBlocker($found, $post_name, $found['ID'], $create);
            $this->probablyAddMessageBlockerAssociation($countAllAssociations, $associatedCount, $post_title, $create);
        }
    }
    /**
     * Fetch the correct cookie / TCF vendor ids for the meta.
     *
     * @param string[] $post_names
     * @param string $mapName Can be `mapCookies` or `mapTcfVendorConfigurations`
     * @param string $association_post_type
     */
    protected function correctAssociationIdsForBlocker($post_names, $mapName, $association_post_type) {
        global $wpdb;
        $result = [];
        foreach ($post_names as $post_name) {
            // Check if it is an imported post
            if (isset($this->{$mapName}[$post_name])) {
                $result[] = $this->{$mapName}[$post_name];
            } else {
                $post = $wpdb->get_var(
                    $wpdb->prepare(
                        "SELECT ID FROM {$wpdb->posts} WHERE post_name = %s AND post_type = %s",
                        $post_name,
                        $association_post_type
                    )
                );
                if ($post) {
                    $result[] = get_post($post)->ID;
                }
            }
        }
        return \array_map('intval', $result);
    }
    /**
     * Check missing meta of passed blocker.
     *
     * @param array $blocker
     * @param int $index
     */
    protected function handleCorruptBlocker($blocker, $index) {
        if (
            !isset(
                $blocker['metas'],
                $blocker['post_name'],
                $blocker['post_content'],
                $blocker['post_status'],
                $blocker['post_title']
            )
        ) {
            $this->addMessageMissingProperties(
                $index,
                __('Content Blocker', RCB_TD),
                'ID, metas, post_content, post_name, post_status, post_title'
            );
            return \false;
        }
        return \true;
    }
}
