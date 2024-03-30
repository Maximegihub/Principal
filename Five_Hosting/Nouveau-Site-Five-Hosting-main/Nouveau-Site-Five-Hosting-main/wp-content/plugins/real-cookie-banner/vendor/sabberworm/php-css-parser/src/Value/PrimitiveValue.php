<?php

namespace DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Value;

abstract class PrimitiveValue extends \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Value\Value
{
    /**
     * @param int $iLineNo
     */
    public function __construct($iLineNo = 0)
    {
        parent::__construct($iLineNo);
    }
}
