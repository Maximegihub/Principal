<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher;

use DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\match\ScriptInlineMatch;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants;
/**
 * Match by `ScriptInlineMatcher`.
 */
class ScriptInlineMatcher extends
    \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher\AbstractMatcher {
    /**
     * See `AbstractMatcher`.
     *
     * @param ScriptInlineMatch $match
     */
    public function match($match) {
        $result = $this->createResult($match);
        $blockedBySyntaxSelectorLinkAttribute = null;
        $blockedBySyntaxSelectorLink = null;
        if (!$result->isBlocked()) {
            // Check if this script got blocked by a custom element blocker
            foreach ($this->getBlockables() as $blockable) {
                $foundSelectorSyntaxFinder = $blockable->findSelectorSyntaxFinderForMatch($match);
                if ($foundSelectorSyntaxFinder !== null) {
                    $blockedBySyntaxSelectorLinkAttribute = $foundSelectorSyntaxFinder->getAttribute();
                    $blockedBySyntaxSelectorLink = $match->getAttribute($foundSelectorSyntaxFinder->getAttribute());
                    $result->setBlocked([$blockable]);
                    $result->setBlockedExpressions([$foundSelectorSyntaxFinder->getExpression()]);
                }
            }
            // Still not blocked?
            if (!$result->isBlocked()) {
                return \false;
            }
        }
        $this->applyCommonAttributes(
            $result,
            $match,
            $blockedBySyntaxSelectorLinkAttribute,
            $blockedBySyntaxSelectorLink
        );
        $match->setAttribute(
            \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants::HTML_ATTRIBUTE_INLINE,
            $match->getScript()
        );
        $match->setScript('');
        return $result;
    }
    /**
     * See `AbstractMatcher`.
     *
     * @param ScriptInlineMatch $match
     */
    public function createResult($match) {
        $result = $this->createPlainResultFromMatch($match);
        if (
            $match->isJavascript() &&
            !$match->isCData() &&
            !$match->isScriptOnlyVariableAssignment(['realCookieBanner'], \false)
        ) {
            $this->iterateBlockablesInString($result, $match->getScript(), \true, \true);
        }
        $this->probablyDisableDueToSkipped($result, $match);
        if ($result->isBlocked() && $this->isLocalizedVariable($match)) {
            $result->disableBlocking();
        }
        return $this->applyCheckResultHooks($result, $match);
    }
    /**
     * Check if a given inline script is produced by `wp_localized_script` and starts with
     * something like `var xxxxx=`.
     *
     * @param ScriptInlineMatch $match
     */
    protected function isLocalizedVariable($match) {
        $cb = $this->getHeadlessContentBlocker();
        $names = $cb->getSkipInlineScriptVariableAssignments();
        $names = $cb->runSkipInlineScriptVariableAssignmentsCallback($names, $this, $match);
        return $match->isScriptOnlyVariableAssignment($names, !\in_array('DO_NOT_COMPUTE', $names, \true));
    }
}
