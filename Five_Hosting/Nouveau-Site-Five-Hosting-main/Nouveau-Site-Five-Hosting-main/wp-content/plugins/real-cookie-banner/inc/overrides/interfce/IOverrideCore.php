<?php

namespace DevOwl\RealCookieBanner\overrides\interfce;

use DevOwl\RealCookieBanner\Vendor\DevOwl\Freemium\ICore;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
interface IOverrideCore extends \DevOwl\RealCookieBanner\Vendor\DevOwl\Freemium\ICore {
    /**
     * Extend constructor.
     */
    public function overrideConstruct();
    /**
     * Register additional settings.
     */
    public function overrideRegisterSettings();
    /**
     * Additional init.
     */
    public function overrideInit();
}
