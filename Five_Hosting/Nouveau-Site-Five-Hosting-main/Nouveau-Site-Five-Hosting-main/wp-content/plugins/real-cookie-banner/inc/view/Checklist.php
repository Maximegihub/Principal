<?php

namespace DevOwl\RealCookieBanner\view;

use DevOwl\RealCookieBanner\Activator;
use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\DemoEnvironment;
use DevOwl\RealCookieBanner\view\checklist\AbstractChecklistItem;
use DevOwl\RealCookieBanner\view\checklist\ActivateBanner;
use DevOwl\RealCookieBanner\view\checklist\AddBlocker;
use DevOwl\RealCookieBanner\view\checklist\AddCookie;
use DevOwl\RealCookieBanner\view\checklist\CustomizeBanner;
use DevOwl\RealCookieBanner\view\checklist\GetPro;
use DevOwl\RealCookieBanner\view\checklist\Install;
use DevOwl\RealCookieBanner\view\checklist\License;
use DevOwl\RealCookieBanner\view\checklist\PrivacyPolicy;
use DevOwl\RealCookieBanner\view\checklist\SaveSettings;
use DevOwl\RealCookieBanner\view\checklist\Scanner;
use DevOwl\RealCookieBanner\view\checklist\Shortcode;
use DevOwl\RealCookieBanner\view\checklist\ViewStats;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Checklist handler.
 */
class Checklist {
    use UtilsProvider;
    const OPTION_NAME_CHECK_ALL = RCB_OPT_PREFIX . '-checklist-all';
    const ITEMS_ORDERED = [
        \DevOwl\RealCookieBanner\view\checklist\Install::IDENTIFIER =>
            \DevOwl\RealCookieBanner\view\checklist\Install::class,
        \DevOwl\RealCookieBanner\view\checklist\License::IDENTIFIER =>
            \DevOwl\RealCookieBanner\view\checklist\License::class,
        \DevOwl\RealCookieBanner\view\checklist\GetPro::IDENTIFIER =>
            \DevOwl\RealCookieBanner\view\checklist\GetPro::class,
        \DevOwl\RealCookieBanner\view\checklist\SaveSettings::IDENTIFIER =>
            \DevOwl\RealCookieBanner\view\checklist\SaveSettings::class,
        \DevOwl\RealCookieBanner\view\checklist\PrivacyPolicy::IDENTIFIER =>
            \DevOwl\RealCookieBanner\view\checklist\PrivacyPolicy::class,
        \DevOwl\RealCookieBanner\view\checklist\Scanner::IDENTIFIER =>
            \DevOwl\RealCookieBanner\view\checklist\Scanner::class,
        \DevOwl\RealCookieBanner\view\checklist\AddCookie::IDENTIFIER =>
            \DevOwl\RealCookieBanner\view\checklist\AddCookie::class,
        \DevOwl\RealCookieBanner\view\checklist\CustomizeBanner::IDENTIFIER =>
            \DevOwl\RealCookieBanner\view\checklist\CustomizeBanner::class,
        \DevOwl\RealCookieBanner\view\checklist\AddBlocker::IDENTIFIER =>
            \DevOwl\RealCookieBanner\view\checklist\AddBlocker::class,
        \DevOwl\RealCookieBanner\view\checklist\ActivateBanner::IDENTIFIER =>
            \DevOwl\RealCookieBanner\view\checklist\ActivateBanner::class,
        \DevOwl\RealCookieBanner\view\checklist\Shortcode::IDENTIFIER =>
            \DevOwl\RealCookieBanner\view\checklist\Shortcode::class,
        \DevOwl\RealCookieBanner\view\checklist\ViewStats::IDENTIFIER =>
            \DevOwl\RealCookieBanner\view\checklist\ViewStats::class
    ];
    /**
     * Singleton instance.
     *
     * @var Checklist
     */
    private static $me = null;
    /**
     * C'tor.
     */
    private function __construct() {
        // Silence is golden.
    }
    /**
     * Get current checklist result.
     */
    public function result() {
        $result = [];
        foreach (self::ITEMS_ORDERED as $id => $clazz) {
            /**
             * Instance.
             *
             * @var AbstractChecklistItem
             */
            $instance = new $clazz();
            if (!$instance->isVisible()) {
                continue;
            }
            $result[$id] = [
                'title' => $instance->getTitle(),
                'description' => $instance->getDescription(),
                'checked' => $instance->isChecked() || $this->isAllChecked(),
                'link' => $instance->getLink(),
                'linkText' => $instance->getLinkText(),
                'linkTarget' => $instance->getLinkTarget(),
                'needsPro' => $instance->needsPro()
            ];
        }
        return ['dismissed' => $this->isAllChecked(), 'items' => $result];
    }
    /**
     * Toggle a checklist item checked state. If you pass 'all' as ID, all
     * checkbox items will be marked as checked.
     *
     * @param string $id
     * @param boolean $state
     * @return boolean
     */
    public function toggle($id, $state) {
        if ($id === 'all') {
            return update_option(self::OPTION_NAME_CHECK_ALL, $state, \true);
        }
        if (\array_key_exists($id, self::ITEMS_ORDERED)) {
            $clazz = self::ITEMS_ORDERED[$id];
            return (new $clazz())->toggle($state);
        }
        return \false;
    }
    /**
     * Check if the checklist is completed.
     */
    public function isCompleted() {
        $result = $this->result();
        $isPro = $this->isPro();
        if ($result['dismissed']) {
            return \true;
        }
        $items = $result['items'];
        $completed = \array_filter($items, function ($item) {
            return $item['checked'];
        });
        $checkable = \array_filter($items, function ($item) use ($isPro) {
            return !$item['needsPro'] || ($isPro && $item['needsPro']);
        });
        return \count($completed) >= \count($checkable);
    }
    /**
     * Check if the checklist is not completed yet and is overdue e.g. 2 weeks.
     *
     * @param string $time E.g. `+2 weeks`
     */
    public function isOverdue($time) {
        $completed = $this->isCompleted();
        if ($completed || \DevOwl\RealCookieBanner\DemoEnvironment::getInstance()->isDemoEnv()) {
            return \false;
        }
        $installed = \strtotime(get_option(\DevOwl\RealCookieBanner\Activator::OPTION_NAME_INSTALLATION_DATE));
        return \time() > $installed + \strtotime($time, 0);
    }
    /**
     * Check if all items are checked through "I have already done all the steps".
     *
     * @return boolean
     */
    public function isAllChecked() {
        // If checked, the option simply exists
        $options = wp_load_alloptions();
        $value = isset($options[self::OPTION_NAME_CHECK_ALL]) ? \intval($options[self::OPTION_NAME_CHECK_ALL]) : \false;
        return \boolval($value);
    }
    /**
     * Get singleton instance.
     *
     * @codeCoverageIgnore
     */
    public static function getInstance() {
        return self::$me === null ? (self::$me = new \DevOwl\RealCookieBanner\view\Checklist()) : self::$me;
    }
}
