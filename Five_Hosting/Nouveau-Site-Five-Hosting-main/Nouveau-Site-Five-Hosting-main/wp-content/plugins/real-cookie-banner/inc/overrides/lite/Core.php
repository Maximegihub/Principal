<?php

namespace DevOwl\RealCookieBanner\lite;

use DevOwl\RealCookieBanner\Vendor\DevOwl\Freemium\CoreLite;
use DevOwl\RealCookieBanner\lite\rest\Service;
use DevOwl\RealCookieBanner\presets\PresetIdentifierMap;
use DevOwl\RealCookieBanner\presets\pro\ActiveCampaignSiteTrackingPreset;
use DevOwl\RealCookieBanner\presets\pro\AddThisPreset;
use DevOwl\RealCookieBanner\presets\pro\AddToAnyPreset;
use DevOwl\RealCookieBanner\presets\pro\AdInserterPreset;
use DevOwl\RealCookieBanner\presets\pro\AdobeTypekitPreset;
use DevOwl\RealCookieBanner\presets\pro\AmazonAssociatesWidgetPreset;
use DevOwl\RealCookieBanner\presets\pro\AnalytifyPreset;
use DevOwl\RealCookieBanner\presets\pro\AnchorFmPreset;
use DevOwl\RealCookieBanner\presets\pro\AppleMusicPreset;
use DevOwl\RealCookieBanner\presets\pro\AwinLinkImageAdsPreset;
use DevOwl\RealCookieBanner\presets\pro\AwinPublisherMasterTagPreset;
use DevOwl\RealCookieBanner\presets\pro\BingAdsPreset;
use DevOwl\RealCookieBanner\presets\pro\BingMapsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\ActiveCampaignFormPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\ActiveCampaignSiteTrackingPreset as BlockerActiveCampaignSiteTrackingPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\AddThisPreset as BlockerAddThisPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\AddToAnyPreset as BlockerAddToAnyPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\AdInserterPreset as BlockerAdInserterPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\AdobeTypekitPreset as BlockerAdobeTypekitPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\AnalytifyPreset as BlockerAnalytifyPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\AnchorFmPreset as BlockerAnchorFmPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\AppleMusicPreset as BlockerAppleMusicPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\AwinLinkImageAdsPreset as BlockerAwinLinkImageAdsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\BingMapsPreset as BlockerBingMapsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\BloomPreset as BlockerBloomPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\CalderaFormsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\CalendlyPreset as BlockerCalendlyPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\CleverReachRecaptchaPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\ContactForm7RecaptchaPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\ConvertKitPreset as BlockerConvertKitPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\CustomFacebookFeedPreset as BlockerCustomFacebookFeedPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\CustomTwitterFeedPreset as BlockerCustomTwitterFeedPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\DailyMotionPreset as BlockerDailyMotionPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\DiscordWidgetPreset as BlockerDiscordWidgetPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\ElementorFormsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\ExactMetricsPreset as BlockerExactMetricsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\FacebookForWooCommercePreset as BlockerFacebookForWooCommercePreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\FacebookLikePreset as BlockerFacebookLikePreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\FacebookPagePluginPreset as BlockerFacebookPagePluginPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\FacebookPixelPreset as BlockerFacebookPixelPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\FacebookPostPreset as BlockerFacebookPostPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\FacebookSharePreset as BlockerFacebookSharePreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\FeedsForYoutubePreset as BlockerFeedsForYoutubePreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\FlickrPreset as BlockerFlickrPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\FormidablePreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\FormMakerRecaptchaPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\GAGoogleAnalytics4Preset as BlockerGAGoogleAnalytics4Preset;
use DevOwl\RealCookieBanner\presets\pro\blocker\GAGoogleAnalyticsPreset as BlockerGAGoogleAnalyticsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\GetYourGuidePreset as BlockerGetYourGuidePreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\GiphyPreset as BlockerGiphyPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\GoogleAnalytics4Preset as BlockerGoogleAnalytics4Preset;
use DevOwl\RealCookieBanner\presets\pro\blocker\GoogleAnalyticsPreset as BlockerGoogleAnalyticsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\GoogleMapsPreset as BlockerGoogleMapsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\GoogleRecaptchaPreset as BlockerGoogleRecaptchaPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\GoogleTranslatePreset as BlockerGoogleTranslatePreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\GoogleTrendsPreset as BlockerGoogleTrendsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\HotjarPreset as BlockerHotjarPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\ImgurPreset as BlockerImgurPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\InstagramPostPreset as BlockerInstagramPostPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\IntercomChatPreset as BlockerIntercomChatPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\IssuuPreset as BlockerIssuuPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\LinkedInAdsPreset as BlockerLinkedInAdsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\LoomPreset as BlockerLoomPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\MailchimpForWooCommercePreset as BlockerMailchimpForWooCommercePreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\MailerLitePreset as BlockerMailerLitePreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\MailPoetPreset as BlockerMailPoetPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\MatomoIntegrationPluginPreset as BlockerMatomoIntegrationPluginPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\MatomoPluginPreset as BlockerMatomoPluginPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\MetricoolPreset as BlockerMetricoolPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\MicrosoftClarityPreset as BlockerMicrosoftClarityPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\MonsterInsightsPreset as BlockerMonsterInsightsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\MouseflowPreset as BlockerMouseflowPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\MyCruiseExcursionPreset as BlockerMyCruiseExcursionPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\MyFontsPreset as BlockerMyFontsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\NinjaFormsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\OpenStreetMapPreset as BlockerOpenStreetMapPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\PinterestPreset as BlockerPinterestPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\PinterestTagPreset as BlockerPinterestTagPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\PodigeePreset as BlockerPodigeePreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\PopupMakerPreset as BlockerPopupMakerPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\ProvenExpertWidgetPreset as BlockerProvenExpertWidgetPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\QuformRecaptchaPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\RankMathGAPreset as BlockerRankMathGAPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\RedditPreset as BlockerRedditPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\SendinbluePreset as BlockerSendinbluePreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\SmashBalloonSocialPhotoFeedPreset as BlockerSmashBalloonSocialPhotoFeedPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\SoundCloudPreset as BlockerSoundCloudPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\SpotifyPreset as BlockerSpotifyPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\TaboolaPreset as BlockerTaboolaPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\TawkToChatPreset as BlockerTawkToChatPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\ThriveLeadsPreset as BlockerThriveLeadsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\TidioChatPreset as BlockerTidioChatPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\TikTokPreset as BlockerTikTokPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\TwitterTweetPreset as BlockerTwitterTweetPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\TypeformPreset as BlockerTypeformPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\UserlikePreset as BlockerUserlikePreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\VGWortPreset as BlockerVGWortPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\VimeoPreset as BlockerVimeoPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\WooCommerceGoogleAnalytics4Preset as BlockerWooCommerceGoogleAnalytics4Preset;
use DevOwl\RealCookieBanner\presets\pro\blocker\WooCommerceGoogleAnalyticsPreset as BlockerWooCommerceGoogleAnalyticsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\WPFormsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\XingEventsPreset as BlockerXingEventsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\YandexMetricaPreset as BlockerYandexMetricaPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\ZendeskChatPreset as BlockerZendeskChatPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\ZohoBookingsPreset as BlockerZohoBookingsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\ZohoFormsPreset as BlockerZohoFormsPreset;
use DevOwl\RealCookieBanner\presets\pro\BloomPreset;
use DevOwl\RealCookieBanner\presets\pro\CalendlyPreset;
use DevOwl\RealCookieBanner\presets\pro\CleanTalkSpamProtectPreset;
use DevOwl\RealCookieBanner\presets\pro\CloudflarePreset;
use DevOwl\RealCookieBanner\presets\pro\ConvertKitPreset;
use DevOwl\RealCookieBanner\presets\pro\CustomFacebookFeedPreset;
use DevOwl\RealCookieBanner\presets\pro\CustomTwitterFeedPreset;
use DevOwl\RealCookieBanner\presets\pro\DailyMotionPreset;
use DevOwl\RealCookieBanner\presets\pro\DiscordWidgetPreset;
use DevOwl\RealCookieBanner\presets\pro\ExactMetricsPreset;
use DevOwl\RealCookieBanner\presets\pro\EzoicEssentialPreset;
use DevOwl\RealCookieBanner\presets\pro\EzoicMarketingPreset;
use DevOwl\RealCookieBanner\presets\pro\EzoicPreferencesPreset;
use DevOwl\RealCookieBanner\presets\pro\EzoicStatisticPreset;
use DevOwl\RealCookieBanner\presets\pro\FacebookForWooCommercePreset;
use DevOwl\RealCookieBanner\presets\pro\FacebookLikePreset;
use DevOwl\RealCookieBanner\presets\pro\FacebookPagePluginPreset;
use DevOwl\RealCookieBanner\presets\pro\FacebookPixelPreset;
use DevOwl\RealCookieBanner\presets\pro\FacebookPostPreset;
use DevOwl\RealCookieBanner\presets\pro\FacebookSharePreset;
use DevOwl\RealCookieBanner\presets\pro\FeedsForYoutubePreset;
use DevOwl\RealCookieBanner\presets\pro\FlickrPreset;
use DevOwl\RealCookieBanner\presets\pro\FoundEePreset;
use DevOwl\RealCookieBanner\presets\pro\FreshchatPreset;
use DevOwl\RealCookieBanner\presets\pro\GAGoogleAnalytics4Preset;
use DevOwl\RealCookieBanner\presets\pro\GAGoogleAnalyticsPreset;
use DevOwl\RealCookieBanner\presets\pro\GetYourGuidePreset;
use DevOwl\RealCookieBanner\presets\pro\GiphyPreset;
use DevOwl\RealCookieBanner\presets\pro\GoogleAds;
use DevOwl\RealCookieBanner\presets\pro\GoogleAdSensePreset;
use DevOwl\RealCookieBanner\presets\pro\GoogleAnalytics4Preset;
use DevOwl\RealCookieBanner\presets\pro\GoogleAnalyticsPreset;
use DevOwl\RealCookieBanner\presets\pro\GoogleMapsPreset;
use DevOwl\RealCookieBanner\presets\pro\GoogleRecaptchaPreset;
use DevOwl\RealCookieBanner\presets\pro\GoogleTranslatePreset;
use DevOwl\RealCookieBanner\presets\pro\GoogleTrendsPreset;
use DevOwl\RealCookieBanner\presets\pro\GtmPreset;
use DevOwl\RealCookieBanner\presets\pro\HCaptchaPreset;
use DevOwl\RealCookieBanner\presets\pro\HelpCrunchChatPreset;
use DevOwl\RealCookieBanner\presets\pro\HelpScoutChatPreset;
use DevOwl\RealCookieBanner\presets\pro\HotjarPreset;
use DevOwl\RealCookieBanner\presets\pro\ImgurPreset;
use DevOwl\RealCookieBanner\presets\pro\InstagramPostPreset;
use DevOwl\RealCookieBanner\presets\pro\IntercomChatPreset;
use DevOwl\RealCookieBanner\presets\pro\IssuuPreset;
use DevOwl\RealCookieBanner\presets\pro\KlarnaCheckoutWooCommercePreset;
use DevOwl\RealCookieBanner\presets\pro\LinkedInAdsPreset;
use DevOwl\RealCookieBanner\presets\pro\LoomPreset;
use DevOwl\RealCookieBanner\presets\pro\LuckyOrangePreset;
use DevOwl\RealCookieBanner\presets\pro\MailchimpForWooCommercePreset;
use DevOwl\RealCookieBanner\presets\pro\MailerLitePreset;
use DevOwl\RealCookieBanner\presets\pro\MailPoetPreset;
use DevOwl\RealCookieBanner\presets\pro\MatomoIntegrationPluginPreset;
use DevOwl\RealCookieBanner\presets\pro\MatomoPluginPreset;
use DevOwl\RealCookieBanner\presets\pro\MatomoPreset;
use DevOwl\RealCookieBanner\presets\pro\MetricoolPreset;
use DevOwl\RealCookieBanner\presets\pro\MicrosoftClarityPreset;
use DevOwl\RealCookieBanner\presets\pro\MonsterInsightsPreset;
use DevOwl\RealCookieBanner\presets\pro\MouseflowPreset;
use DevOwl\RealCookieBanner\presets\pro\MtmPreset;
use DevOwl\RealCookieBanner\presets\pro\MyCruiseExcursionPreset;
use DevOwl\RealCookieBanner\presets\pro\MyFontsPreset;
use DevOwl\RealCookieBanner\presets\pro\OpenStreetMapPreset;
use DevOwl\RealCookieBanner\presets\pro\PaddleComPreset;
use DevOwl\RealCookieBanner\presets\pro\PinterestPreset;
use DevOwl\RealCookieBanner\presets\pro\PinterestTagPreset;
use DevOwl\RealCookieBanner\presets\pro\PodigeePreset;
use DevOwl\RealCookieBanner\presets\pro\PolyLangPreset;
use DevOwl\RealCookieBanner\presets\pro\PopupMakerPreset;
use DevOwl\RealCookieBanner\presets\pro\ProvenExpertWidgetPreset;
use DevOwl\RealCookieBanner\presets\pro\QuformPreset;
use DevOwl\RealCookieBanner\presets\pro\RankMathGAPreset;
use DevOwl\RealCookieBanner\presets\pro\ReamazeChatPreset;
use DevOwl\RealCookieBanner\presets\pro\RedditPreset;
use DevOwl\RealCookieBanner\presets\pro\SendinbluePreset;
use DevOwl\RealCookieBanner\presets\pro\SmashBalloonSocialPhotoFeedPreset;
use DevOwl\RealCookieBanner\presets\pro\SoundCloudPreset;
use DevOwl\RealCookieBanner\presets\pro\SpotifyPreset;
use DevOwl\RealCookieBanner\presets\pro\StripePreset;
use DevOwl\RealCookieBanner\presets\pro\TaboolaPreset;
use DevOwl\RealCookieBanner\presets\pro\TawkToChatPreset;
use DevOwl\RealCookieBanner\presets\pro\ThriveLeadsPreset;
use DevOwl\RealCookieBanner\presets\pro\TidioChatPreset;
use DevOwl\RealCookieBanner\presets\pro\TikTokPixelPreset;
use DevOwl\RealCookieBanner\presets\pro\TikTokPreset;
use DevOwl\RealCookieBanner\presets\pro\TranslatePressPreset;
use DevOwl\RealCookieBanner\presets\pro\TwitterTweetPreset;
use DevOwl\RealCookieBanner\presets\pro\TypeformPreset;
use DevOwl\RealCookieBanner\presets\pro\UltimateMemberPreset;
use DevOwl\RealCookieBanner\presets\pro\UserlikePreset;
use DevOwl\RealCookieBanner\presets\pro\VGWortPreset;
use DevOwl\RealCookieBanner\presets\pro\VimeoPreset;
use DevOwl\RealCookieBanner\presets\pro\WooCommerceGatewayStripePreset;
use DevOwl\RealCookieBanner\presets\pro\WooCommerceGoogleAnalytics4Preset;
use DevOwl\RealCookieBanner\presets\pro\WooCommerceGoogleAnalyticsPreset;
use DevOwl\RealCookieBanner\presets\pro\WooCommercePreset;
use DevOwl\RealCookieBanner\presets\pro\WordfencePreset;
use DevOwl\RealCookieBanner\presets\pro\WPMLPreset;
use DevOwl\RealCookieBanner\presets\pro\XingEventsPreset;
use DevOwl\RealCookieBanner\presets\pro\YandexMetricaPreset;
use DevOwl\RealCookieBanner\presets\pro\ZendeskChatPreset;
use DevOwl\RealCookieBanner\presets\pro\ZohoBookingsPreset;
use DevOwl\RealCookieBanner\presets\pro\ZohoFormsPreset;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
trait Core {
    use CoreLite;
    // Documented in IOverrideCore
    public function overrideConstruct() {
        add_filter('RCB/Presets/Cookies', [$this, 'createProCookiePresets']);
        add_filter('RCB/Presets/Blocker', [$this, 'createProBlockerPresets']);
    }
    // Documented in IOverrideCore
    public function overrideRegisterSettings() {
        // Silence is golden.
    }
    // Documented in IOverrideCore
    public function overrideInit() {
        add_action('rest_api_init', [\DevOwl\RealCookieBanner\lite\rest\Service::instance(), 'rest_api_init']);
    }
    /**
     * Create PRO-specific cookie presets.
     *
     * @param array $result
     */
    public function createProCookiePresets($result) {
        return \array_merge($result, [
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::CLOUDFLARE =>
                \DevOwl\RealCookieBanner\presets\pro\CloudflarePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::POLYLANG =>
                \DevOwl\RealCookieBanner\presets\pro\PolyLangPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::WPML =>
                \DevOwl\RealCookieBanner\presets\pro\WPMLPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::WOOCOMMERCE =>
                \DevOwl\RealCookieBanner\presets\pro\WooCommercePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ULTIMATE_MEMBER =>
                \DevOwl\RealCookieBanner\presets\pro\UltimateMemberPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GTM =>
                \DevOwl\RealCookieBanner\presets\pro\GtmPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MTM =>
                \DevOwl\RealCookieBanner\presets\pro\MtmPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_MAPS =>
                \DevOwl\RealCookieBanner\presets\pro\GoogleMapsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FACEBOOK_POST =>
                \DevOwl\RealCookieBanner\presets\pro\FacebookPostPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::INSTAGRAM_POST =>
                \DevOwl\RealCookieBanner\presets\pro\InstagramPostPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::TWITTER_TWEET =>
                \DevOwl\RealCookieBanner\presets\pro\TwitterTweetPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_RECAPTCHA =>
                \DevOwl\RealCookieBanner\presets\pro\GoogleRecaptchaPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_ANALYTICS =>
                \DevOwl\RealCookieBanner\presets\pro\GoogleAnalyticsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MATOMO =>
                \DevOwl\RealCookieBanner\presets\pro\MatomoPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_AD_SENSE =>
                \DevOwl\RealCookieBanner\presets\pro\GoogleAdSensePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_ADS =>
                \DevOwl\RealCookieBanner\presets\pro\GoogleAds::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FACEBOOK_PIXEL =>
                \DevOwl\RealCookieBanner\presets\pro\FacebookPixelPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FACEBOOK_LIKE =>
                \DevOwl\RealCookieBanner\presets\pro\FacebookLikePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FACEBOOK_SHARE =>
                \DevOwl\RealCookieBanner\presets\pro\FacebookSharePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::HOTJAR =>
                \DevOwl\RealCookieBanner\presets\pro\HotjarPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::AMAZON_ASSOCIATES_WIDGET =>
                \DevOwl\RealCookieBanner\presets\pro\AmazonAssociatesWidgetPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::INTERCOM_CHAT =>
                \DevOwl\RealCookieBanner\presets\pro\IntercomChatPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ZENDESK_CHAT =>
                \DevOwl\RealCookieBanner\presets\pro\ZendeskChatPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FRESHCHAT =>
                \DevOwl\RealCookieBanner\presets\pro\FreshchatPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::HELP_CRUNCH_CHAT =>
                \DevOwl\RealCookieBanner\presets\pro\HelpCrunchChatPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::HELP_SCOUT_CHAT =>
                \DevOwl\RealCookieBanner\presets\pro\HelpScoutChatPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::TIDIO_CHAT =>
                \DevOwl\RealCookieBanner\presets\pro\TidioChatPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::TAWK_TO_CHAT =>
                \DevOwl\RealCookieBanner\presets\pro\TawkToChatPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::REAMAZE_CHAT =>
                \DevOwl\RealCookieBanner\presets\pro\ReamazeChatPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::PINTEREST =>
                \DevOwl\RealCookieBanner\presets\pro\PinterestPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::IMGUR =>
                \DevOwl\RealCookieBanner\presets\pro\ImgurPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_TRANSLATE =>
                \DevOwl\RealCookieBanner\presets\pro\GoogleTranslatePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ADOBE_TYPEKIT =>
                \DevOwl\RealCookieBanner\presets\pro\AdobeTypekitPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FACEBOOK_PAGE_PLUGIN =>
                \DevOwl\RealCookieBanner\presets\pro\FacebookPagePluginPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FLICKR =>
                \DevOwl\RealCookieBanner\presets\pro\FlickrPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::VG_WORT =>
                \DevOwl\RealCookieBanner\presets\pro\VGWortPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::PADDLE_COM =>
                \DevOwl\RealCookieBanner\presets\pro\PaddleComPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_ANALYTICS_4 =>
                \DevOwl\RealCookieBanner\presets\pro\GoogleAnalytics4Preset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MICROSOFT_CLARITY =>
                \DevOwl\RealCookieBanner\presets\pro\MicrosoftClarityPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_TRENDS =>
                \DevOwl\RealCookieBanner\presets\pro\GoogleTrendsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ZOHO_BOOKINGS =>
                \DevOwl\RealCookieBanner\presets\pro\ZohoBookingsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ZOHO_FORMS =>
                \DevOwl\RealCookieBanner\presets\pro\ZohoFormsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ADD_TO_ANY =>
                \DevOwl\RealCookieBanner\presets\pro\AddToAnyPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::APPLE_MUSIC =>
                \DevOwl\RealCookieBanner\presets\pro\AppleMusicPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ANCHOR_FM =>
                \DevOwl\RealCookieBanner\presets\pro\AnchorFmPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::SPOTIFY =>
                \DevOwl\RealCookieBanner\presets\pro\SpotifyPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::REDDIT =>
                \DevOwl\RealCookieBanner\presets\pro\RedditPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::TIKTOK =>
                \DevOwl\RealCookieBanner\presets\pro\TikTokPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::BING_MAPS =>
                \DevOwl\RealCookieBanner\presets\pro\BingMapsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ADD_THIS =>
                \DevOwl\RealCookieBanner\presets\pro\AddThisPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ACTIVE_CAMPAIGN_SITE_TRACKING =>
                \DevOwl\RealCookieBanner\presets\pro\ActiveCampaignSiteTrackingPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::DISCORD_WIDGET =>
                \DevOwl\RealCookieBanner\presets\pro\DiscordWidgetPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MY_FONTS =>
                \DevOwl\RealCookieBanner\presets\pro\MyFontsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::PROVEN_EXPERT_WIDGET =>
                \DevOwl\RealCookieBanner\presets\pro\ProvenExpertWidgetPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::USERLIKE =>
                \DevOwl\RealCookieBanner\presets\pro\UserlikePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MOUSEFLOW =>
                \DevOwl\RealCookieBanner\presets\pro\MouseflowPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MONSTERINSIGHTS =>
                \DevOwl\RealCookieBanner\presets\pro\MonsterInsightsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GA_GOOGLE_ANALYTICS =>
                \DevOwl\RealCookieBanner\presets\pro\GAGoogleAnalyticsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GA_GOOGLE_ANALYTICS_4 =>
                \DevOwl\RealCookieBanner\presets\pro\GAGoogleAnalytics4Preset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::EXACT_METRICS =>
                \DevOwl\RealCookieBanner\presets\pro\ExactMetricsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ANALYTIFY =>
                \DevOwl\RealCookieBanner\presets\pro\AnalytifyPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::WOOCOMMERCE_GOOGLE_ANALYTICS =>
                \DevOwl\RealCookieBanner\presets\pro\WooCommerceGoogleAnalyticsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::WOOCOMMERCE_GOOGLE_ANALYTICS_4 =>
                \DevOwl\RealCookieBanner\presets\pro\WooCommerceGoogleAnalytics4Preset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FACEBOOK_FOR_WOOCOMMERCE =>
                \DevOwl\RealCookieBanner\presets\pro\FacebookForWooCommercePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MATOMO_PLUGIN =>
                \DevOwl\RealCookieBanner\presets\pro\MatomoPluginPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::STRIPE =>
                \DevOwl\RealCookieBanner\presets\pro\StripePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::WOOCOMMERCE_GATEWAY_STRIPE =>
                \DevOwl\RealCookieBanner\presets\pro\WooCommerceGatewayStripePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MAILCHIMP_FOR_WOOCOMMERCE =>
                \DevOwl\RealCookieBanner\presets\pro\MailchimpForWooCommercePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::LUCKY_ORANGE =>
                \DevOwl\RealCookieBanner\presets\pro\LuckyOrangePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::CUSTOM_FACEBOOK_FEED =>
                \DevOwl\RealCookieBanner\presets\pro\CustomFacebookFeedPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::CUSTOM_TWITTER_FEED =>
                \DevOwl\RealCookieBanner\presets\pro\CustomTwitterFeedPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FEEDS_FOR_YOUTUBE =>
                \DevOwl\RealCookieBanner\presets\pro\FeedsForYoutubePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MAILERLITE =>
                \DevOwl\RealCookieBanner\presets\pro\MailerLitePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::CLEANTALK_SPAM_PROTECT =>
                \DevOwl\RealCookieBanner\presets\pro\CleanTalkSpamProtectPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::WORDFENCE =>
                \DevOwl\RealCookieBanner\presets\pro\WordfencePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::TRANSLATEPRESS =>
                \DevOwl\RealCookieBanner\presets\pro\TranslatePressPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ISSUU =>
                \DevOwl\RealCookieBanner\presets\pro\IssuuPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::KLARNA_CHECKOUT_WOOCOMMERCE =>
                \DevOwl\RealCookieBanner\presets\pro\KlarnaCheckoutWooCommercePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::QUFORM =>
                \DevOwl\RealCookieBanner\presets\pro\QuformPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::PINTEREST_TAG =>
                \DevOwl\RealCookieBanner\presets\pro\PinterestTagPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::HCAPTCHA =>
                \DevOwl\RealCookieBanner\presets\pro\HCaptchaPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::BING_ADS =>
                \DevOwl\RealCookieBanner\presets\pro\BingAdsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::YANDEX_METRICA =>
                \DevOwl\RealCookieBanner\presets\pro\YandexMetricaPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FOUND_EE =>
                \DevOwl\RealCookieBanner\presets\pro\FoundEePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::BLOOM =>
                \DevOwl\RealCookieBanner\presets\pro\BloomPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::TYPEFORM =>
                \DevOwl\RealCookieBanner\presets\pro\TypeformPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::RANKMATH_GA =>
                \DevOwl\RealCookieBanner\presets\pro\RankMathGAPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::THRIVE_LEADS =>
                \DevOwl\RealCookieBanner\presets\pro\ThriveLeadsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::POPUP_MAKER =>
                \DevOwl\RealCookieBanner\presets\pro\PopupMakerPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::METRICOOL =>
                \DevOwl\RealCookieBanner\presets\pro\MetricoolPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::EZOIC_ESSENTIAL =>
                \DevOwl\RealCookieBanner\presets\pro\EzoicEssentialPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::EZOIC_PREFERENCES =>
                \DevOwl\RealCookieBanner\presets\pro\EzoicPreferencesPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::EZOIC_STATISTIC =>
                \DevOwl\RealCookieBanner\presets\pro\EzoicStatisticPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::EZOIC_MARKETING =>
                \DevOwl\RealCookieBanner\presets\pro\EzoicMarketingPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::SOUNDCLOUD =>
                \DevOwl\RealCookieBanner\presets\pro\SoundCloudPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::VIMEO =>
                \DevOwl\RealCookieBanner\presets\pro\VimeoPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::XING_EVENTS =>
                \DevOwl\RealCookieBanner\presets\pro\XingEventsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::SENDINBLUE =>
                \DevOwl\RealCookieBanner\presets\pro\SendinbluePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::AWIN_LINK_AND_IMAGE_ADS =>
                \DevOwl\RealCookieBanner\presets\pro\AwinLinkImageAdsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::AWIN_PUBLISHER_MASTERTAG =>
                \DevOwl\RealCookieBanner\presets\pro\AwinPublisherMasterTagPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::CONVERTKIT =>
                \DevOwl\RealCookieBanner\presets\pro\ConvertKitPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MATOMO_INTEGRATION_PLUGIN =>
                \DevOwl\RealCookieBanner\presets\pro\MatomoIntegrationPluginPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GETYOURGUIDE =>
                \DevOwl\RealCookieBanner\presets\pro\GetYourGuidePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::CALENDLY =>
                \DevOwl\RealCookieBanner\presets\pro\CalendlyPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MY_CRUISE_EXCURSION =>
                \DevOwl\RealCookieBanner\presets\pro\MyCruiseExcursionPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MAILPOET =>
                \DevOwl\RealCookieBanner\presets\pro\MailPoetPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::SMASH_BALLOON_SOCIAL_PHOTO_FEED =>
                \DevOwl\RealCookieBanner\presets\pro\SmashBalloonSocialPhotoFeedPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::PODIGEE =>
                \DevOwl\RealCookieBanner\presets\pro\PodigeePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::AD_INSERTER =>
                \DevOwl\RealCookieBanner\presets\pro\AdInserterPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::DAILYMOTION =>
                \DevOwl\RealCookieBanner\presets\pro\DailyMotionPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GIPHY =>
                \DevOwl\RealCookieBanner\presets\pro\GiphyPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::LINKEDIN_ADS =>
                \DevOwl\RealCookieBanner\presets\pro\LinkedInAdsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::LOOM =>
                \DevOwl\RealCookieBanner\presets\pro\LoomPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::OPEN_STREET_MAP =>
                \DevOwl\RealCookieBanner\presets\pro\OpenStreetMapPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::TIKTOK_PIXEL =>
                \DevOwl\RealCookieBanner\presets\pro\TikTokPixelPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::TABOOLA =>
                \DevOwl\RealCookieBanner\presets\pro\TaboolaPreset::class
        ]);
    }
    /**
     * Create PRO-specific blocker presets.
     *
     * @param array $result
     */
    public function createProBlockerPresets($result) {
        return \array_merge($result, [
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::PINTEREST =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\PinterestPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::IMGUR =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\ImgurPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_TRANSLATE =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\GoogleTranslatePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_RECAPTCHA =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\GoogleRecaptchaPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ADOBE_TYPEKIT =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\AdobeTypekitPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_MAPS =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\GoogleMapsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::TWITTER_TWEET =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\TwitterTweetPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FLICKR =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\FlickrPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::INSTAGRAM_POST =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\InstagramPostPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FACEBOOK_PAGE_PLUGIN =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\FacebookPagePluginPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FACEBOOK_SHARE =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\FacebookSharePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FACEBOOK_LIKE =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\FacebookLikePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FACEBOOK_POST =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\FacebookPostPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::CONTACT_FORM_7_RECAPTCHA =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\ContactForm7RecaptchaPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FORM_MAKER_RECAPTCHA =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\FormMakerRecaptchaPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::CALDERA_FORMS_RECAPTCHA =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\CalderaFormsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::NINJA_FORMS_RECAPTCHA =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\NinjaFormsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::WPFORMS_RECAPTCHA =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\WPFormsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FORMIDABLE_RECAPTCHA =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\FormidablePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::VG_WORT =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\VGWortPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_TRENDS =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\GoogleTrendsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ZOHO_BOOKINGS =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\ZohoBookingsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ZOHO_FORMS =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\ZohoFormsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ADD_TO_ANY =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\AddToAnyPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::APPLE_MUSIC =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\AppleMusicPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ANCHOR_FM =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\AnchorFmPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::SPOTIFY =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\SpotifyPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::REDDIT =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\RedditPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::TIKTOK =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\TikTokPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::BING_MAPS =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\BingMapsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ADD_THIS =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\AddThisPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ACTIVE_CAMPAIGN_RECAPTCHA =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\ActiveCampaignFormPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::DISCORD_WIDGET =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\DiscordWidgetPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FACEBOOK_PIXEL =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\FacebookPixelPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MY_FONTS =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\MyFontsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::PROVEN_EXPERT_WIDGET =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\ProvenExpertWidgetPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_ANALYTICS =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\GoogleAnalyticsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MONSTERINSIGHTS =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\MonsterInsightsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GA_GOOGLE_ANALYTICS =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\GAGoogleAnalyticsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::EXACT_METRICS =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\ExactMetricsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ANALYTIFY =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\AnalytifyPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::WOOCOMMERCE_GOOGLE_ANALYTICS =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\WooCommerceGoogleAnalyticsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FACEBOOK_FOR_WOOCOMMERCE =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\FacebookForWooCommercePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MATOMO_PLUGIN =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\MatomoPluginPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MAILCHIMP_FOR_WOOCOMMERCE =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\MailchimpForWooCommercePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::CLEVERREACH_RECAPTCHA =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\CleverReachRecaptchaPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::CUSTOM_FACEBOOK_FEED =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\CustomFacebookFeedPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::CUSTOM_TWITTER_FEED =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\CustomTwitterFeedPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FEEDS_FOR_YOUTUBE =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\FeedsForYoutubePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MAILERLITE =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\MailerLitePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::QUFORM =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\QuformRecaptchaPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ISSUU =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\IssuuPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::PINTEREST_TAG =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\PinterestTagPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::YANDEX_METRICA =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\YandexMetricaPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::BLOOM =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\BloomPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::TYPEFORM =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\TypeformPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::RANKMATH_GA =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\RankMathGAPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::THRIVE_LEADS =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\ThriveLeadsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::POPUP_MAKER =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\PopupMakerPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::METRICOOL =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\MetricoolPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::SOUNDCLOUD =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\SoundCloudPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::VIMEO =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\VimeoPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::XING_EVENTS =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\XingEventsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::SENDINBLUE =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\SendinbluePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::AWIN_LINK_AND_IMAGE_ADS =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\AwinLinkImageAdsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::CONVERTKIT =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\ConvertKitPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MATOMO_INTEGRATION_PLUGIN =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\MatomoIntegrationPluginPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GETYOURGUIDE =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\GetYourGuidePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::CALENDLY =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\CalendlyPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MY_CRUISE_EXCURSION =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\MyCruiseExcursionPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MAILPOET =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\MailPoetPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::SMASH_BALLOON_SOCIAL_PHOTO_FEED =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\SmashBalloonSocialPhotoFeedPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ACTIVE_CAMPAIGN_SITE_TRACKING =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\ActiveCampaignSiteTrackingPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::HOTJAR =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\HotjarPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::INTERCOM_CHAT =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\IntercomChatPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MICROSOFT_CLARITY =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\MicrosoftClarityPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MOUSEFLOW =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\MouseflowPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::TAWK_TO_CHAT =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\TawkToChatPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::TIDIO_CHAT =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\TidioChatPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::USERLIKE =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\UserlikePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ZENDESK_CHAT =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\ZendeskChatPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_ANALYTICS_4 =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\GoogleAnalytics4Preset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GA_GOOGLE_ANALYTICS_4 =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\GAGoogleAnalytics4Preset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::WOOCOMMERCE_GOOGLE_ANALYTICS_4 =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\WooCommerceGoogleAnalytics4Preset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::PODIGEE =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\PodigeePreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::AD_INSERTER =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\AdInserterPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::DAILYMOTION =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\DailyMotionPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GIPHY =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\GiphyPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::LINKEDIN_ADS =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\LinkedInAdsPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::LOOM =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\LoomPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::OPEN_STREET_MAP =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\OpenStreetMapPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::TABOOLA =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\TaboolaPreset::class,
            \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ELEMENTOR_FORMS_RECAPTCHA =>
                \DevOwl\RealCookieBanner\presets\pro\blocker\ElementorFormsPreset::class
        ]);
    }
}
