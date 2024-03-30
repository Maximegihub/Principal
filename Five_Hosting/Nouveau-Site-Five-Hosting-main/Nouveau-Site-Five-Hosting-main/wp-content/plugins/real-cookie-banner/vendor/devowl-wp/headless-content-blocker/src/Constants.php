<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker;

/**
 * Common constants for the headless content blocker.
 */
abstract class Constants {
    /**
     * When transforming a blocked attribute, it gets prefixed and suffixed.
     */
    const HTML_ATTRIBUTE_CAPTURE_PREFIX = 'consent-original';
    const HTML_ATTRIBUTE_CAPTURE_CLICK_PREFIX = 'consent-click-original';
    const HTML_ATTRIBUTE_CAPTURE_SUFFIX = '_';
    // Some plugins are using something like replace(/src=/) (like WP Rocket)
    /**
     * The ID of the `Blockable` for which we need consent for.
     */
    const HTML_ATTRIBUTE_BLOCKER_ID = 'consent-id';
    /**
     * Usually, this is `cookie`, but you could also implement different types like
     * `tcf-vendor` or similar. So, in frontend you can implement different "checking
     * for consent"-mechanism.
     */
    const HTML_ATTRIBUTE_BY = 'consent-by';
    /**
     * Comma separated list of IDs needed for `consent-by`.
     */
    const HTML_ATTRIBUTE_COOKIE_IDS = 'consent-required';
    /**
     * A tag got blocked, e. g. `iframe`. We can now determine the "Visual Parent". The visual parent is the
     * closest parent where the content blocker should be placed to. The visual parent can be configured as follow:
     *
     * - `false` = Use original element
     * - `true` = Use parent element
     * - `number` = Go upwards x element (parentElement)
     * - `string` = Go upwards until parentElement matches a selector
     * - `string` = Starting with `children:` you can `querySelector` down to create the visual parent for a children
     */
    const HTML_ATTRIBUTE_VISUAL_PARENT = 'consent-visual-use-parent';
    /**
     * This constant is only used in frontend and is added afterwards a unblock transaction
     * got completed.
     */
    const HTML_ATTRIBUTE_UNBLOCKED_TRANSACTION_COMPLETE = 'consent-transaction-complete';
    /**
     * Caching plugins compatibility e.g. WP Rocket. Adds this `type` to your
     * `script` and `style` so it gets not combined to a combine-file for example.
     */
    const HTML_ATTRIBUTE_TYPE_FOR = ['script', 'style'];
    const HTML_ATTRIBUTE_TYPE_NAME = 'type';
    const HTML_ATTRIBUTE_TYPE_VALUE = 'application/consent';
    const HTML_ATTRIBUTE_TYPE_JS = 'application/javascript';
    const HTML_ATTRIBUTE_TYPE_CSS = 'text/css';
    /**
     * Blocked styles are put into an own attribute instead of the `script` body
     * to avoid that caching plugins like WP Rocket will bundle them in a minified file.
     */
    const HTML_ATTRIBUTE_INLINE_STYLE = 'consent-inline-style';
    const URL_QUERY_ARG_ORIGINAL_URL_IN_STYLE = 'consent-original-url';
    const HTML_ATTRIBUTE_INLINE = 'consent-inline';
    // For scripts
    /**
     * HTML tags with this attribute activated are ignored in the complete content blocker.
     */
    const HTML_ATTRIBUTE_CONSENT_SKIP_BLOCKER = 'consent-skip-blocker';
    const HTML_ATTRIBUTE_CONSENT_SKIP_BLOCKER_VALUE = '1';
    const HTML_POTENTIAL_SKIP_TAGS = ['script', 'link', 'style'];
    /**
     * See `CalculateUniqueKeys`.
     */
    const HTML_ATTRIBUTE_VISUAL_ID = 'consent-visual-id';
}
