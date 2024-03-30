<?php

namespace DevOwl\RealCookieBanner\view\checklist;

use DevOwl\RealCookieBanner\base\UtilsProvider;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Is the plugin installed?
 */
class Install extends \DevOwl\RealCookieBanner\view\checklist\AbstractChecklistItem {
    use UtilsProvider;
    const IDENTIFIER = 'install';
    // Documented in AbstractChecklistItem
    public function isChecked() {
        return \true;
    }
    // Documented in AbstractChecklistItem
    public function getTitle() {
        return __('Install Real Cookie Banner', RCB_TD);
    }
    // Documented in AbstractChecklistItem
    public function getDescription() {
        return __('You have to install and activate the plugin in your WordPress to start with the setup.', RCB_TD);
    }
}
