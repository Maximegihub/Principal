<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder;

use DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\match\SelectorSyntaxMatch;
use DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\Utils;
/**
 * Find HTML tags by a selector syntax like `div[id="my-id"]`.
 */
class SelectorSyntaxFinder extends \DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\TagAttributeFinder {
    private $expression;
    private $tag;
    private $attribute;
    private $comparator;
    private $value;
    const COMPARATOR_EXISTS = 'EXISTS';
    const COMPARATOR_EQUAL = '=';
    const COMPARATOR_CONTAINS = '*=';
    const COMPARATOR_STARTS_WITH = '^=';
    const COMPARATOR_ENDS_WITH = '$=';
    const ALLOWED_COMPARATORS = [
        self::COMPARATOR_EQUAL,
        self::COMPARATOR_CONTAINS,
        self::COMPARATOR_STARTS_WITH,
        self::COMPARATOR_ENDS_WITH
    ];
    /**
     * See class description.
     *
     * Available matches:
     *      $match[0] => Full string
     *      $match[1] => Tag
     *      $match[2] => Attribute
     *      $match[3] => Comparator (can be empty)
     *      $match[4] => Value (can be empty)
     *
     * @see https://regex101.com/r/vlbn3Y/2/
     */
    const EXPRESSION_REGEXP = '/^([A-Za-z_-]+)\\[([A-Za-z_-]+)(?:(%s)"([^"]+)")?]$/m';
    /**
     * C'tor.
     *
     * @param string $expression
     * @param string $tag
     * @param string $attribute
     * @param string $comparator
     * @param string $value
     * @codeCoverageIgnore
     */
    public function __construct($expression, $tag, $attribute, $comparator, $value) {
        parent::__construct([$tag], [$attribute]);
        $this->expression = $expression;
        $this->tag = $tag;
        $this->attribute = $attribute;
        $this->comparator = $comparator;
        $this->value = $value;
    }
    /**
     * See `AbstractRegexFinder`.
     *
     * @param array $m
     */
    public function createMatch($m) {
        list($beforeLinkAttribute, $tag, $linkAttribute, $link, $afterLink, $attributes) = self::prepareMatch($m);
        if ($this->matchesComparator($link)) {
            return new \DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\match\SelectorSyntaxMatch(
                $this,
                $m[0],
                $tag,
                $attributes,
                $beforeLinkAttribute,
                $afterLink,
                $linkAttribute,
                $link
            );
        }
        return \false;
    }
    /**
     * Checks if the current attribute and value matches the comparator.
     *
     * @param string $value
     */
    public function matchesComparator($value) {
        switch ($this->comparator) {
            case self::COMPARATOR_EXISTS:
                return $value !== null;
            case \DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\SelectorSyntaxFinder::COMPARATOR_EQUAL:
                return $value === $this->getValue();
            case \DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\SelectorSyntaxFinder::COMPARATOR_CONTAINS:
                return \strpos($value, $this->getValue()) !== \false;
            case \DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\SelectorSyntaxFinder::COMPARATOR_STARTS_WITH:
                return \DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\Utils::startsWith($value, $this->getValue());
            case \DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\SelectorSyntaxFinder::COMPARATOR_ENDS_WITH:
                return \DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\Utils::endsWith($value, $this->value);
            default:
                return \false;
        }
    }
    /**
     * Getter.
     *
     * @codeCoverageIgnore
     */
    public function getExpression() {
        return $this->expression;
    }
    /**
     * Getter.
     *
     * @codeCoverageIgnore
     */
    public function getTag() {
        return $this->tag;
    }
    /**
     * Getter.
     *
     * @codeCoverageIgnore
     */
    public function getAttribute() {
        return $this->attribute;
    }
    /**
     * Getter.
     *
     * @codeCoverageIgnore
     */
    public function getComparator() {
        return $this->comparator;
    }
    /**
     * Getter.
     *
     * @codeCoverageIgnore
     */
    public function getValue() {
        return $this->value;
    }
    /**
     * Create an instance from an expression like `div[id="my-id"]`.
     *
     * @param string $expression
     * @return SelectorSyntaxFinder|false Returns `false` if the expression is invalid
     */
    public static function fromExpression($expression) {
        $regexp = \sprintf(
            \DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\SelectorSyntaxFinder::EXPRESSION_REGEXP,
            \join('|', \array_map('preg_quote', self::ALLOWED_COMPARATORS))
        );
        \preg_match($regexp, $expression, $matches);
        if (!empty($matches)) {
            return new \DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\SelectorSyntaxFinder(
                $matches[0],
                $matches[1],
                $matches[2],
                $matches[3] ?? self::COMPARATOR_EXISTS,
                $matches[4] ?? null
            );
        }
        return \false;
    }
}
