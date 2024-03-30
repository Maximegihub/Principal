<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\plugins;

use DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\match\AbstractMatch;
use DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\match\TagAttributeMatch;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\AbstractPlugin;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\BlockedResult;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\matcher\AbstractMatcher;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Append a calculated unique key of the tag to the tag.
 */
class CalculateUniqueKeys extends \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\AbstractPlugin {
    /**
     * See `AbstractPlugin`. We need to use this hook so we have all original attributes available.
     *
     * @param BlockedResult $result
     * @param AbstractMatcher $matcher
     * @param AbstractMatch $match
     */
    public function checkResult($result, $matcher, $match) {
        if ($result->isBlocked()) {
            // Prepare ID keys ordered by priority
            $idKeys = [
                \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants::HTML_ATTRIBUTE_VISUAL_ID
            ];
            if (
                $match instanceof \DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\finder\match\TagAttributeMatch &&
                \filter_var($match->getLink(), \FILTER_VALIDATE_URL)
            ) {
                $idKeys[] = $match->getLinkAttribute();
            }
            $idKeys[] = 'id';
            $key = $match->calculateUniqueKey($idKeys, ['blockerId' => $result->getFirstBlocked()->getBlockerId()]);
            if ($key !== null) {
                $match->setAttribute(
                    \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants::HTML_ATTRIBUTE_VISUAL_ID,
                    $key
                );
            }
        }
        return $result;
    }
}
