<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\RealProductManagerWpClient;

// Simply check for defined constants, we do not need to `die` here
if (\defined('ABSPATH')) {
    \DevOwl\RealCookieBanner\Vendor\DevOwl\RealProductManagerWpClient\UtilsProvider::setupConstants();
    \DevOwl\RealCookieBanner\Vendor\DevOwl\RealProductManagerWpClient\Localization::instanceThis()->hooks();
}
