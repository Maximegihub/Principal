<?php

namespace DevOwl\RealCookieBanner\presets\free;

use DevOwl\RealCookieBanner\comp\language\Hooks;
use DevOwl\RealCookieBanner\presets\AbstractCookiePreset;
use DevOwl\RealCookieBanner\presets\PresetIdentifierMap;
use DevOwl\RealCookieBanner\settings\General;
use DevOwl\RealCookieBanner\Utils;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * WordPress Comments cookie preset.
 */
class WordPressCommentsPreset extends \DevOwl\RealCookieBanner\presets\AbstractCookiePreset {
    const IDENTIFIER = \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::WORDPRESS_COMMENTS;
    const VERSION = 2;
    // Documented in AbstractPreset
    public function common() {
        $name = __('WordPress Comments', RCB_TD);
        $cookieHost = \DevOwl\RealCookieBanner\Utils::host(\DevOwl\RealCookieBanner\Utils::HOST_TYPE_MAIN);
        return [
            'id' => self::IDENTIFIER,
            'version' => self::VERSION,
            'name' => $name,
            'logoFile' => admin_url('images/wordpress-logo.svg'),
            'attributes' => [
                'name' => __('Comments', \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED),
                'group' => __('Functional', \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED),
                'purpose' => __(
                    'WordPress as a content management system offers the possibility to write comments under blog posts and similar content. The cookie stores the name, e-mail address and website of a commentator to display it again if the commentator wants to write another comment on this website.',
                    \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED
                ),
                'provider' => get_bloginfo('name'),
                'providerPrivacyPolicy' => \DevOwl\RealCookieBanner\settings\General::getInstance()->getPrivacyPolicyUrl(
                    ''
                ),
                'technicalDefinitions' => [
                    [
                        'type' => 'http',
                        'name' => 'comment_author_*',
                        'host' => $cookieHost,
                        'duration' => 1,
                        'durationUnit' => 'y',
                        'sessionDuration' => \false
                    ],
                    [
                        'type' => 'http',
                        'name' => 'comment_author_email_*',
                        'host' => $cookieHost,
                        'duration' => 1,
                        'durationUnit' => 'y',
                        'sessionDuration' => \false
                    ],
                    [
                        'type' => 'http',
                        'name' => 'comment_author_url_*',
                        'host' => $cookieHost,
                        'duration' => 1,
                        'durationUnit' => 'y',
                        'sessionDuration' => \false
                    ]
                ],
                'technicalHandlingNotice' => __(
                    'Please note that if this service is enabled, the "Save my name, email, and website in this browser for the next time I comment." checkbox in the comment form will disappear. Real Cookie Banner handles the consent to set the cookies as part of the overall cookie consent. The commentary system uses the Gravatar service to display avatars of commentators. You must also create a service for Gravatar as well.',
                    RCB_TD
                ),
                'codeOptIn' => '<script>
    var checkboxId = "wp-comment-cookies-consent";
    var checkbox = document.querySelector(\'[name="\' + checkboxId + \'"]\');
    var label = document.querySelector(\'[for="\' + checkboxId + \'"]\') || (checkbox && checkbox.parentElement);

    if (label && checkbox) {
        checkbox.checked = true;
        checkbox.style.display = "none";
        label.style.display = "none";
    }
</script>',
                'codeOptOutDelete' => \false
            ]
        ];
    }
    // Documented in AbstractPreset
    public function managerNone() {
        return \false;
    }
    // Documented in AbstractPreset
    public function managerGtm() {
        return \false;
    }
    // Documented in AbstractPreset
    public function managerMtm() {
        return \false;
    }
}
