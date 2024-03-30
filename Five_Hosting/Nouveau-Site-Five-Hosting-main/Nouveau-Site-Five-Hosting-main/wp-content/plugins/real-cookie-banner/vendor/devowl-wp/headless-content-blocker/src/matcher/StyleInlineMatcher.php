<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher;

use DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\match\StyleInlineMatch;
use DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\match\TagAttributeMatch;
use DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\Utils;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\AttributesHelper;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\BlockedResult;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parser;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Property\Import;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\RuleSet\AtRuleSet;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Value\CSSString;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Value\RuleValueList;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Value\URL;
/**
 * Block inline `<style>`'s. This is a special use case and we need to go one step further:
 * The complete inline style is parsed to an abstract tree (AST) and all rules with an
 * URL are blocked individually.
 */
class StyleInlineMatcher extends \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher\AbstractMatcher {
    const EXTRACT_COMPLETE_AT_RULE_INSTEAD_OF_SINGLE_PROPERTY = ['font-face'];
    const DEFAULT_DUMMY_URL = 'https://assets.devowl.io/packages/devowl-wp/headless-content-blocker/';
    /**
     * See `AbstractMatcher`.
     *
     * @param StyleInlineMatch $match
     */
    public function match($match) {
        $result = $this->createResult($match);
        if (!$result->isBlocked()) {
            return \false;
        }
        $cb = $this->getHeadlessContentBlocker();
        $extract = $cb->runInlineStyleShouldBeExtractedByCallback(\true, $this, $match);
        list($document, $extractedDocument) = $this->parse($extract, $match);
        $cb->runInlineStyleModifyDocumentsCallback($document, $extractedDocument, $this, $match);
        if ($extractedDocument !== null) {
            $blockedStyle = $extractedDocument->render();
            // Return original document as we did not found any values that we needed to block
            if (
                !\DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\AttributesHelper::hasCssDocumentConsentRules(
                    $blockedStyle
                )
            ) {
                return \false;
            }
            $match->setStyle($document->render());
            $match->setAfterTag(
                \sprintf(
                    '<%1$s %2$s></%1$s>',
                    'script',
                    \DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\Utils::htmlAttributes(
                        \array_merge(
                            [
                                \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants::HTML_ATTRIBUTE_INLINE_STYLE => $blockedStyle,
                                \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants::HTML_ATTRIBUTE_TYPE_NAME =>
                                    \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants::HTML_ATTRIBUTE_TYPE_VALUE
                            ],
                            $match->getAttributes()
                        )
                    )
                )
            );
            $match->setAttributes([]);
        } else {
            $match->setAttribute(
                \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants::HTML_ATTRIBUTE_INLINE_STYLE,
                $document->render()
            );
            $match->setAttribute(
                \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants::HTML_ATTRIBUTE_TYPE_NAME,
                \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants::HTML_ATTRIBUTE_TYPE_VALUE
            );
            $match->setTag('script');
            $match->setStyle('');
        }
        return $result;
    }
    /**
     * See `AbstractMatcher`.
     *
     * @param StyleInlineMatch $match
     */
    public function createResult($match) {
        $result = $this->createPlainResultFromMatch($match);
        if ($match->isCSS()) {
            $this->iterateBlockablesInString($result, $match->getStyle(), \true, \true);
        }
        $this->probablyDisableDueToSkipped($result, $match);
        return $this->applyCheckResultHooks($result, $match);
    }
    /**
     * Check if a given URL is blocked.
     *
     * @param string $url
     * @param StyleInlineMatch $match
     * @return BlockedResult
     */
    public function createResultForSingleUrl($url, $match) {
        $result = new \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\BlockedResult(
            'style',
            [],
            $match->getStyle()
        );
        // Find all public content blockers and check URL
        foreach ($this->getBlockables() as $blockable) {
            // Iterate all wildcarded URLs
            foreach ($blockable->getContainsRegularExpressions() as $expression => $regex) {
                // m: Enable multiline search
                if (\preg_match($regex . 'm', $url)) {
                    // This link is definitely blocked by configuration
                    $result->setBlocked([$blockable]);
                    $result->setBlockedExpressions([$expression]);
                    break 2;
                }
            }
        }
        return $this->getHeadlessContentBlocker()->runInlineStyleBlockRuleCallback($result, $url, $this, $match);
    }
    /**
     * Parse a CSS and remove blocked URLs.
     *
     * @param boolean $extract
     * @param StyleInlineMatch $match
     */
    protected function parse($extract, $match) {
        // Original document (only CSS rules without blocked URLs)
        $parser = new \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parser($match->getStyle());
        $document = $parser->parse();
        // Extracted document (only CSS rules with blocked URLs)
        if ($extract) {
            $parser = new \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parser($match->getStyle());
            $extractedDocument = $parser->parse();
        } else {
            $extractedDocument = null;
        }
        list(
            $setUrlChanges,
            $removedFromOriginalDocument,
            $removedRuleSetsFromOriginalDocument
        ) = $this->generateLocationChangeSet($document, $extract, $match);
        // Prepare extracted document
        if ($extractedDocument !== null) {
            \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher\CssHelper::removeNonBlockedRulesFromDocument(
                $extractedDocument,
                $removedFromOriginalDocument,
                $removedRuleSetsFromOriginalDocument
            );
        }
        // Finally, block the URLs
        \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher\CssHelper::applyLocationChangeSet(
            $setUrlChanges,
            $extractedDocument === null ? $document : $extractedDocument
        );
        // Remove blanks
        \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher\CssHelper::removeBlanksFromCSSList(
            $document
        );
        \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher\CssHelper::removeBlanksFromCSSList(
            $extractedDocument
        );
        return [$document, $extractedDocument];
    }
    /**
     * Generate a list of changed `URL`s with their new URL. It also respects rule sets which needs to be completely
     * blocked and moved to the extracted document (e.g. `@font-face`).
     *
     * @param Document $document
     * @param boolean $extract
     * @param StyleInlineMatch $match
     */
    protected function generateLocationChangeSet($document, $extract, $match) {
        $removed = [];
        $removedRuleSets = [];
        // Delay the changes to the URLs so we can correctly extract the inline script (compare values)
        $setUrlChanges = [];
        // Iterate known rule-sets which need to be completely extracted when one value inside it is blocked (e.g. `@font-face`)
        foreach ($document->getAllRuleSets() as $ruleSet) {
            if (
                $ruleSet instanceof \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\RuleSet\AtRuleSet &&
                \in_array($ruleSet->atRuleName(), self::EXTRACT_COMPLETE_AT_RULE_INSTEAD_OF_SINGLE_PROPERTY, \true)
            ) {
                foreach ($ruleSet->getRules() as $rule) {
                    $val = $rule->getValue();
                    if ($val !== null) {
                        /**
                         * All rule values for this rule.
                         *
                         * @var array<RuleValueList|CSSFunction|CSSString|LineName|Size|URL|string>
                         */
                        $ruleValues = [];
                        if ($val instanceof \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Value\RuleValueList) {
                            $ruleValues = $val->getListComponents();
                        }
                        foreach ($ruleValues as $ruleValue) {
                            // External URLs are always objects
                            if (\is_string($ruleValue)) {
                                continue;
                            }
                            $ruleRemoved = [];
                            $ruleResult = $this->generateLocationChangeSetForSingleValue(
                                $document,
                                $ruleValue,
                                \false,
                                $match,
                                $ruleRemoved,
                                $setUrlChanges
                            );
                            if ($ruleResult) {
                                $removedRuleSets[] = $ruleSet;
                                // Special case: Extract the complete rule set
                                if ($extract) {
                                    $document->remove($ruleSet);
                                }
                            }
                        }
                    }
                }
            }
        }
        // Iterate each value in our stylesheet
        foreach ($document->getAllValues() as $val) {
            $this->generateLocationChangeSetForSingleValue($document, $val, $extract, $match, $removed, $setUrlChanges);
        }
        return [$setUrlChanges, $removed, $removedRuleSets];
    }
    /**
     * Generate a list of changed `URL`s with their new URL for a single value inside our parsed document.
     *
     * @param Document $document
     * @param Value $val
     * @param boolean $extract
     * @param StyleInlineMatch $match
     * @param array $removed
     * @param array $setUrlChanges
     */
    protected function generateLocationChangeSetForSingleValue(
        $document,
        $val,
        $extract,
        $match,
        &$removed,
        &$setUrlChanges
    ) {
        /**
         * The found URL instance.
         *
         * @var URL
         */
        $location = null;
        if ($val instanceof \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Property\Import) {
            $location = $val->getLocation();
            $dummyFileName = 'dummy.css';
        } elseif ($val instanceof \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Value\URL) {
            $location = $val;
            $dummyFileName = 'dummy.png';
        }
        if ($location !== null) {
            $url = $location->getURL()->getString();
            $ruleResult = $this->createResultForSingleUrl($url, $match);
            if ($ruleResult->isBlocked()) {
                // Remove from original document
                if ($extract) {
                    foreach (
                        \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher\CssHelper::removeValueFromDocument(
                            $val,
                            $document
                        )
                        as $remove
                    ) {
                        $removed[] = $remove;
                    }
                }
                // Adjust URL
                $setUrlChanges[] = [
                    $location,
                    new \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Value\CSSString(
                        $this->generateDummyUrl($ruleResult, $dummyFileName, $url)
                    )
                ];
                return \true;
            }
        }
        return \false;
    }
    /**
     * Get the new URL for a blocked value.
     *
     * @param BlockedResult $result
     * @param string $dummyFileName
     * @param string $originalUrl
     */
    protected function generateDummyUrl($result, $dummyFileName, $originalUrl) {
        $pseudoMatch = new \DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\match\TagAttributeMatch(
            null,
            null,
            null,
            [],
            null,
            null,
            null,
            null
        );
        $this->applyConsentAttributes($result, $pseudoMatch);
        $pseudoMatch->setAttribute(
            \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants::URL_QUERY_ARG_ORIGINAL_URL_IN_STYLE,
            \sprintf('%s-', \base64_encode($originalUrl))
        );
        // add trailing `-` to avoid removal of `==`]
        $configuredUrl = $this->getHeadlessContentBlocker()->getInlineStyleDummyUrlPath();
        return add_query_arg(
            $pseudoMatch->getAttributes(),
            ($configuredUrl !== null ? $configuredUrl : self::DEFAULT_DUMMY_URL) . $dummyFileName
        );
    }
}
