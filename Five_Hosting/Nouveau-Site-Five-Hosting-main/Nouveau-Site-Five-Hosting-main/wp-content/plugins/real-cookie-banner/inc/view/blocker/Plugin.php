<?php

namespace DevOwl\RealCookieBanner\view\blocker;

use DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\match\AbstractMatch;
use DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\match\ScriptInlineMatch;
use DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\match\StyleInlineMatch;
use DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\match\TagAttributeMatch;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\AbstractPlugin;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\BlockedResult;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher\ScriptInlineMatcher;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher\SelectorSyntaxMatcher;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher\StyleInlineMatcher;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher\TagAttributeMatcher;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\plugins\Autoplay;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\plugins\DoNotBlockScriptTextTemplates;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\plugins\Image;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\plugins\LazyLoadingLibraries;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\plugins\LinkBlocker;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\plugins\LinkRelBlocker;
use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\CSSList\Document;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Real Cookie Banner plugin for `HeadlessContentBlocker`.
 */
class Plugin extends \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\AbstractPlugin {
    use UtilsProvider;
    // Documented in AbstractPlugin
    public function init() {
        $cb = $this->getHeadlessContentBlocker();
        $cb->addTagAttributeMap(
            [],
            [
                // [Plugin Comp] JetElements for Elementor
                'data-lazy-load'
            ]
        );
        /**
         * `<div>` elements are expensive in Regexp cause there a lot of them, let's assume only a
         * set of attributes to get a match. For example, WP Rockets' lazy loading technology modifies
         * iFrames and YouTube embeds.
         *
         * @see https://git.io/JLQSy
         */
        $cb->addTagAttributeMap(
            ['div'],
            [
                // [Plugin Comp] WP Rocket
                'data-src',
                'data-lazy-src',
                // [Theme Comp] FloThemes
                'data-flo-video-embed-embed-code',
                // [Plugin Comp] JetElements for Elementor
                'style',
                // [Theme Comp] Themify
                'data-url'
            ],
            'expensiveDiv'
        );
        $cb->addKeepAlwaysAttributes([
            // [Theme Comp] FloThemes
            'data-flo-video-embed-embed-code'
        ]);
        $cb->addKeepAlwaysAttributesIfClass([
            // [Plugin Comp] Ultimate Video (WP Bakery Page Builder)
            'ultv-video__play' => ['data-src'],
            // [Plugin Comp] Elementor Video Widget
            'elementor-widget-video' => ['data-settings']
        ]);
        $cb->addVisualParentIfClass([
            // [Theme Comp] FloThemes
            'flo-video-embed__screen' => 2,
            // [Plugin Comp] Ultimate Video (WP Bakery Page Builder)
            'ultv-video__play' => 2,
            // [Plugin Comp] Elementor
            'elementor-widget' => 'children:.elementor-widget-container',
            // [Plugin Comp] Thrive Architect
            'thrv_responsive_video' => 'children:iframe'
        ]);
        $cb->addSkipInlineScriptVariableAssignments([
            '_wpCustomizeSettings',
            // [Plugin Comp] Divi
            'et_animation_data',
            'et_link_options_data',
            // [Plugin Comp] https://wordpress.org/plugins/groovy-menu-free/
            'groovyMenuSettings',
            // [Plugin Comp] https://wordpress.org/plugins/meow-lightbox/
            'mwl_data'
        ]);
        $cb->setInlineStyleDummyUrlPath(plugins_url('public/images/', RCB_FILE));
        // Other plugins
        $cb->addPlugin(
            \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\plugins\DoNotBlockScriptTextTemplates::class
        );
        $cb->addPlugin(\DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\plugins\Autoplay::class);
        $cb->addPlugin(\DevOwl\RealCookieBanner\view\blocker\PluginAutoplay::class);
        $cb->addPlugin(
            \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\plugins\LazyLoadingLibraries::class
        );
        $cb->addPlugin(\DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\plugins\LinkRelBlocker::class);
        $cb->addPlugin(\DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\plugins\Image::class);
        /**
         * Plugin.
         *
         * @var LinkBlocker
         */
        $linkBlockerPlugin = $cb->addPlugin(
            \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\plugins\LinkBlocker::class
        );
        $linkBlockerPlugin->addBlockIfClass([
            // [Plugin Comp] https://wordpress.org/plugins/foobox-image-lightbox/
            'foobox'
        ]);
    }
    /**
     * See `AbstractPlugin`.
     *
     * @param AbstractMatcher $matcher
     * @param AbstractMatch $match
     */
    public function beforeMatch($matcher, $match) {
        /**
         * Check if a given tag, link attribute and link is blocked.
         *
         * @hook RCB/Blocker/IsBlocked/AllowMultiple
         * @param {boolean} $allowMultiple
         * @return {boolean}
         * @since 2.6.0
         */
        $allowMultiple = apply_filters('RCB/Blocker/IsBlocked/AllowMultiple', \false);
        $this->getHeadlessContentBlocker()->setAllowMultipleBlockerResults($allowMultiple);
    }
    /**
     * See `AbstractPlugin`.
     *
     * @param BlockedResult $result
     * @param AbstractMatcher $matcher
     * @param AbstractMatch $match
     */
    public function blockedMatch($result, $matcher, $match) {
        if (
            $matcher instanceof
            \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher\TagAttributeMatcher
        ) {
            /**
             * Var.
             *
             * @var TagAttributeMatch
             */
            $match = $match;
            /**
             * A tag got blocked, e. g. `iframe`. We can now modify the attributes again to add an additional attribute to
             * the blocked content. This can be especially useful if you want to block additional attributes like `srcset`.
             * Do not forget to hook into the frontend and transform the modified attributes!
             *
             * @hook RCB/Blocker/HTMLAttributes
             * @param {array} $attributes
             * @param {BlockedResult} $isBlocked Since 3.0.0 this is an instance of `BlockedResult`
             * @param {string} $newLinkAttribute
             * @param {string} $linkAttribute
             * @param {string} $link
             * @return {array}
             */
            $attributes = apply_filters(
                'RCB/Blocker/HTMLAttributes',
                $match->getAttributes(),
                $result,
                $result->getData('newLinkAttribute'),
                $match->getLinkAttribute(),
                $match->getLink()
            );
            $match->setAttributes($attributes);
        } elseif (
            $match instanceof \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher\ScriptInlineMatcher
        ) {
            /**
             * Var.
             *
             * @var ScriptInlineMatch
             */
            $match = $match;
            /**
             * An inline script got blocked, e. g. `iframe`. We can now modify the attributes again to add an additional attribute to
             * the blocked script. Do not forget to hook into the frontend and transform the modified attributes!
             *
             * @hook RCB/Blocker/InlineScript/HTMLAttributes
             * @param {array} $attributes
             * @param {array} $isBlocked Since 3.0.0 this is an instance of `BlockedResult`
             * @param {string} $script
             * @return {array}
             */
            $attributes = apply_filters(
                'RCB/Blocker/InlineScript/HTMLAttributes',
                $match->getAttributes(),
                $result,
                $match->getAttribute(
                    \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants::HTML_ATTRIBUTE_INLINE
                )
            );
            $match->setAttributes($attributes);
        }
    }
    /**
     * See `AbstractPlugin`.
     *
     * @param BlockedResult $result
     * @param AbstractMatcher $matcher
     * @param AbstractMatch $match
     */
    public function checkResult($result, $matcher, $match) {
        if (
            $matcher instanceof
            \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher\TagAttributeMatcher
        ) {
            /**
             * Var.
             *
             * @var TagAttributeMatch
             */
            $match = $match;
            /**
             * Check if a given tag, link attribute and link is blocked.
             *
             * @hook RCB/Blocker/IsBlocked
             * @param {BlockedResult} $isBlocked Since 3.0.0 this is an instance of `BlockedResult`
             * @param {string} $linkAttribute
             * @param {string} $link
             * @return {BlockedResult}
             */
            $result = apply_filters('RCB/Blocker/IsBlocked', $result, $match->getLinkAttribute(), $match->getLink());
        } elseif (
            $matcher instanceof
            \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher\ScriptInlineMatcher
        ) {
            /**
             * Var.
             *
             * @var ScriptInlineMatch
             */
            $match = $match;
            /**
             * Check if a given inline script is blocked.
             *
             * @hook RCB/Blocker/InlineScript/IsBlocked
             * @param {BlockedResult} $isBlocked Since 3.0.0 this is an instance of `BlockedResult`
             * @param {string} $script
             * @return {BlockedResult}
             */
            $result = apply_filters('RCB/Blocker/InlineScript/IsBlocked', $result, $match->getScript());
        } elseif (
            $matcher instanceof \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher\StyleInlineMatcher
        ) {
            /**
             * Var.
             *
             * @var StyleInlineMatch
             */
            $match = $match;
            /**
             * Check if a given inline style is blocked.
             *
             * @hook RCB/Blocker/InlineStyle/IsBlocked
             * @param {BlockedResult} $isBlocked Since 3.0.0 this is an instance of `BlockedResult`
             * @param {string} $style
             * @return {BlockedResult}
             */
            $result = apply_filters('RCB/Blocker/InlineStyle/IsBlocked', $result, $match->getStyle());
        } elseif (
            $matcher instanceof
            \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher\SelectorSyntaxMatcher
        ) {
            /**
             * Check if a element blocked by custom element blocking (Selector Syntax) is blocked.
             *
             * @hook RCB/Blocker/SelectorSyntax/IsBlocked
             * @param {BlockedResult} $isBlocked Since 3.0.0 this is an instance of `BlockedResult`
             * @param {SelectorSyntaxMatch} $match
             * @return {BlockedResult}
             * @since 2.6.0
             */
            $result = apply_filters('RCB/Blocker/SelectorSyntax/IsBlocked', $result, $match);
        }
        return $result;
    }
    /**
     * See `AbstractPlugin`.
     *
     * @param string[] $keepAttributes
     * @param AbstractMatcher $matcher
     * @param AbstractMatch $match
     * @return string[]
     */
    public function keepAlwaysAttributes($keepAttributes, $matcher, $match) {
        if (
            $matcher instanceof
            \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher\TagAttributeMatcher
        ) {
            /**
             * Var.
             *
             * @var TagAttributeMatch
             */
            $match = $match;
            /**
             * In some cases we need to keep the attributes as original instead of prefix it with `consent-original-`.
             * Keep in mind, that no external data should be loaded if the attribute is set!
             *
             * @hook RCB/Blocker/KeepAttributes
             * @param {string[]} $keepAttributes
             * @param {string} $tag
             * @param {array} $attributes
             * @param {string} $linkAttribute
             * @param {string} $link
             * @return {string[]}
             * @since 1.5.0
             */
            $keepAttributes = apply_filters(
                'RCB/Blocker/KeepAttributes',
                $keepAttributes,
                $match->getTag(),
                $match->getAttributes(),
                $match->getLinkAttribute(),
                $match->getLink()
            );
        }
        return $keepAttributes;
    }
    /**
     * See `AbstractPlugin`.
     *
     * @param string[] $names
     * @param ScriptInlineMatcher $matcher
     * @param ScriptInlineMatch $match
     * @return string[]
     */
    public function skipInlineScriptVariableAssignment($names, $matcher, $match) {
        if (
            \DevOwl\RealCookieBanner\Core::getInstance()
                ->getScanner()
                ->isActive()
        ) {
            $names[] = 'DO_NOT_COMPUTE';
        }
        /**
         * Check if a given inline script is blocked by a localized variable name (e.g. `wp_localize_script`).
         *
         * @hook RCB/Blocker/InlineScript/AvoidBlockByLocalizedVariable
         * @param {string[]} $variables
         * @param {string} $script
         * @return {string[]}
         * @since 1.14.1
         */
        return apply_filters('RCB/Blocker/InlineScript/AvoidBlockByLocalizedVariable', $names, $match->getScript());
    }
    /**
     * See `AbstractPlugin`.
     *
     * @param boolean $extract
     * @param StyleInlineMatcher $matcher
     * @param StyleInlineMatch $match
     * @return boolean
     */
    public function inlineStyleShouldBeExtracted($extract, $matcher, $match) {
        /**
         * Determine, if the current inline style should be split into two inline styles. One inline style
         * with only CSS rules without blocked URLs and the second one with only CSS rules with blocked URLs.
         *
         * @hook RCB/Blocker/InlineStyle/Extract
         * @param {boolean} $extract
         * @param {string} $style
         * @param {array} $attributes
         * @return {boolean}
         * @since 1.13.2
         */
        return apply_filters('RCB/Blocker/InlineStyle/Extract', \true, $match->getStyle(), $match->getAttributes());
    }
    /**
     * See `AbstractPlugin`.
     *
     * @param Document $document
     * @param Document $extractedDocument
     * @param StyleInlineMatcher $matcher
     * @param StyleInlineMatch $match
     * @return boolean
     */
    public function inlineStyleModifyDocuments($document, $extractedDocument, $matcher, $match) {
        /**
         * An inline style got blocked. We can now modify the rules again with the help of `\Sabberworm\CSS\CSSList\Document`.
         *
         * @hook RCB/Blocker/InlineStyle/Document
         * @param {Document} $document `\Sabberworm\CSS\CSSList\Document`
         * @param {Document} $extractedDocument `\Sabberworm\CSS\CSSList\Document`
         * @param {array} $attributes
         * @param {AbstractBlockable[]} $blockables
         * @param {string} $style
         * @see https://github.com/sabberworm/PHP-CSS-Parser
         * @since 1.13.2
         */
        do_action(
            'RCB/Blocker/InlineStyle/Document',
            $document,
            $extractedDocument,
            $match->getAttributes(),
            $this->getHeadlessContentBlocker()->getBlockables(),
            $match->getStyle()
        );
    }
    /**
     * See `AbstractPlugin`.
     *
     * @param BlockedResult $result
     * @param string $url
     * @param StyleInlineMatcher $matcher
     * @param StyleInlineMatch $match
     * @return boolean
     */
    public function inlineStyleBlockRule($result, $url, $matcher, $match) {
        /**
         * Check if a given inline CSS rule is blocked.
         *
         * @hook RCB/Blocker/InlineStyle/Rule/IsBlocked
         * @param {BlockedResult} $isBlocked Since 3.0.0 this is an instance of `BlockedResult`
         * @param {string} $url
         * @return {BlockedResult}
         * @since 1.13.2
         */
        return apply_filters('RCB/Blocker/InlineStyle/Rule/IsBlocked', $result, $url);
    }
    /**
     * See `AbstractPlugin`.
     *
     * @param boolean|string|number $visualParent
     * @param AbstractMatcher $matcher
     * @param AbstractMatch $match
     * @return boolean|string|number
     */
    public function visualParent($visualParent, $matcher, $match) {
        if (
            $matcher instanceof
            \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher\TagAttributeMatcher
        ) {
            /**
             * Var.
             *
             * @var TagAttributeMatch
             */
            $match = $match;
            /**
             * A tag got blocked, e. g. `iframe`. We can now determine the "Visual Parent". The visual parent is the
             * closest parent where the content blocker should be placed to. The visual parent can be configured as follow:
             *
             *- `false` = Use original element
             * - `true` = Use parent element
             * - `number` = Go upwards x element (parentElement)
             * - `string` = Go upwards until parentElement matches a selector
             * - `string` = Starting with `children:` you can `querySelector` down to create the visual parent for a children (since 2.0.4)
             *
             * @hook RCB/Blocker/VisualParent
             * @param {boolean|string|number} $useVisualParent
             * @param {string} $tag
             * @param {array} $attributes
             * @return {boolean|string|number}
             * @since 1.5.0
             */
            $visualParent = apply_filters(
                'RCB/Blocker/VisualParent',
                $visualParent,
                $match->getTag(),
                $match->getAttributes()
            );
        }
        return $visualParent;
    }
    /**
     * See `AbstractPlugin`.
     *
     * @param string $html
     */
    public function modifyHtmlAfterProcessing($html) {
        /**
         * Modify HTML content for content blockers. This is called directly after the core
         * content blocker has done its job for common HTML tags (iframe, scripts, ... ) and
         * inline scripts.
         *
         * @hook RCB/Blocker/HTML
         * @param {string} $html
         * @return {string}
         */
        return apply_filters('RCB/Blocker/HTML', $html);
    }
}
