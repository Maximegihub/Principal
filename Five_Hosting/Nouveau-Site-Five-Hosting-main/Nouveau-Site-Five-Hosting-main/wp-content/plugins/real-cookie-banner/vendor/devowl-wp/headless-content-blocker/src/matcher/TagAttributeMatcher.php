<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher;

use DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\match\TagAttributeMatch;
/**
 * Match by `TagAttributeFinder`.
 */
class TagAttributeMatcher extends
    \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher\AbstractMatcher {
    /**
     * See `AbstractMatcher`.
     *
     * @param TagAttributeMatch $match
     */
    public function match($match) {
        $result = $this->createResult($match);
        if (!$result->isBlocked()) {
            return \false;
        }
        $linkAttribute = $match->getLinkAttribute();
        $link = $match->getLink();
        $this->applyCommonAttributes($result, $match, $linkAttribute, $link);
        return $result;
    }
    /**
     * See `AbstractMatcher`.
     *
     * @param TagAttributeMatch $match
     */
    public function createResult($match) {
        $result = $this->createPlainResultFromMatch($match);
        $this->iterateBlockablesInString($result, $match->getLink());
        $this->probablyDisableDueToSkipped($result, $match);
        return $this->applyCheckResultHooks($result, $match);
    }
}
