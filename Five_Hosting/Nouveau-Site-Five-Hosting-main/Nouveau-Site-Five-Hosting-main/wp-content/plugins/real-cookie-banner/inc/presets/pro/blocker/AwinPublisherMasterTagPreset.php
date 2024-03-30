<?php

namespace DevOwl\RealCookieBanner\presets\pro\blocker;

use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\presets\AbstractBlockerPreset;
use DevOwl\RealCookieBanner\presets\pro\AwinPublisherMasterTagPreset as ProAwinPublisherMasterTagPreset;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Awin (Publisher MasterTag) blocker preset.
 */
class AwinPublisherMasterTagPreset extends \DevOwl\RealCookieBanner\presets\AbstractBlockerPreset {
    const IDENTIFIER = \DevOwl\RealCookieBanner\presets\pro\AwinPublisherMasterTagPreset::IDENTIFIER;
    const VERSION = 1;
    // Documented in AbstractPreset
    public function common() {
        $name = 'Awin';
        return [
            'id' => self::IDENTIFIER,
            'version' => self::VERSION,
            'name' => $name,
            'description' => 'Publisher MasterTag',
            'hidden' => \true,
            'attributes' => [
                'hosts' => ['*dwin2.com/pub.*.min.js*'],
                'cookies' => [\DevOwl\RealCookieBanner\presets\pro\AwinPublisherMasterTagPreset::IDENTIFIER]
            ],
            'logoFile' => \DevOwl\RealCookieBanner\Core::getInstance()->getBaseAssetsUrl('logos/awin.png')
        ];
    }
}
