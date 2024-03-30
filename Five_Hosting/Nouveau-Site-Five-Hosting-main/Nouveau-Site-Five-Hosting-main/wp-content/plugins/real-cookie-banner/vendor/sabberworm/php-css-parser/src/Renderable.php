<?php

namespace DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS;

interface Renderable
{
    /**
     * @return string
     */
    public function __toString();
    /**
     * @return string
     */
    public function render(\DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\OutputFormat $oOutputFormat);
    /**
     * @return int
     */
    public function getLineNo();
}
