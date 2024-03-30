<?php

namespace DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Comment;

use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\OutputFormat;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Renderable;
class Comment implements \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Renderable
{
    /**
     * @var int
     */
    protected $iLineNo;
    /**
     * @var string
     */
    protected $sComment;
    /**
     * @param string $sComment
     * @param int $iLineNo
     */
    public function __construct($sComment = '', $iLineNo = 0)
    {
        $this->sComment = $sComment;
        $this->iLineNo = $iLineNo;
    }
    /**
     * @return string
     */
    public function getComment()
    {
        return $this->sComment;
    }
    /**
     * @return int
     */
    public function getLineNo()
    {
        return $this->iLineNo;
    }
    /**
     * @param string $sComment
     *
     * @return void
     */
    public function setComment($sComment)
    {
        $this->sComment = $sComment;
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
        return '/*' . $this->sComment . '*/';
    }
}
