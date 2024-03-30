<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\match;

use DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\ScriptInlineFinder;
use DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\Utils;
/**
 * Match defining a `ScriptInlineFinder` match.
 */
class ScriptInlineMatch extends \DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\match\AbstractMatch {
    private $script;
    /**
     * If an inline script starts with a given expression, let's test the complete script if it is a variable (CDATA).
     *
     * @see https://regex101.com/r/eskNoj/1
     * @see https://regex101.com/r/tKtAKd/1
     */
    const SKIP_VARIABLES_IF_REGEXP_START = '/((var|const|let)\\s+)?[A-Za-z\\.\\[\\]"\']+\\s?=\\s+?{/';
    const SKIP_VARIABLES_IF_REGEXP_END = '/};?$/';
    /**
     * C'tor.
     *
     * @param ScriptInlineFinder $finder
     * @param string $originalMatch
     * @param array $attributes
     * @param string $script
     */
    public function __construct($finder, $originalMatch, $attributes, $script) {
        parent::__construct($finder, $originalMatch, 'script', $attributes);
        $this->script = $script;
    }
    // See `AbstractRegexFinder`.
    public function render() {
        $attributes = $this->getAttributes();
        return $this->encloseRendered(
            $this->hasChanged()
                ? \sprintf(
                    '<%1$s%2$s>%3$s</%1$s>',
                    $this->getTag(),
                    \count($attributes) > 0
                        ? ' ' . \DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\Utils::htmlAttributes($attributes)
                        : '',
                    $this->getScript()
                )
                : $this->getOriginalMatch()
        );
    }
    /**
     * Check if the script is javascript.
     */
    public function isJavascript() {
        $type = $this->getAttribute('type');
        return empty($type) ? \true : \strpos($type, 'javascript') !== \false;
    }
    /**
     * Check if the script is a `CDATA`.
     */
    public function isCData() {
        return \DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\Utils::startsWith(
            \trim($this->getScript()),
            '/' . '* <![CDATA[ */'
        );
    }
    /**
     * Check if the script only contains a variable assignment.
     *
     * @param string[] $variableNames Pass an optional array of variable names
     * @param boolean $compute If `true`, it will try to parse the variable
     */
    public function isScriptOnlyVariableAssignment($variableNames = [], $compute = \true) {
        $trimmedScript = \trim($this->getScript());
        foreach ($variableNames as $variable) {
            if (
                \DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\Utils::startsWith(
                    $trimmedScript,
                    \sprintf('var %s', $variable)
                )
            ) {
                return \true;
            }
        }
        if (
            $compute &&
            \preg_match(self::SKIP_VARIABLES_IF_REGEXP_START, $trimmedScript, $matchesStart) > 0 &&
            \preg_match(self::SKIP_VARIABLES_IF_REGEXP_END, $trimmedScript, $matchesEnd) > 0
        ) {
            $potentialJsonValue = \trim(\substr($trimmedScript, \strlen($matchesStart[0]) - 1), ';');
            return \DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\Utils::isJson($potentialJsonValue) !== \false;
        }
        return \false;
    }
    /**
     * Setter.
     *
     * @param string $script
     * @codeCoverageIgnore
     */
    public function setScript($script) {
        $this->setChanged(\true);
        $this->script = $script;
    }
    /**
     * Getter.
     *
     * @codeCoverageIgnore
     */
    public function getScript() {
        return $this->script;
    }
    /**
     * Getter.
     *
     * @return ScriptInlineFinder
     * @codeCoverageIgnore
     */
    public function getFinder() {
        return parent::getFinder();
    }
}
