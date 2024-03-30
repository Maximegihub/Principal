<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\plugins;

use DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\match\AbstractMatch;
use DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\match\TagAttributeMatch;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\AbstractPlugin;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\BlockedResult;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher\AbstractMatcher;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher\TagAttributeMatcher;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Block `<link`'s with `preconnect` and `dns-prefetch`.
 */
class LinkRelBlocker extends \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\AbstractPlugin {
    const REL = ['preconnect', 'dns-prefetch'];
    /**
     * See `AbstractPlugin`.
     *
     * @param BlockedResult $result
     * @param AbstractMatcher $matcher
     * @param AbstractMatch $match
     */
    public function checkResult($result, $matcher, $match) {
        if (
            !$result->isBlocked() &&
            $matcher instanceof
                \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher\TagAttributeMatcher &&
            $match->getTag() === 'link' &&
            $match->hasAttribute('rel') &&
            \in_array($match->getAttribute('rel'), self::REL, \true)
        ) {
            /**
             * Var.
             *
             * @var TagAttributeMatch
             */
            $match = $match;
            $matcher->iterateBlockablesInString(
                $result,
                $match->getLink(),
                \false,
                \false,
                $this->getHeadlessContentBlocker()->blockablesToHosts()
            );
        }
        return $result;
    }
}
