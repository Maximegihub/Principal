<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker;

use DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\match\AbstractMatch;
use DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\match\ScriptInlineMatch;
use DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\match\StyleInlineMatch;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher\AbstractMatcher;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher\ScriptInlineMatcher;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher\StyleInlineMatcher;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\CSSList\Document;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Describes a plugin for `HeadlessContentBlocker`. You can override each of this methods.
 */
abstract class AbstractPlugin {
    private $headlessContentBlocker;
    /**
     * C'tor.
     *
     * @param HeadlessContentBlocker $headlessContentBlocker
     * @codeCoverageIgnore
     */
    final public function __construct($headlessContentBlocker) {
        $this->headlessContentBlocker = $headlessContentBlocker;
    }
    /**
     * The content blocker got setup completely.
     */
    public function afterSetup() {
        // Silence is golden.
    }
    /**
     * Initialize your plugin add e.g. new visual parent definitions.
     */
    public function init() {
        // Silence is golden.
    }
    /**
     * Allows to modify the HTML after the content blocker has done its job.
     *
     * @param string $html
     */
    public function modifyHtmlAfterProcessing($html) {
        return $html;
    }
    /**
     * Called before a match got found.
     *
     * @param AbstractMatcher $matcher
     * @param AbstractMatch $match
     */
    public function beforeMatch($matcher, $match) {
        // Silence is golden.
    }
    /**
     * Called after a match got blocked.
     *
     * @param BlockedResult $result
     * @param AbstractMatcher $matcher
     * @param AbstractMatch $match
     */
    public function blockedMatch($result, $matcher, $match) {
        // Silence is golden.
    }
    /**
     * Called after a match got found and the matcher decided, if it should be blocked or not.
     *
     * @param BlockedResult $result
     * @param AbstractMatcher $matcher
     * @param AbstractMatch $match
     * @return BlockedResult
     */
    public function checkResult($result, $matcher, $match) {
        return $result;
    }
    /**
     * Keep attributes for a specific match.
     *
     * @param string[] $keepAttributes
     * @param AbstractMatcher $matcher
     * @param AbstractMatch $match
     * @return string[]
     */
    public function keepAlwaysAttributes($keepAttributes, $matcher, $match) {
        return $keepAttributes;
    }
    /**
     * Skip inline script by variable name.
     *
     * @param string[] $names
     * @param ScriptInlineMatcher $matcher
     * @param ScriptInlineMatch $match
     * @return string[]
     */
    public function skipInlineScriptVariableAssignment($names, $matcher, $match) {
        return $names;
    }
    /**
     * Do not extract blocked rules of a CSS inline script to a second document.
     *
     * @param boolean $extract
     * @param StyleInlineMatcher $matcher
     * @param StyleInlineMatch $match
     * @return boolean
     */
    public function inlineStyleShouldBeExtracted($extract, $matcher, $match) {
        return $extract;
    }
    /**
     * Allows to modify blocked CSS documents.
     *
     * @param Document $document
     * @param Document $extractedDocument
     * @param StyleInlineMatcher $matcher
     * @param StyleInlineMatch $match
     * @return boolean
     */
    public function inlineStyleModifyDocuments($document, $extractedDocument, $matcher, $match) {
        // Silence is golden.
    }
    /**
     * Decide if a URL in a CSS rule should be blocked.
     *
     * @param BlockedResult $result
     * @param string $url
     * @param StyleInlineMatcher $matcher
     * @param StyleInlineMatch $match
     * @return boolean
     */
    public function inlineStyleBlockRule($result, $url, $matcher, $match) {
        return $result;
    }
    /**
     * Set a visual parent for a specific match.
     *
     * @param boolean|string|number $visualParent
     * @param AbstractMatcher $matcher
     * @param AbstractMatch $match
     * @return boolean|string|number
     */
    public function visualParent($visualParent, $matcher, $match) {
        return $visualParent;
    }
    /**
     * Getter.
     *
     * @codeCoverageIgnore
     */
    final public function getHeadlessContentBlocker() {
        return $this->headlessContentBlocker;
    }
}
