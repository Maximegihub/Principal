<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\RealQueue;

// Simply check for defined constants, we do not need to `die` here
if (\defined('ABSPATH')) {
    \DevOwl\RealCookieBanner\Vendor\DevOwl\RealQueue\UtilsProvider::setupConstants();
    \DevOwl\RealCookieBanner\Vendor\DevOwl\RealQueue\Localization::instanceThis()->hooks();
}
