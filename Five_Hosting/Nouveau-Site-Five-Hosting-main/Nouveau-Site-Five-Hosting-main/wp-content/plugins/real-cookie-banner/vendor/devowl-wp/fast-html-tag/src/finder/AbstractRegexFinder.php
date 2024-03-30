<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder;

use DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\match\AbstractMatch;
use DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\Utils;
/**
 * Find by regular expression.
 */
abstract class AbstractRegexFinder extends \DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\AbstractFinder {
    /**
     * Get regular expression.
     *
     * @param string $html
     */
    abstract public function getRegularExpression();
    /**
     * A regexp match got found. Let's create a `AbstractMatch` instance.
     *
     * @param array $m
     * @return AbstractMatch|false Returns `false` if no match got found and we cannot process it
     */
    abstract protected function createMatch($m);
    /**
     * See `AbstractFinder`.
     *
     * @param string $html
     */
    public function replace($html) {
        return \DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\Utils::preg_replace_callback_recursive(
            $this->getRegularExpression(),
            function ($m) {
                $match = $this->createMatch($m);
                $this->applyCallbacks($match);
                return $match === \false ? $m[0] : $match->render();
            },
            $html
        );
    }
}
