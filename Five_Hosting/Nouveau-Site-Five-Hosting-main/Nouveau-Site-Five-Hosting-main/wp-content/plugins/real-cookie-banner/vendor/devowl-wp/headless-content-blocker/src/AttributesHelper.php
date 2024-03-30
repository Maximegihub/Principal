<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker;

/**
 * Helper functionality for HTML attributes in association with `Constants`.
 */
class AttributesHelper {
    /**
     * Check if a given set of HTML attributes already contains the "blocked"-attribute
     * so we can skip duplicate blockages.
     *
     * @param string[] $attributes
     */
    public static function isAlreadyBlocked($attributes) {
        return isset(
            $attributes[
                \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants::HTML_ATTRIBUTE_BLOCKER_ID
            ]
        ) ||
            isset(
                $attributes[
                    \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants::HTML_ATTRIBUTE_INLINE_STYLE
                ]
            );
    }
    /**
     * Transform an attribute to `consent-original-%s_` attribute.
     *
     * @param string $attribute
     * @param boolean $useClickEvent Uses `consent-click-original` instead of `consent-original`
     */
    public static function transformAttribute($attribute, $useClickEvent = \false) {
        return \sprintf(
            '%s-%s-%s',
            $useClickEvent
                ? \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants::HTML_ATTRIBUTE_CAPTURE_CLICK_PREFIX
                : \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants::HTML_ATTRIBUTE_CAPTURE_PREFIX,
            $attribute,
            \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants::HTML_ATTRIBUTE_CAPTURE_SUFFIX
        );
    }
    /**
     * Check if given HTML attributes contain a skipper.
     *
     * @param string[] $attributes
     */
    public static function isSkipped($attributes) {
        return isset(
            $attributes[
                \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants
                    ::HTML_ATTRIBUTE_CONSENT_SKIP_BLOCKER
            ]
        ) &&
            $attributes[
                \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants
                    ::HTML_ATTRIBUTE_CONSENT_SKIP_BLOCKER
            ] ===
                \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants::HTML_ATTRIBUTE_CONSENT_SKIP_BLOCKER_VALUE;
    }
    /**
     * Transform a set of given HTML tags to be skipped for the complete content blocker.
     *
     * @param string $html
     * @param string $additionalTags
     */
    public static function skipHtmlTagsInContentBlocker($html, $additionalTags = '') {
        return \preg_replace(
            \sprintf(
                '/^(<(%s))/m',
                \join(
                    '|',
                    \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants::HTML_POTENTIAL_SKIP_TAGS
                )
            ),
            \sprintf(
                '$1 %s="%s"%s',
                \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants::HTML_ATTRIBUTE_CONSENT_SKIP_BLOCKER,
                \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants::HTML_ATTRIBUTE_CONSENT_SKIP_BLOCKER_VALUE,
                empty($additionalTags) ? '' : ' ' . $additionalTags
            ),
            $html
        );
    }
    /**
     * Check if a given string has blocked CSS rules.
     *
     * @param string $document
     */
    public static function hasCssDocumentConsentRules($document) {
        return \strpos(
            $document,
            \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants::URL_QUERY_ARG_ORIGINAL_URL_IN_STYLE
        ) !== \false;
    }
}
