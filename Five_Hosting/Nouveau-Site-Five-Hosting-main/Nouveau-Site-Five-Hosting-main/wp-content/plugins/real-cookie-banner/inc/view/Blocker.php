<?php

namespace DevOwl\RealCookieBanner\view;

use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\AbstractBlockable;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\HeadlessContentBlocker;
use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\Localization;
use DevOwl\RealCookieBanner\settings\Blocker as SettingsBlocker;
use DevOwl\RealCookieBanner\settings\General;
use DevOwl\RealCookieBanner\Utils;
use DevOwl\RealCookieBanner\view\blockable\BlockerPostType;
use DevOwl\RealCookieBanner\view\blocker\Plugin;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Block common HTML tags!
 */
class Blocker {
    use UtilsProvider;
    const BUTTON_CLICKED_IDENTIFIER = 'unblock';
    /**
     * If a given class of the `parentElement` is given, set the visual parent. This is needed for
     * some page builder and theme compatibilities. This is only used on client-side (see `findVisualParent`).
     */
    const SET_VISUAL_PARENT_IF_CLASS_OF_PARENT = [
        // [Plugin Comp] Divi Builder
        'et_pb_video_box' => 1,
        // [Theme Comp] Astra Theme (Gutenberg Block)
        'ast-oembed-container' => 1
    ];
    const OB_START_PLUGINS_LOADED_PRIORITY = (\PHP_INT_MAX - 1) * -1;
    /**
     * Force to output the needed computing time at the end of the page for debug purposes.
     */
    const FORCE_TIME_COMMENT_QUERY_ARG = 'rcb-calc-time';
    /**
     * See `HeadlessContentBlocker`
     *
     * @var HeadlessContentBlocker
     */
    private $headlessContentBlocker;
    /**
     * C'tor.
     *
     * @codeCoverageIgnore
     */
    private function __construct() {
        // Silence is golden.
    }
    /**
     * Get `HeadlessContentBlocker` instance.
     */
    public function getHeadlessContentBlocker() {
        if ($this->headlessContentBlocker === null) {
            $headlessContentBlocker = new \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\HeadlessContentBlocker();
            // This is our custom Real Cookie Banner plugin (runs hooks, adds standard plugins, adds theme / plugin compatibilities, ...)
            $headlessContentBlocker->addPlugin(\DevOwl\RealCookieBanner\view\blocker\Plugin::class);
            $headlessContentBlocker->addBlockables($this->createBlockables());
            $headlessContentBlocker->setup();
            $this->headlessContentBlocker = $headlessContentBlocker;
        }
        return $this->headlessContentBlocker;
    }
    /**
     * Localize available content blockers for frontend.
     */
    public function localize() {
        $output = [];
        $blockers = \DevOwl\RealCookieBanner\settings\Blocker::getInstance()->getOrdered();
        foreach ($blockers as $blocker) {
            $output[] = \array_merge(
                ['id' => $blocker->ID, 'name' => $blocker->post_title, 'description' => $blocker->post_content],
                $blocker->metas
            );
        }
        return \DevOwl\RealCookieBanner\Core::getInstance()
            ->getCompLanguage()
            ->translateArray(
                $output,
                \array_merge(
                    \DevOwl\RealCookieBanner\settings\Blocker::SYNC_OPTIONS_COPY_AND_COPY_ONCE,
                    \DevOwl\RealCookieBanner\Localization::COMMON_SKIP_KEYS
                )
            );
    }
    /**
     * Apply the content blocker attributes to the output buffer when it is enabled.
     */
    public function registerOutputBuffer() {
        if ($this->isEnabled()) {
            \ob_start([$this, 'ob_start']);
        }
    }
    /**
     * Event for ob_start.
     *
     * @param string $response
     */
    public function ob_start($response) {
        if (\DevOwl\RealCookieBanner\Utils::isDownload()) {
            return $response;
        }
        $start = \microtime(\true);
        // Measure replace time
        /**
         * Block content in a given HTML string. This is a Consent API filter and can be consumed
         * by third-party plugin and theme developers. See example for usage.
         *
         * @hook Consent/Block/HTML
         * @param {string} $html
         * @return {string}
         * @example <caption>Block content of a given HTML string</caption>
         * $output = apply_filters('Consent/Block/HTML', '<iframe src="https://player.vimeo.com/..." />');
         */
        $newResponse = apply_filters('Consent/Block/HTML', $response);
        $time_elapsed_secs = \microtime(\true) - $start;
        $htmlEndComment = '<!--rcb-cb:' . \json_encode(['replace-time' => $time_elapsed_secs]) . '-->';
        return ($newResponse === null ? $response : $newResponse) .
            (isset($_GET[self::FORCE_TIME_COMMENT_QUERY_ARG]) ? $htmlEndComment : '');
    }
    /**
     * Apply content blockers to a given HTML. It also supports JSON output.
     *
     * If you want to use this functionality in your plugin, please use the filter `Consent/Block/HTML` instead!
     *
     * @param string $html
     */
    public function replace($html) {
        if (!$this->isEnabled()) {
            return $html;
        }
        return $this->getHeadlessContentBlocker()->modifyAny($html);
    }
    /**
     * Get all available blockables.
     *
     * @return AbstractBlockable[]
     */
    protected function createBlockables() {
        $blockables = [];
        $blockers = \DevOwl\RealCookieBanner\settings\Blocker::getInstance()->getOrdered();
        foreach ($blockers as &$blocker) {
            // Ignore blockers with no connected cookies
            if (
                \count($blocker->metas[\DevOwl\RealCookieBanner\settings\Blocker::META_NAME_COOKIES]) +
                    \count($blocker->metas[\DevOwl\RealCookieBanner\settings\Blocker::META_NAME_TCF_VENDORS]) ===
                0
            ) {
                continue;
            }
            $blockables[] = new \DevOwl\RealCookieBanner\view\blockable\BlockerPostType($blocker);
        }
        /**
         * Allows you to add, modify or remove existing `AbstractBlockable` instances. For usual,
         * they get generated of published Content Blocker post types records. This allows you
         * to block for example by custom criteria (cookies, TCF vendor, ...).
         *
         * **Note**: This hook is called only once, cause the result is cached for performance reasons!
         *
         * @hook RCB/Blocker/ResolveBlockables
         * @param {AbstractBlockable[]} $blockables
         * @return {AbstractBlockable[]}
         * @since 2.6.0
         */
        return apply_filters('RCB/Blocker/ResolveBlockables', $blockables);
    }
    /**
     * Check if content blocker is enabled on the current request.
     */
    protected function isEnabled() {
        $isEnabled =
            (\DevOwl\RealCookieBanner\Utils::isFrontend() || $this->isAdminAjaxAction()) &&
            \DevOwl\RealCookieBanner\settings\General::getInstance()->isBannerActive() &&
            \DevOwl\RealCookieBanner\settings\General::getInstance()->isBlockerActive() &&
            !\DevOwl\RealCookieBanner\Utils::isPageBuilderFrontend() &&
            !is_customize_preview();
        /**
         * Allows you to force the content blocker take action. This is especially
         * useful if you want to use the blocker functionality for custom mechanism
         * like Scanner.
         *
         * @hook RCB/Blocker/Enabled
         * @param {boolean} $isEnabled
         * @return {boolean}
         * @since 2.6.0
         */
        return apply_filters('RCB/Blocker/Enabled', $isEnabled);
    }
    /**
     * Allows to modify content within a `admin-ajax.php` action.
     */
    protected function isAdminAjaxAction() {
        return wp_doing_ajax() &&
            isset($_REQUEST['action']) &&
            \in_array(
                $_REQUEST['action'],
                [
                    // [Plugin Comp] https://wordpress.org/plugins/modern-events-calendar-lite/
                    'mec_load_single_page'
                ],
                \true
            );
    }
    /**
     * Modify any URL and add a query argument to skip the content blocker mechanism.
     *
     * @param string $url
     */
    public function modifyUrlToSkipContentBlocker($url) {
        return add_query_arg(
            // Use the `fl_builder` argument which is covered by `Utils::isPageBuilder()`
            ['fl_builder' => '1'],
            $url
        );
    }
    /**
     * New instance.
     *
     * @codeCoverageIgnore
     */
    public static function instance() {
        return new \DevOwl\RealCookieBanner\view\Blocker();
    }
}
