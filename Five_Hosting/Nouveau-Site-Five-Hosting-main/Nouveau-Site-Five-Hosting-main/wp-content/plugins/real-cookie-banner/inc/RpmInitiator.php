<?php

namespace DevOwl\RealCookieBanner;

use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\Vendor\DevOwl\RealProductManagerWpClient\AbstractInitiator;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Initiate real-product-manager-wp-client functionality.
 */
class RpmInitiator extends \DevOwl\RealCookieBanner\Vendor\DevOwl\RealProductManagerWpClient\AbstractInitiator {
    use UtilsProvider;
    /**
     * Documented in AbstractInitiator.
     *
     * @codeCoverageIgnore
     */
    public function getPluginBase() {
        return $this;
    }
    /**
     * Documented in AbstractInitiator.
     *
     * @codeCoverageIgnore
     */
    public function getProductAndVariant() {
        return [1, $this->isPro() ? 1 : 2];
    }
    /**
     * Documented in AbstractInitiator.
     *
     * @codeCoverageIgnore
     */
    public function getPluginAssets() {
        return $this->getCore()->getAssets();
    }
    /**
     * Documented in AbstractInitiator.
     *
     * @codeCoverageIgnore
     */
    public function getPrivacyPolicy() {
        return 'https://devowl.io/privacy-policy';
    }
    /**
     * Documented in AbstractInitiator.
     *
     * @codeCoverageIgnore
     */
    public function isExternalUpdateEnabled() {
        return $this->isPro();
    }
    /**
     * Documented in AbstractInitiator.
     *
     * @codeCoverageIgnore
     */
    public function isAdminNoticeLicenseVisible() {
        return \DevOwl\RealCookieBanner\Core::getInstance()
            ->getConfigPage()
            ->isVisible();
    }
    /**
     * Documented in AbstractInitiator.
     *
     * @codeCoverageIgnore
     */
    public function isLocalAnnouncementVisible() {
        return $this->isAdminNoticeLicenseVisible();
    }
}
