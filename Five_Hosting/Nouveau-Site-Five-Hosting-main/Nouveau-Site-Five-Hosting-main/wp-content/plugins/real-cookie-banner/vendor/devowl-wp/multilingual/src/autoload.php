<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual;

// Simply check for defined constants, we do not need to `die` here
if (\defined('ABSPATH')) {
    \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\UtilsProvider::setupConstants();
    \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\Localization::instanceThis()->hooks();
}
