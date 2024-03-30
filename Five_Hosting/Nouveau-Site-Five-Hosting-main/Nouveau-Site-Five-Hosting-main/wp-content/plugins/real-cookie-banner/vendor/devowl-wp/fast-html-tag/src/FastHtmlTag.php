<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag;

use DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\AbstractFinder;
/**
 * Initialize a new parser.
 */
class FastHtmlTag {
    /**
     * Callbacks.
     *
     * @var callable[]
     */
    private $callbacks = [];
    /**
     * See `AbstractFinder`.
     *
     * @var AbstractFinder[]
     */
    private $finder = [];
    /**
     * C'tor.
     *
     * @codeCoverageIgnore
     */
    public function __construct() {
        // Silence is golden.
    }
    /**
     * Add a finder scheme. See `finder/` for available ones.
     *
     * @param AbstractFinder $finder
     */
    public function addFinder($finder) {
        $this->finder[] = $finder;
    }
    /**
     * Add a callable. The first parameter is the HTML string and should return HTML.
     *
     * @param callable $callback
     */
    public function addCallback($callback) {
        $this->callbacks[] = $callback;
    }
    /**
     * Allows to parse and modify any content. This could be e.g. a JSON string
     * (each value gets iterated and parsed if it is a HTML).
     *
     * @param mixed $mixed
     */
    public function modifyAny($mixed) {
        $json = \DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\Utils::isJson($mixed);
        // Avoid JSON primitives to be replaced
        if (\is_int($json) || $json === \true || \is_float($json)) {
            return $mixed;
        }
        if ($json !== \false) {
            // We have now a complete JSON array, let's walk it recursively and apply content blocker
            \array_walk_recursive($json, function (&$value) {
                if (\DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\Utils::isHtml($value)) {
                    $value = $this->modifyHtml($value);
                }
            });
            return \json_encode($json);
        } else {
            // Usual string
            return $this->modifyHtml($mixed);
        }
    }
    /**
     * Allow to parse and modify a given HTML string.
     *
     * @param string $html
     */
    public function modifyHtml($html) {
        foreach ($this->finder as $finder) {
            $html = $finder->replace($html);
        }
        foreach ($this->callbacks as $callback) {
            $html = $callback($html);
        }
        return $html;
    }
}
