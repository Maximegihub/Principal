<?php

namespace DevOwl\RealCookieBanner\view\checklist;

use DevOwl\RealCookieBanner\base\UtilsProvider;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * A legal shortcode was genearted once.
 */
class Shortcode extends \DevOwl\RealCookieBanner\view\checklist\AbstractChecklistItem {
    use UtilsProvider;
    const IDENTIFIER = 'legal-shortcodes';
    // Documented in AbstractChecklistItem
    public function isChecked() {
        return $this->getFromOption(self::IDENTIFIER);
    }
    // Documented in AbstractChecklistItem
    public function toggle($state) {
        return $this->persistStateToOption(self::IDENTIFIER, $state);
    }
    // Documented in AbstractChecklistItem
    public function getTitle() {
        return __('Place shortcodes in your privacy policy', RCB_TD);
    }
    // Documented in AbstractChecklistItem
    public function getDescription() {
        return __(
            'Your visitors must be able to view, change and revoke their consent at any time. You should add shortcodes to your footer and privacy policy to provide this feature.',
            RCB_TD
        );
    }
    // Documented in AbstractChecklistItem
    public function getLink() {
        return '#/consent/legal';
    }
    // Documented in AbstractChecklistItem
    public function getLinkText() {
        return __('Generate shortcodes', RCB_TD);
    }
}
