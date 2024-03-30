<?php

namespace DevOwl\RealCookieBanner\view\checklist;

use DevOwl\RealCookieBanner\base\UtilsProvider;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * On lite version there should be a link to get pro version.
 */
class GetPro extends \DevOwl\RealCookieBanner\view\checklist\AbstractChecklistItem {
    use UtilsProvider;
    const IDENTIFIER = 'get-pro';
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
        return __('Buy a license of Real Cookie Banner PRO', RCB_TD);
    }
    // Documented in AbstractChecklistItem
    public function getDescription() {
        return __('Get a PRO license at devowl.io to get more out of Real Cookie Banner!', RCB_TD);
    }
    // Documented in AbstractChecklistItem
    public function isVisible() {
        return !$this->isPro();
    }
    // Documented in AbstractChecklistItem
    public function getLink() {
        return RCB_PRO_VERSION;
    }
    // Documented in AbstractChecklistItem
    public function needsPro() {
        return \true;
    }
    // Documented in AbstractChecklistItem
    public function getLinkText() {
        return __('Learn more', RCB_TD);
    }
    // Documented in AbstractChecklistItem
    public function getLinkTarget() {
        return '_blank';
    }
}
