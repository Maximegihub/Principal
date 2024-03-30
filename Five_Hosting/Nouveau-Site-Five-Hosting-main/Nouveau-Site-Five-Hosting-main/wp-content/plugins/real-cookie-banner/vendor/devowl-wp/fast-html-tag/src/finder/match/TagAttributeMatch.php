<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\match;

use DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\TagAttributeFinder;
use DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\Utils;
/**
 * Match defining a `TagAttributeFinder` match.
 */
class TagAttributeMatch extends \DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\match\AbstractMatch {
    private $beforeLinkAttribute;
    private $afterLink;
    private $linkAttribute;
    private $link;
    /**
     * C'tor.
     *
     * @param TagAttributeFinder $finder
     * @param string $originalMatch
     * @param string $tag
     * @param array $attributes
     * @param string $beforeLinkAttribute
     * @param string $afterLink
     * @param string $linkAttribute
     * @param string $link
     */
    public function __construct(
        $finder,
        $originalMatch,
        $tag,
        $attributes,
        $beforeLinkAttribute,
        $afterLink,
        $linkAttribute,
        $link
    ) {
        parent::__construct($finder, $originalMatch, $tag, $attributes);
        $this->beforeLinkAttribute = $beforeLinkAttribute;
        $this->afterLink = $afterLink;
        $this->linkAttribute = $linkAttribute;
        $this->link = $link;
    }
    // See `AbstractRegexFinder`.
    public function render() {
        $attributes = $this->getAttributes();
        return $this->encloseRendered(
            $this->hasChanged()
                ? \sprintf(
                    '%1$s%2$s%3$s',
                    $this->getBeforeLinkAttribute(),
                    \count($attributes) > 0
                        ? ' ' . \DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\Utils::htmlAttributes($attributes)
                        : '',
                    $this->getAfterLink()
                )
                : $this->getOriginalMatch()
        );
    }
    /**
     * Getter.
     *
     * @codeCoverageIgnore
     */
    public function getBeforeLinkAttribute() {
        return $this->beforeLinkAttribute;
    }
    /**
     * Getter.
     *
     * @codeCoverageIgnore
     */
    public function getAfterLink() {
        return $this->afterLink;
    }
    /**
     * Getter.
     *
     * @codeCoverageIgnore
     */
    public function getLinkAttribute() {
        return $this->linkAttribute;
    }
    /**
     * Getter.
     *
     * @codeCoverageIgnore
     */
    public function getLink() {
        return $this->link;
    }
    /**
     * Getter.
     *
     * @return TagAttributeFinder
     * @codeCoverageIgnore
     */
    public function getFinder() {
        return parent::getFinder();
    }
}
