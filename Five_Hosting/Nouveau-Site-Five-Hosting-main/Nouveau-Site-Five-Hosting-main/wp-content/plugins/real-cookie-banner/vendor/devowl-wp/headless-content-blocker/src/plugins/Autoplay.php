<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\plugins;

use DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\match\AbstractMatch;
use DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\match\TagAttributeMatch;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\AbstractPlugin;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\AttributesHelper;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher\AbstractMatcher;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher\TagAttributeMatcher;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Utils;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Convert links to autoplay links for known video and sound platforms.
 */
class Autoplay extends \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\AbstractPlugin {
    const HTML_TAG_IFRAME = 'iframe';
    const HTML_TAG_DIV = 'div';
    const HTML_ATTRIBUTE_SRC = 'src';
    /**
     * Some plugins are using `data-src` (e.g. Thrive Architect) to provide the iframe to the frontend.
     */
    const HTML_ATTRIBUTE_ALTERNATIVE_SRC = 'data-src';
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
            $tag = $match->getTag();
            $linkAttribute = $match->getLinkAttribute();
            $link = $match->getLink();
            if (
                $tag === self::HTML_TAG_IFRAME &&
                \in_array($linkAttribute, [self::HTML_ATTRIBUTE_SRC, self::HTML_ATTRIBUTE_ALTERNATIVE_SRC], \true)
            ) {
                $autoplayUrl = $this->transformUrl($link);
                // Add the attribute
                if ($autoplayUrl !== null) {
                    $clickAttribute = \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\AttributesHelper::transformAttribute(
                        $linkAttribute,
                        \true
                    );
                    $match->setAttribute($clickAttribute, $autoplayUrl);
                }
            }
        }
    }
    /**
     * Transform a given YouTube / Vimeo URL to autoplay URL.
     *
     * @param string $link
     */
    protected function transformUrl($link) {
        $autoplayUrl = null;
        $host = \parse_url($link, \PHP_URL_HOST);
        if (
            \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Utils::endsWith($host, 'youtube.com') ||
            \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Utils::endsWith($host, 'dailymotion.com') ||
            \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Utils::endsWith($host, 'loom.com')
        ) {
            $autoplayUrl = add_query_arg('autoplay', '1', $link);
        }
        // Vimeo (https://vimeo.zendesk.com/hc/en-us/articles/115004485728-Autoplaying-and-looping-embedded-videos)
        if (\DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Utils::endsWith($host, 'vimeo.com')) {
            $autoplayUrl = add_query_arg(['autoplay' => '1', 'loop' => '1'], $link);
        }
        return $autoplayUrl;
    }
}
