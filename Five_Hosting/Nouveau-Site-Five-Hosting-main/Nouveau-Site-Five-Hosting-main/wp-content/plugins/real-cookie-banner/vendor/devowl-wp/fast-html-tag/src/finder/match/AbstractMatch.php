<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\match;

use DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\AbstractFinder;
/**
 * Abstract match defining a `AbstractFinder` match.
 */
abstract class AbstractMatch {
    private $finder;
    private $originalMatch;
    private $tag;
    private $attributes;
    private $changed = \false;
    private $beforeTag = '';
    private $afterTag = '';
    /**
     * C'tor.
     *
     * @param AbstractFinder $finder
     * @param string $originalMatch
     * @param string $tag
     * @param array $attributes
     */
    public function __construct($finder, $originalMatch, $tag, $attributes) {
        $this->finder = $finder;
        $this->originalMatch = $originalMatch;
        $this->tag = $tag;
        $this->attributes = $attributes ?? [];
    }
    /**
     * Render this match to valid HTML. Please pass your result to `encloseRendered`
     * and return that result.
     *
     * @return string
     */
    abstract public function render();
    /**
     * Use `beforeTag` and `afterTag`.
     *
     * @param string $html
     */
    protected function encloseRendered($html) {
        return \sprintf('%s%s%s', $this->getBeforeTag(), $html, $this->getAfterTag());
    }
    /**
     * Get attribute by key.
     *
     * @param string $key
     * @param mixed $default
     */
    public function getAttribute($key, $default = null) {
        return $this->attributes[$key] ?? $default;
    }
    /**
     * Check if the match has a given attribute.
     *
     * @param string $key
     */
    public function hasAttribute($key) {
        return isset($this->attributes[$key]);
    }
    /**
     * Calculate a unique key for this match.
     *
     * @param string[] $idKeys Consider ID keys as unique (ordered by priority)
     * @param string[][] $looseAttributes
     * @return string|null Can return `null` if we cannot calculate a unique key for this container
     */
    public function calculateUniqueKey($idKeys = ['id'], $looseAttributes = []) {
        $result = [];
        // Generate unique key by ID attribute
        foreach ($idKeys as $idKey) {
            if ($this->hasAttribute($idKey)) {
                $result[$idKey] = \trim($this->getAttribute($idKey));
                break;
            }
        }
        if (\count($result) === 0) {
            // Fallback to loose identification (all attributes)
            $looseAttributes['attributes'] = $this->getAttributes();
            if (\count($looseAttributes['attributes']) !== 0) {
                \ksort($looseAttributes['attributes']);
                $result = $looseAttributes;
            }
        }
        return \count($result) > 0 ? \md5($this->getTag() . '.' . \json_encode($result)) : null;
    }
    /**
     * Set attribute by key and value.
     *
     * @param string $key
     * @param mixed|null $value
     */
    public function setAttribute($key, $value) {
        $this->setChanged(\true);
        $attributes = &$this->attributes;
        if ($value === null) {
            if (isset($attributes[$key])) {
                unset($attributes[$key]);
            }
        } else {
            $attributes[$key] = $value;
        }
    }
    /**
     * Setter.
     *
     * @param array $attributes
     */
    public function setAttributes($attributes) {
        $this->setChanged(\true);
        $this->attributes = $attributes;
    }
    /**
     * Setter. Use this with caution! Due to the fact, this can break your HTML code,
     * if the finder does not hold the end tag!
     *
     * @param string $string
     */
    public function setTag($string) {
        $this->setChanged(\true);
        $this->tag = $string;
    }
    /**
     * Setter.
     *
     * @param string $string
     * @codeCoverageIgnore
     */
    public function setBeforeTag($string) {
        $this->beforeTag = $string;
    }
    /**
     * Setter.
     *
     * @param string $string
     * @codeCoverageIgnore
     */
    public function setAfterTag($string) {
        $this->afterTag = $string;
    }
    /**
     * Indicate that the match has a change. You need to mark this to `true` to apply changes to your HTML.
     *
     * @param boolean $status
     */
    public function setChanged($status) {
        $this->changed = $status;
    }
    /**
     * Getter.
     *
     * @codeCoverageIgnore
     */
    public function getFinder() {
        return $this->finder;
    }
    /**
     * Getter.
     *
     * @codeCoverageIgnore
     */
    public function getOriginalMatch() {
        return $this->originalMatch;
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
    public function getAttributes() {
        return $this->attributes;
    }
    /**
     * Getter.
     *
     * @codeCoverageIgnore
     */
    public function hasChanged() {
        return $this->changed;
    }
    /**
     * Getter.
     *
     * @codeCoverageIgnore
     */
    public function getBeforeTag() {
        return $this->beforeTag;
    }
    /**
     * Getter.
     *
     * @codeCoverageIgnore
     */
    public function getAfterTag() {
        return $this->afterTag;
    }
}
