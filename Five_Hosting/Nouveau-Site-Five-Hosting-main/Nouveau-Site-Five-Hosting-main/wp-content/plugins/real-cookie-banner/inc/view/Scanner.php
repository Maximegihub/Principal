<?php

namespace DevOwl\RealCookieBanner\view;

use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\scanner\ScanPresets;
use DevOwl\RealCookieBanner\view\checklist\Scanner as ChecklistScanner;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Scanner view.
 */
class Scanner {
    use UtilsProvider;
    const ACTION_SCANNER_FOUND_SERVICES = 'rcb-scanner-found-services';
    const OPTION_NAME = RCB_OPT_PREFIX . '-scanner-notice-dismissed';
    const QUERY_ARG_DISMISS = self::OPTION_NAME;
    const MAX_FOUND_SERVICES_LIST_ITEMS = 5;
    /**
     * C'tor.
     */
    private function __construct() {
        $this->probablyDismiss();
    }
    /**
     * Show a "Show banner again" button in the admin toolbar in frontend.
     *
     * @param WP_Admin_Bar $admin_bar
     */
    public function admin_bar_menu($admin_bar) {
        // See `crawlSitemap.tsx`
        $admin_bar->add_node([
            'parent' => 'site-name',
            'id' => 'view-site-original',
            'title' => '',
            'href' => $this->getOriginalHomeUrl(),
            'meta' => ['html' => '<style>#wp-admin-bar-view-site-original {display:none;}</style>;']
        ]);
        $configPage = \DevOwl\RealCookieBanner\Core::getInstance()->getConfigPage();
        $scanChecklistItem = new \DevOwl\RealCookieBanner\view\checklist\Scanner();
        if (
            $configPage->isVisible() ||
            !current_user_can(\DevOwl\RealCookieBanner\Core::MANAGE_MIN_CAPABILITY) ||
            !$scanChecklistItem->isChecked()
        ) {
            return;
        }
        list($services, $countAll) = $this->getServicesForNotice(self::MAX_FOUND_SERVICES_LIST_ITEMS);
        if (\count($services) === 0) {
            return;
        }
        $scannerUrl = $configPage->getUrl() . '#/scanner';
        $icon = \sprintf(
            '<span class="custom-icon" style="float:left;width:22px !important;height:22px !important;margin: 5px 5px 0 !important;background-image:url(\'%s\');"></span>',
            \DevOwl\RealCookieBanner\view\ConfigPage::getIconAsSvgBase64('white')
        );
        $admin_bar->add_menu([
            'id' => 'rcb-scanner-found-services',
            'title' => \sprintf(
                '%s <span>%s</span>',
                $icon,
                // translators:
                \sprintf(_n('%d recommendation found', '%d recommendations found', $countAll, RCB_TD), $countAll)
            ),
            'href' => $scannerUrl,
            'meta' => [
                'class' => 'menupop',
                'html' => \sprintf(
                    '<div class="ab-sub-wrapper">
    <style>
        #wp-admin-bar-%1$s {
            background: #A67F2A !important;
        }

        #wp-admin-bar-%1$s .ab-submenu:not(.ab-sub-secondary) > li > * {
            padding: 0px 10px;
            width: 400px;
            line-height: 1.3;
        }

        #wp-admin-bar-%1$s .ab-submenu:not(.ab-sub-secondary) > li ul {
            list-style: initial !important;
            margin: 5px 15px;
        }

        #wp-admin-bar-%1$s .ab-submenu:not(.ab-sub-secondary) > li ul > li {
            list-style: initial !important;
            line-height: 1.3;
        }

        #wp-admin-bar-%1$s .ab-sub-secondary .ab-item > span {
            width:15px;
            display:inline-block;
            line-height:1.3;
            color:rgba(240, 246, 252, 0.7);
        }
    </style>
    <ul class="ab-submenu">
        <li>
            <div id="rcb-scan-result-notice">%2$s</div>
        </li>
    </ul>
    <ul class="ab-sub-secondary ab-submenu">
        <li>
            <a class="ab-item" href="%5$s"><span class="wp-exclude-emoji">&#10140</span> %3$s</a>
        </li>
        <li>
            <a class="ab-item" href="%6$s"><span class="wp-exclude-emoji">&#x2715;</span> %4$s</a>
        </li>
    </ul>
</div>',
                    self::ACTION_SCANNER_FOUND_SERVICES,
                    $this->generateNoticeTextFromServices($services, $countAll),
                    __('Take action now', RCB_TD),
                    __('Ignore hint', RCB_TD),
                    $scannerUrl,
                    add_query_arg(self::QUERY_ARG_DISMISS, 1)
                )
            ]
        ]);
    }
    /**
     * Generate the notice text from services.
     *
     * @param string[] $services
     * @param int $countAll
     */
    public function generateNoticeTextFromServices($services, $countAll) {
        $liElements = $services;
        if ($countAll > \count($services)) {
            $liElements[] = \sprintf('and %d other services', $countAll - \count($services));
        }
        // Generate list of services with "and x more"
        $text = \sprintf('<ul><li>%s</li></ul>', \join('</li><li>', $liElements));
        $text = \sprintf(
            // translators:
            __(
                'You have embedded the following services on your website: %s You may need to obtain consent for these services via your cookie banner to be able to use them in accordance with data protection regulations.',
                RCB_TD
            ),
            $text
        );
        return $text;
    }
    /**
     * Check if the query argument isset and dismiss the notice.
     */
    protected function probablyDismiss() {
        if (did_action('init') && isset($_GET[self::QUERY_ARG_DISMISS])) {
            $dismissedItems = get_option(self::OPTION_NAME, []);
            $dismissedItems = \array_unique(\array_merge($dismissedItems, $this->getServicesForNotice()[2]));
            update_option(self::OPTION_NAME, $dismissedItems);
            wp_safe_redirect(remove_query_arg(self::QUERY_ARG_DISMISS));
            exit();
        }
    }
    /**
     * Get a list of found services + external URLs which should be listed in the admin notice.
     *
     * @param int $max
     * @return array [services chunked to `$max`, count of all found services]
     */
    public function getServicesForNotice($max = 5) {
        $result = [];
        $dismissedItems = $this->getDismissedItems();
        // Collect non-existing presets
        $presets = (new \DevOwl\RealCookieBanner\scanner\ScanPresets())->getAllFromCache();
        $alreadyExistsTag = __('Already exists', RCB_TD);
        foreach ($presets as $preset) {
            if (
                isset($preset['tags'], $preset['tags'][$alreadyExistsTag]) ||
                \in_array($preset['identifier'], $dismissedItems, \true)
            ) {
                continue;
            }
            $result[] = [
                'identifier' => $preset['identifier'],
                'name' => $preset['name'],
                'priority' =>
                    ($preset['scanned'] !== \false ? \strtotime($preset['scanned']['lastScanned']) : 0) + \time()
            ];
        }
        $externalHosts = \DevOwl\RealCookieBanner\Core::getInstance()
            ->getScanner()
            ->getQuery()
            ->getScannedExternalUrls();
        foreach ($externalHosts as $host) {
            if (
                !$host['ignored'] &&
                $host['foundCount'] !== $host['blockedCount'] &&
                !\in_array($host['host'], $dismissedItems, \true)
            ) {
                $result[] = [
                    'identifier' => $host['host'],
                    'name' => $host['host'],
                    'priority' => \strtotime($host['lastScanned'])
                ];
            }
        }
        if (\count($result) === 0) {
            return [[], 0, []];
        }
        // Always show the newest found items as first item
        \array_multisort(\array_column($result, 'priority'), \SORT_DESC, $result);
        $readableNames = \array_column($result, 'name');
        $technicalNames = \array_column($result, 'identifier');
        return [\array_chunk($readableNames, $max)[0], \count($result), $technicalNames];
    }
    /**
     * Get dismissed items by preset or external host URL.
     */
    public function getDismissedItems() {
        $dismissedItems = get_option(self::OPTION_NAME);
        if ($dismissedItems === \false) {
            update_option(self::OPTION_NAME, []);
            return [];
        }
        return $dismissedItems;
    }
    /**
     * This is needed to get the home_url without any additional pathes (e.g. WPML).
     */
    protected function getOriginalHomeUrl() {
        // Check if constant is defined (https://wordpress.org/support/article/changing-the-site-url/#edit-wp-config-php)
        if (\defined('WP_HOME')) {
            $home_url = \constant('WP_HOME');
        } else {
            // Force so the options cache is filled
            get_option('home');
            // Directly read from our cache cause we want to skip `home` / `option_home` filters (https://git.io/JOnGV)
            // Why `alloptions`? Due to the fact that `home` is `autoloaded=yes`, it is loaded via `wp_load_alloptions` and filled
            // to the cache key `alloptions`. The filters are used by WPML and PolyLang but we do not care about them
            $alloptions = wp_cache_get('alloptions', 'options');
            $home_url = \is_array($alloptions) ? $alloptions['home'] : home_url();
        }
        $home_url = trailingslashit($home_url);
        $home_url = set_url_scheme($home_url, is_ssl() ? 'https' : 'http');
        return $home_url;
    }
    /**
     * New instance.
     *
     * @codeCoverageIgnore
     */
    public static function instance() {
        return new \DevOwl\RealCookieBanner\view\Scanner();
    }
}
