<?php

namespace DevOwl\RealCookieBanner\view\customize\banner;

use DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\AbstractCustomizePanel;
use DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\CustomHTML;
use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\view\BannerCustomize;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Content decision options.
 */
class Decision {
    use UtilsProvider;
    const SECTION = \DevOwl\RealCookieBanner\view\BannerCustomize::PANEL_MAIN . '-decision';
    const CUSTOM_HTML_BUTTON_TYPE_DIFFERS_NOTICE = self::SECTION . '-custom-html-button-type-differs-notice';
    const CUSTOM_HTML_LEGAL_NOTICE_ALL = self::SECTION . '-custom-html-legal-notice-all';
    const CUSTOM_HTML_LEGAL_NOTICE_ESSENTIALS = self::SECTION . '-custom-html-legal-notice-essentials';
    const CUSTOM_HTML_LEGAL_NOTICE_INDIVIDUAL = self::SECTION . '-custom-html-legal-notice-individual';
    const SETTING = RCB_OPT_PREFIX . '-banner-decision';
    const SETTING_ACCEPT_ALL = self::SETTING . '-accept-all';
    const SETTING_ACCEPT_ESSENTIALS = self::SETTING . '-accept-essentials';
    const SETTING_ACCEPT_INDIVIDUAL = self::SETTING . '-accept-individual';
    const SETTING_GROUPS_FIRST_VIEW = self::SETTING . '-groups-first-view';
    const SETTING_SAVE_BUTTON = self::SETTING . '-save-button';
    const DEFAULT_ACCEPT_ALL = 'button';
    const DEFAULT_ACCEPT_ESSENTIALS = 'button';
    const DEFAULT_ACCEPT_INDIVIDUAL = 'link';
    const DEFAULT_GROUPS_FIRST_VIEW = \false;
    const DEFAULT_SAVE_BUTTON = 'always';
    /**
     * Return arguments for this section.
     */
    public function args() {
        $textButtonTypeDiffers = \sprintf(
            '<div class="notice notice-warning inline below-h2 notice-alt" style="margin: 10px 0 0 0"><p>%s</p></div>',
            __(
                'The options "Accept all" and "Continue without consent" should be of the same type. Therefore, both should be a button or a link.',
                RCB_TD
            )
        );
        $textLegalNotice = \sprintf(
            '<div class="notice notice-warning inline below-h2 notice-alt" style="margin: 10px 0 0 0"><p>%s</p></div>',
            __(
                'Please note that from a legal point of view you have to give your visitor this option. With the currently selected setting, you are taking a risk.',
                RCB_TD
            )
        );
        return [
            'name' => 'decision',
            'title' => __('Consent options', RCB_TD),
            'controls' => [
                self::CUSTOM_HTML_BUTTON_TYPE_DIFFERS_NOTICE => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\CustomHTML::class,
                    'name' => 'customHtmlDecisionButtonTypeDiffers',
                    'description' => $textButtonTypeDiffers
                ],
                self::SETTING_ACCEPT_ALL => [
                    'name' => 'acceptAll',
                    'label' => __('Accept all', RCB_TD),
                    'description' => \sprintf(
                        // translators:
                        __(
                            'According to the GDPR (%1$sEU 2016/679%2$s), section 32, you are not allowed to pre-select services in the form of pre-selected checkboxes for the visitor. However, the GDPR and ePrivacy Directive do not prohibit the use of a button to agree to all services, if there is also a button to agree only to the essential services or to make a user-defined selection.',
                            RCB_TD
                        ),
                        '<a href="https://eur-lex.europa.eu/eli/reg/2016/679/oj?locale=en" target="_blank">',
                        '</a>'
                    ),
                    'type' => 'select',
                    'choices' => [
                        'button' => __('Button', RCB_TD),
                        'link' => __('Link', RCB_TD),
                        'hide' => __('Hide', RCB_TD)
                    ],
                    'setting' => ['default' => self::DEFAULT_ACCEPT_ALL]
                ],
                self::CUSTOM_HTML_LEGAL_NOTICE_ALL => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\CustomHTML::class,
                    'name' => 'customHtmlDecisionLegalNoticeAll',
                    'description' => $textLegalNotice
                ],
                self::SETTING_ACCEPT_ESSENTIALS => [
                    'name' => 'acceptEssentials',
                    'label' => __('Continue without consent', RCB_TD),
                    'description' => __(
                        'The GDPR (EU 2016/679) and ePrivacy Directive (EU 2009/136/EC) defines that visitors must be able to easily reject cookies, whereby essential cookies can be set in any case. Therefore, the visitor should be given this option in a similar manner to the "Accept all" button/link.',
                        RCB_TD
                    ),
                    'type' => 'select',
                    'choices' => [
                        'button' => __('Button', RCB_TD),
                        'link' => __('Link', RCB_TD),
                        'hide' => __('Hide', RCB_TD)
                    ],
                    'setting' => ['default' => self::DEFAULT_ACCEPT_ESSENTIALS]
                ],
                self::CUSTOM_HTML_LEGAL_NOTICE_ESSENTIALS => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\CustomHTML::class,
                    'name' => 'customHtmlDecisionLegalNoticeEssentials',
                    'description' => $textLegalNotice
                ],
                self::SETTING_ACCEPT_INDIVIDUAL => [
                    'name' => 'acceptIndividual',
                    'label' => __('Individual privacy preferences', RCB_TD),
                    'description' => __(
                        'According to the GDPR (EU 2016/679) and the ePrivacy Directive (EU 2009/136/EC), the user must be free to choose which services to use and be informed about their purpose before giving consent. Therefore, the user must be given the opportunity to access the page with the individual privacy settings.',
                        RCB_TD
                    ),
                    'type' => 'select',
                    'choices' => [
                        'button' => __('Button', RCB_TD),
                        'link' => __('Link', RCB_TD),
                        'hide' => __('Hide', RCB_TD)
                    ],
                    'setting' => ['default' => self::DEFAULT_ACCEPT_INDIVIDUAL]
                ],
                self::CUSTOM_HTML_LEGAL_NOTICE_INDIVIDUAL => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\CustomHTML::class,
                    'name' => 'customHtmlDecisionLegalNoticeIndividual',
                    'description' => $textLegalNotice
                ],
                self::SETTING_GROUPS_FIRST_VIEW => [
                    'name' => 'groupsFirstView',
                    'label' => __('Custom choice in first view', RCB_TD),
                    'type' => 'rcbGroupsFirstView',
                    'setting' => [
                        'default' => self::DEFAULT_GROUPS_FIRST_VIEW,
                        'sanitize_callback' => [
                            \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\AbstractCustomizePanel::class,
                            'sanitize_checkbox'
                        ]
                    ]
                ],
                self::SETTING_SAVE_BUTTON => [
                    'name' => 'saveButton',
                    'label' => __('Save button', RCB_TD),
                    'type' => 'radio',
                    'choices' => [
                        'always' => __('Show save button always', RCB_TD),
                        'afterChange' => __('Show save button only after a change by the user', RCB_TD),
                        'afterChangeAll' => __('Text of "Accept all" changes when user changes selection', RCB_TD)
                    ],
                    'setting' => ['default' => self::DEFAULT_SAVE_BUTTON]
                ]
            ]
        ];
    }
}
