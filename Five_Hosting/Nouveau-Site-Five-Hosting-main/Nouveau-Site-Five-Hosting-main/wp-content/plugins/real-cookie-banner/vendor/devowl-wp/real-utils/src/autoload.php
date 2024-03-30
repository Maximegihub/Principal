<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\RealUtils;

// Simply check for defined constants, we do not need to `die` here
if (\defined('ABSPATH')) {
    \DevOwl\RealCookieBanner\Vendor\DevOwl\RealUtils\UtilsProvider::setupConstants();
    \DevOwl\RealCookieBanner\Vendor\DevOwl\RealUtils\Localization::instanceThis()->hooks();
}
