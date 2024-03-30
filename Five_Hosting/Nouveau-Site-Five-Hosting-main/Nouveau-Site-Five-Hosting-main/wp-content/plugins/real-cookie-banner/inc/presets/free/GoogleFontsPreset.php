<?php

namespace DevOwl\RealCookieBanner\presets\free;

use DevOwl\RealCookieBanner\comp\language\Hooks;
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\presets\AbstractCookiePreset;
use DevOwl\RealCookieBanner\presets\PresetIdentifierMap;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Google Fonts cookie preset.
 */
class GoogleFontsPreset extends \DevOwl\RealCookieBanner\presets\AbstractCookiePreset {
    const IDENTIFIER = \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_FONTS;
    const VERSION = 2;
    /**
     * Web Font Loader compatibility.
     *
     * @see https://app.clickup.com/t/aq01tu
     */
    const WEB_FONT_LOADER_ON_PAGE_LOAD = '<script>
(function () {
  // Web Font Loader compatibility (https://github.com/typekit/webfontloader)
  var modules = {
    typekit: "https://use.typekit.net",
    google: "https://fonts.googleapis.com/"
  };

  var load = function (config) {
    setTimeout(function () {
      var a = window.consentApi;

      // Only when blocker is active
      if (a) {
        // Iterate all modules and handle in a single `WebFont.load`
        Object.keys(modules).forEach(function (module) {
          var newConfigWithoutOtherModules = JSON.parse(
            JSON.stringify(config)
          );
          Object.keys(modules).forEach(function (toRemove) {
            if (toRemove !== module) {
              delete newConfigWithoutOtherModules[toRemove];
            }
          });

          if (newConfigWithoutOtherModules[module]) {
            a.unblock(modules[module]).then(function () {
              var originalLoad = window.WebFont.load;
              if (originalLoad !== load) {
                originalLoad(newConfigWithoutOtherModules);
              }
            });
          }
        });
      }
    }, 0);
  };

  if (!window.WebFont) {
    window.WebFont = {
      load: load
    };
  }
})();
</script>';
    // Documented in AbstractPreset
    public function common() {
        $name = 'Google Fonts';
        return [
            'id' => self::IDENTIFIER,
            'version' => self::VERSION,
            'name' => $name,
            'logoFile' => \DevOwl\RealCookieBanner\Core::getInstance()->getBaseAssetsUrl('logos/google-fonts.png'),
            'attributes' => [
                'name' => $name,
                'group' => __('Functional', \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED),
                'purpose' => __(
                    'Google Fonts is a service that downloads fonts that are not installed on the client device of the user and embeds them into the website. No cookies in the technical sense are set on the client of the user, but technical and personal data such as the IP address will be transmitted from the client to the server of the service provider to make the use of the service possible.',
                    \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED
                ),
                'provider' => 'Google Ireland Limited',
                'providerPrivacyPolicy' => 'https://policies.google.com/privacy',
                'noTechnicalDefinitions' => \true,
                'technicalHandlingNotice' => __(
                    'An opt-in script is not required, as this service is probably already integrated via e.g. your theme. In addition to this service, please create a content blocker that automatically blocks the integration of Google Fonts (from e.g. your theme) before you have the consent of your users.',
                    \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED
                ),
                'codeOnPageLoad' => self::WEB_FONT_LOADER_ON_PAGE_LOAD,
                'ePrivacyUSA' => \true
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
