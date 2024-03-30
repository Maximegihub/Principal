<?php

namespace DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\CSSList;

use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\OutputFormat;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Property\AtRule;
/**
 * A `BlockList` constructed by an unknown at-rule. `@media` rules are rendered into `AtRuleBlockList` objects.
 */
class AtRuleBlockList extends \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\CSSList\CSSBlockList implements \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Property\AtRule
{
    /**
     * @var string
     */
    private $sType;
    /**
     * @var string
     */
    private $sArgs;
    /**
     * @param string $sType
     * @param string $sArgs
     * @param int $iLineNo
     */
    public function __construct($sType, $sArgs = '', $iLineNo = 0)
    {
        parent::__construct($iLineNo);
        $this->sType = $sType;
        $this->sArgs = $sArgs;
    }
    /**
     * @return string
     */
    public function atRuleName()
    {
        return $this->sType;
    }
    /**
     * @return string
     */
    public function atRuleArgs()
    {
        return $this->sArgs;
    }
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render(new \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\OutputFormat());
    }
    /**
     * @return string
     */
    public function render(\DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\OutputFormat $oOutputFormat)
    {
        $sArgs = $this->sArgs;
        if ($sArgs) {
            $sArgs = ' ' . $sArgs;
        }
        $sResult = $oOutputFormat->sBeforeAtRuleBlock;
        $sResult .= "@{$this->sType}{$sArgs}{$oOutputFormat->spaceBeforeOpeningBrace()}{";
        $sResult .= parent::render($oOutputFormat);
        $sResult .= '}';
        $sResult .= $oOutputFormat->sAfterAtRuleBlock;
        return $sResult;
    }
    /**
     * @return bool
     */
    public function isRootList()
    {
        return \false;
    }
}
