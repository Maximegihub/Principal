<?php

namespace DevOwl\RealCookieBanner\presets\pro\blocker;

use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\presets\pro\MailchimpForWooCommercePreset as PresetsMailchimpForWooCommercePreset;
use DevOwl\RealCookieBanner\presets\AbstractBlockerPreset;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Mailchimp for WooCommerce blocker preset.
 */
class MailchimpForWooCommercePreset extends \DevOwl\RealCookieBanner\presets\AbstractBlockerPreset {
    const IDENTIFIER = \DevOwl\RealCookieBanner\presets\pro\MailchimpForWooCommercePreset::IDENTIFIER;
    const VERSION = 1;
    // Documented in AbstractPreset
    public function common() {
        $name = 'Mailchimp for WooCommerce';
        return [
            'id' => self::IDENTIFIER,
            'version' => self::VERSION,
            'name' => $name,
            'attributes' => [
                'hosts' => [
                    '*wp-content/plugins/mailchimp-for-woocommerce/*',
                    '*chimpstatic.com*',
                    'div[class*="mailchimp-newsletter"]',
                    'div[id="mailchimp-gdpr-fields"]',
                    'p[class*="mailchimp-newsletter"]',
                    'script[id="mailchimp-woocommerce-js-extra"]'
                ]
            ],
            'logoFile' => \DevOwl\RealCookieBanner\Core::getInstance()->getBaseAssetsUrl('logos/mailchimp.png'),
            'needs' => \DevOwl\RealCookieBanner\presets\pro\MailchimpForWooCommercePreset::needs()
        ];
    }
}
