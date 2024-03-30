<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher;

use DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\match\SelectorSyntaxMatch;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\AbstractBlockable;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\AttributesHelper;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\HeadlessContentBlocker;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\plugins\Image;
/**
 * Block a HTML element by CSS-like selectors, e.g. `div[class="my-class"]`.
 */
class SelectorSyntaxMatcher extends
    \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher\AbstractMatcher {
    private $blockable;
    /**
     * C'tor.
     *
     * @param HeadlessContentBlocker $headlessContentBlocker
     * @param AbstractBlockable $blockable
     * @codeCoverageIgnore
     */
    public function __construct($headlessContentBlocker, $blockable) {
        parent::__construct($headlessContentBlocker);
        $this->blockable = $blockable;
    }
    /**
     * See `AbstractMatcher`.
     *
     * @param SelectorSyntaxMatch $match
     */
    public function match($match) {
        $result = $this->createResult($match);
        if (!$result->isBlocked()) {
            return \false;
        }
        $this->applyCommonAttributes($result, $match, $match->getLinkAttribute(), $match->getLink());
        // Disable known loading attributes like `href` or `src`
        $tagAttributeMap = $this->getHeadlessContentBlocker()->getTagAttributeMap();
        $loadingAttributes =
            $tagAttributeMap[
                \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\HeadlessContentBlocker
                    ::TAG_ATTRIBUTE_MAP_LINKABLE
            ]['attr'] ?? [];
        // Edge cases: Plugins
        $loadingAttributes[] =
            \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\plugins\Image::HTML_ATTRIBUTE_SRCSET;
        foreach ($loadingAttributes as $loadingAttr) {
            if ($match->hasAttribute($loadingAttr)) {
                $newAttribute = \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\AttributesHelper::transformAttribute(
                    $loadingAttr
                );
                $match->setAttribute($newAttribute, $match->getAttribute($loadingAttr));
                $match->setAttribute($loadingAttr, null);
            }
        }
        return $result;
    }
    /**
     * See `AbstractMatcher`.
     *
     * @param SelectorSyntaxMatch $match
     */
    public function createResult($match) {
        $result = $this->createPlainResultFromMatch($match);
        $result->setBlocked([$this->blockable]);
        $result->setBlockedExpressions([$match->getFinder()->getExpression()]);
        $this->probablyDisableDueToSkipped($result, $match);
        if (
            \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\AttributesHelper::isAlreadyBlocked(
                $match->getAttributes()
            )
        ) {
            $result->disableBlocking();
        }
        return $this->applyCheckResultHooks($result, $match);
    }
}
