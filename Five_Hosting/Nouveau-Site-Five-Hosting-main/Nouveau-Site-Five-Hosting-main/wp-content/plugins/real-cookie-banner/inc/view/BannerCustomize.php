<?php

namespace DevOwl\RealCookieBanner\view;

use DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\AbstractCustomizePanel;
use DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\LanguageDependingOption;
use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\view\customize\banner\BasicLayout;
use DevOwl\RealCookieBanner\view\customize\banner\BodyDesign;
use DevOwl\RealCookieBanner\view\customize\banner\CustomCss;
use DevOwl\RealCookieBanner\view\customize\banner\Decision;
use DevOwl\RealCookieBanner\view\customize\banner\Design;
use DevOwl\RealCookieBanner\view\customize\banner\FooterDesign;
use DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign;
use DevOwl\RealCookieBanner\view\customize\banner\individual\Group;
use DevOwl\RealCookieBanner\view\customize\banner\individual\Layout;
use DevOwl\RealCookieBanner\view\customize\banner\Legal;
use DevOwl\RealCookieBanner\view\customize\banner\Texts;
use DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton;
use DevOwl\RealCookieBanner\view\customize\banner\individual\Texts as IndividualTexts;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Customize cookie box in customize. Conditional UI is implemented in `others/conditionalBanner.tsx`.
 */
class BannerCustomize extends \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\AbstractCustomizePanel {
    use UtilsProvider;
    const NEEDED_CAPABILITY = \DevOwl\RealCookieBanner\Core::MANAGE_MIN_CAPABILITY;
    const PANEL_MAIN = 'real-cookie-banner-banner';
    const TRANSLATE_SECTIONS = ['texts', 'individualTexts', 'legal'];
    /**
     * C'tor.
     */
    public function __construct() {
        parent::__construct(self::PANEL_MAIN, 'banner');
    }
    // Documented in AbstractCustomizePanel
    public function enableOptionsAutoload() {
        parent::enableOptionsAutoload();
        $comp = \DevOwl\RealCookieBanner\Core::getInstance()->getCompLanguage();
        $adminDefaultLegalTexts = \DevOwl\RealCookieBanner\view\customize\banner\Legal::getDefaultTexts();
        $adminDefaultTextsBanner = \DevOwl\RealCookieBanner\view\customize\banner\Texts::getDefaultButtonTexts();
        $adminDefaultTextsBannerIndividual = \DevOwl\RealCookieBanner\view\customize\banner\individual\Texts::getDefaultButtonTexts();
        new \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\LanguageDependingOption(
            $comp,
            \DevOwl\RealCookieBanner\view\customize\banner\Legal::SETTING_IMPRINT_LABEL,
            $adminDefaultLegalTexts['imprint']
        );
        new \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\LanguageDependingOption(
            $comp,
            \DevOwl\RealCookieBanner\view\customize\banner\Legal::SETTING_IMPRINT_EXTERNAL_URL,
            '',
            \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\LanguageDependingOption::DEFAULT_USE_NON_EMPTY_FROM_OTHER_LANGUAGES
        );
        new \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\LanguageDependingOption(
            $comp,
            \DevOwl\RealCookieBanner\view\customize\banner\Legal::SETTING_PRIVACY_POLICY_LABEL,
            $adminDefaultLegalTexts['privacyPolicy']
        );
        new \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\LanguageDependingOption(
            $comp,
            \DevOwl\RealCookieBanner\view\customize\banner\Legal::SETTING_PRIVACY_POLICY_EXTERNAL_URL,
            '',
            \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\LanguageDependingOption::DEFAULT_USE_NON_EMPTY_FROM_OTHER_LANGUAGES
        );
        new \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\LanguageDependingOption(
            $comp,
            \DevOwl\RealCookieBanner\view\customize\banner\Texts::SETTING_HEADLINE,
            $adminDefaultTextsBanner['headline']
        );
        new \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\LanguageDependingOption(
            $comp,
            \DevOwl\RealCookieBanner\view\customize\banner\Texts::SETTING_DESCRIPTION,
            $adminDefaultTextsBanner['description']
        );
        new \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\LanguageDependingOption(
            $comp,
            \DevOwl\RealCookieBanner\view\customize\banner\Texts::SETTING_ACCEPT_ALL,
            $adminDefaultTextsBanner['acceptAll']
        );
        new \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\LanguageDependingOption(
            $comp,
            \DevOwl\RealCookieBanner\view\customize\banner\Texts::SETTING_ACCEPT_ESSENTIALS,
            $adminDefaultTextsBanner['acceptEssentials']
        );
        new \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\LanguageDependingOption(
            $comp,
            \DevOwl\RealCookieBanner\view\customize\banner\Texts::SETTING_ACCEPT_INDIVIDUAL,
            $adminDefaultTextsBanner['acceptIndividual']
        );
        new \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\LanguageDependingOption(
            $comp,
            \DevOwl\RealCookieBanner\view\customize\banner\Texts::SETTING_EPRIVACY_USA,
            $adminDefaultTextsBanner['ePrivacyUSA']
        );
        new \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\LanguageDependingOption(
            $comp,
            \DevOwl\RealCookieBanner\view\customize\banner\Texts::SETTING_AGE_NOTICE,
            $adminDefaultTextsBanner['ageNoticeBanner']
        );
        new \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\LanguageDependingOption(
            $comp,
            \DevOwl\RealCookieBanner\view\customize\banner\Texts::SETTING_AGE_NOTICE_BLOCKER,
            $adminDefaultTextsBanner['ageNoticeBlocker']
        );
        new \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\LanguageDependingOption(
            $comp,
            \DevOwl\RealCookieBanner\view\customize\banner\Texts::SETTING_CONSENT_FORWARDING,
            $adminDefaultTextsBanner['consentForwardingExternalHosts']
        );
        new \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\LanguageDependingOption(
            $comp,
            \DevOwl\RealCookieBanner\view\customize\banner\Texts::SETTING_BLOCKER_HEADLINE,
            $adminDefaultTextsBanner['blockerHeadline']
        );
        new \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\LanguageDependingOption(
            $comp,
            \DevOwl\RealCookieBanner\view\customize\banner\Texts::SETTING_BLOCKER_LINK_SHOW_MISSING,
            $adminDefaultTextsBanner['blockerLinkShowMissing']
        );
        new \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\LanguageDependingOption(
            $comp,
            \DevOwl\RealCookieBanner\view\customize\banner\Texts::SETTING_BLOCKER_LOAD_BUTTON,
            $adminDefaultTextsBanner['blockerLoadButton']
        );
        new \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\LanguageDependingOption(
            $comp,
            \DevOwl\RealCookieBanner\view\customize\banner\Texts::SETTING_BLOCKER_ACCEPT_INFO,
            $adminDefaultTextsBanner['blockerAcceptInfo']
        );
        new \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\LanguageDependingOption(
            $comp,
            \DevOwl\RealCookieBanner\view\customize\banner\individual\Texts::SETTING_HEADLINE,
            $adminDefaultTextsBannerIndividual['headline']
        );
        new \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\LanguageDependingOption(
            $comp,
            \DevOwl\RealCookieBanner\view\customize\banner\individual\Texts::SETTING_DESCRIPTION,
            $adminDefaultTextsBannerIndividual['description']
        );
        new \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\LanguageDependingOption(
            $comp,
            \DevOwl\RealCookieBanner\view\customize\banner\individual\Texts::SETTING_SAVE,
            $adminDefaultTextsBannerIndividual['save']
        );
        new \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\LanguageDependingOption(
            $comp,
            \DevOwl\RealCookieBanner\view\customize\banner\individual\Texts::SETTING_SHOW_MORE,
            $adminDefaultTextsBannerIndividual['showMore']
        );
        new \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\LanguageDependingOption(
            $comp,
            \DevOwl\RealCookieBanner\view\customize\banner\individual\Texts::SETTING_HIDE_MORE,
            $adminDefaultTextsBannerIndividual['hideMore']
        );
    }
    // Documented in AbstractCustomizePanel
    public function localizeValues($skipControlClasses = []) {
        return $this->translateArray(parent::localizeValues($skipControlClasses), 'customizeValuesBanner');
    }
    /**
     * Expand localize values by e.g. header logo dimensions. This is not needed for the
     * customize nor export, but for the frontend to fit Web Vitals.
     *
     * @param array $values Result of `localizeValues`
     */
    public function expandLocalizeValues(&$values) {
        $headerDesign = &$values['customizeValuesBanner']['headerDesign'];
        $logoMaxHeight = $headerDesign['logoMaxHeight'];
        foreach (['logo', 'logoRetina'] as $logoKey) {
            if (!empty($headerDesign[$logoKey])) {
                $logoUrl = $headerDesign[$logoKey];
                $file_ext = \strtolower(\pathinfo($logoUrl, \PATHINFO_EXTENSION));
                $attachment_id = attachment_url_to_postid($logoUrl);
                $image = wp_get_attachment_image_src($attachment_id, 'full');
                if ($image !== \false && $file_ext !== 'svg') {
                    list(, $width, $height) = $image;
                    if ($height > 0) {
                        // avoid "Division by zero"
                        $dimensionKey = $logoKey . 'FitDim';
                        $headerDesign[$dimensionKey] = [($logoMaxHeight / $height) * $width, $logoMaxHeight];
                    }
                }
            }
        }
    }
    // Documented in AbstractCustomizePanel
    public function localizeDefaultValues($skipControlClasses = []) {
        return $this->translateArray(parent::localizeDefaultValues($skipControlClasses), 'customizeDefaultsBanner');
    }
    /**
     * Translate the banner array with the help of `translateArray`.
     *
     * @param array $customizeValues
     * @param string $mapKey Can be `customizeDefaults` or `customizeValuesBanner`
     */
    protected function translateArray($customizeValues, $mapKey) {
        $compLanguage = \DevOwl\RealCookieBanner\Core::getInstance()->getCompLanguage();
        foreach (self::TRANSLATE_SECTIONS as $key) {
            $customizeValues[$mapKey][$key] = $compLanguage->translateArray($customizeValues[$mapKey][$key]);
        }
        return $customizeValues;
    }
    // Documented in AbstractCustomizePanel
    protected function getPanelArgs() {
        return ['title' => __('Cookie Banner', RCB_TD), 'description' => __('Design your cookie banner.', RCB_TD)];
    }
    // Documented in AbstractCustomizePanel
    public function resolveSections() {
        return [
            \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SECTION => (new \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout())->args(),
            \DevOwl\RealCookieBanner\view\customize\banner\Decision::SECTION => (new \DevOwl\RealCookieBanner\view\customize\banner\Decision())->args(),
            \DevOwl\RealCookieBanner\view\customize\banner\Legal::SECTION => (new \DevOwl\RealCookieBanner\view\customize\banner\Legal())->args(),
            \DevOwl\RealCookieBanner\view\customize\banner\Design::SECTION => (new \DevOwl\RealCookieBanner\view\customize\banner\Design())->args(),
            \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SECTION => (new \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign())->args(),
            \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SECTION => (new \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign())->args(),
            \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SECTION => (new \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign())->args(),
            \DevOwl\RealCookieBanner\view\customize\banner\Texts::SECTION => (new \DevOwl\RealCookieBanner\view\customize\banner\Texts())->args(),
            \DevOwl\RealCookieBanner\view\customize\banner\individual\Layout::SECTION => (new \DevOwl\RealCookieBanner\view\customize\banner\individual\Layout())->args(),
            \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SECTION => (new \DevOwl\RealCookieBanner\view\customize\banner\individual\Group())->args(),
            \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SECTION => (new \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton())->args(),
            \DevOwl\RealCookieBanner\view\customize\banner\individual\Texts::SECTION => (new \DevOwl\RealCookieBanner\view\customize\banner\individual\Texts())->args(),
            \DevOwl\RealCookieBanner\view\customize\banner\CustomCss::SECTION => (new \DevOwl\RealCookieBanner\view\customize\banner\CustomCss())->args()
        ];
    }
    // Documented in AbstractCustomizePanel
    protected function sectionDefaults() {
        return ['capability' => self::NEEDED_CAPABILITY];
    }
    // Documented in AbstractCustomizePanel
    protected function settingDefaults() {
        return ['type' => 'option', 'transport' => 'postMessage'];
    }
    /**
     * New instance.
     *
     * @codeCoverageIgnore
     */
    public static function instance() {
        return new \DevOwl\RealCookieBanner\view\BannerCustomize();
    }
}
