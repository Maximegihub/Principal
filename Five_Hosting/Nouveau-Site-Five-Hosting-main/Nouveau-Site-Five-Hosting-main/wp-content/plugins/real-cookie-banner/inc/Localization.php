<?php

namespace DevOwl\RealCookieBanner;

use DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\AbstractSyncPlugin;
use DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\Sync;
use DevOwl\RealCookieBanner\Vendor\MatthiasWeb\Utils\Localization as UtilsLocalization;
use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\lite\settings\TcfVendorConfiguration;
use DevOwl\RealCookieBanner\settings\Blocker;
use DevOwl\RealCookieBanner\settings\Cookie;
use DevOwl\RealCookieBanner\settings\CookieGroup;
use DevOwl\RealCookieBanner\view\customize\banner\Legal;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * i18n management for backend and frontend.
 */
class Localization {
    use UtilsProvider;
    use UtilsLocalization;
    /**
     * Keys of array which should be not translated with `translateArray`.
     */
    const COMMON_SKIP_KEYS = ['slug'];
    /**
     * Get the directory where the languages folder exists.
     *
     * @param string $type
     * @return string[]
     */
    protected function getPackageInfo($type) {
        if ($type === \DevOwl\RealCookieBanner\Vendor\MatthiasWeb\Utils\Localization::$PACKAGE_INFO_BACKEND) {
            return [path_join(RCB_PATH, 'languages'), RCB_TD];
        } else {
            return [path_join(RCB_PATH, \DevOwl\RealCookieBanner\Assets::$PUBLIC_JSON_I18N), RCB_TD];
        }
    }
    /**
     * Make our plugin multilingual with the help of `AbstractSyncPlugin` and `Sync`!
     * Also have a look at `BannerCustomize`, there are `LanguageDependingOption`'s.
     */
    public static function multilingual() {
        $compLanguage = \DevOwl\RealCookieBanner\Core::getInstance()->getCompLanguage();
        $sync = new \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\Sync(
            \array_merge(
                [
                    \DevOwl\RealCookieBanner\settings\Cookie::CPT_NAME =>
                        \DevOwl\RealCookieBanner\settings\Cookie::SYNC_OPTIONS,
                    \DevOwl\RealCookieBanner\settings\Blocker::CPT_NAME =>
                        \DevOwl\RealCookieBanner\settings\Blocker::SYNC_OPTIONS
                ],
                \DevOwl\RealCookieBanner\Core::getInstance()->isPro()
                    ? [
                        \DevOwl\RealCookieBanner\lite\settings\TcfVendorConfiguration::CPT_NAME =>
                            \DevOwl\RealCookieBanner\lite\settings\TcfVendorConfiguration::SYNC_OPTIONS
                    ]
                    : []
            ),
            [
                \DevOwl\RealCookieBanner\settings\CookieGroup::TAXONOMY_NAME =>
                    \DevOwl\RealCookieBanner\settings\CookieGroup::SYNC_OPTIONS
            ],
            $compLanguage
        );
        $compLanguage->setSync($sync);
        $idsToCurrent = [
            \DevOwl\RealCookieBanner\view\customize\banner\Legal::SETTING_PRIVACY_POLICY,
            \DevOwl\RealCookieBanner\view\customize\banner\Legal::SETTING_IMPRINT
        ];
        foreach ($idsToCurrent as $id) {
            add_filter('DevOwl/Customize/LocalizedValue/' . $id, function ($value) use ($compLanguage) {
                return $compLanguage->getCurrentPostId($value, \DevOwl\RealCookieBanner\settings\Cookie::CPT_NAME);
            });
        }
        // Translate some meta fields when they get copied to the other language
        if ($compLanguage instanceof \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\AbstractSyncPlugin) {
            foreach (
                [
                    \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_PROVIDER,
                    \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_PROVIDER_PRIVACY_POLICY
                ]
                as $translateMetaKey
            ) {
                add_filter('DevOwl/Multilingual/Copy/Meta/post/' . $translateMetaKey, [
                    $compLanguage,
                    'translateInputAndReturnValue'
                ]);
            }
        }
    }
}
