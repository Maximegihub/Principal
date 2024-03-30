<?php

namespace DevOwl\RealCookieBanner\scanner;

// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\AbstractBlockable;
use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\settings\Blocker;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Describe a blockable item by a content blocker preset.
 */
class PresetBlockable extends \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\AbstractBlockable {
    use UtilsProvider;
    private $identifier;
    private $originalHosts;
    private $extended;
    /**
     * An instance of ourself with only the must have expressions.
     *
     * @var PresetBlockable[]|null
     */
    private $mustHosts;
    /**
     * C'tor.
     *
     * @param string $identifier
     * @param string[] $hosts
     * @param string $extended The parent extended preset identifier
     * @param string[] $mustHosts A list of hosts which need to be available otherwise they are not saved as scan result
     * @codeCoverageIgnore
     */
    public function __construct($identifier, $hosts, $extended = null, $mustHosts = []) {
        $this->identifier = $identifier;
        $this->originalHosts = $hosts;
        $this->extended = $extended;
        if (\count($mustHosts) > 0) {
            foreach ($mustHosts as $mustHostIdentifier => $mustHostsStringArray) {
                $this->mustHosts[$mustHostIdentifier] = new \DevOwl\RealCookieBanner\scanner\PresetBlockable(
                    $mustHostIdentifier,
                    $mustHostsStringArray
                );
            }
        }
        $this->appendFromStringArray($hosts);
    }
    // Documented in AbstractBlockable
    public function getBlockerId() {
        // This is only used for scanning purposes!
        return null;
    }
    // Documented in AbstractBlockable
    public function getRequiredIds() {
        return [];
    }
    // Documented in AbstractBlockable
    public function getCriteria() {
        // The scanner does currently only support usual cookie presets
        return \DevOwl\RealCookieBanner\settings\Blocker::CRITERIA_COOKIES;
    }
    /**
     * Getter.
     *
     * @codeCoverageIgnore
     */
    public function getIdentifier() {
        return $this->identifier;
    }
    /**
     * Getter.
     *
     * @codeCoverageIgnore
     */
    public function getOriginalHosts() {
        return $this->originalHosts;
    }
    /**
     * Getter.
     *
     * @codeCoverageIgnore
     */
    public function getExtended() {
        return $this->extended;
    }
    /**
     * Getter.
     *
     * @codeCoverageIgnore
     */
    public function getMustHosts() {
        return $this->mustHosts;
    }
}
