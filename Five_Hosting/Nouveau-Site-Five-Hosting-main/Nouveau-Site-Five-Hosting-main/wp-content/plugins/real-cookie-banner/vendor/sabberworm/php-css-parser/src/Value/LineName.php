<?php

namespace DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Value;

use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\OutputFormat;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\ParserState;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\UnexpectedEOFException;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\UnexpectedTokenException;
class LineName extends \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Value\ValueList
{
    /**
     * @param array<int, RuleValueList|CSSFunction|CSSString|LineName|Size|URL|string> $aComponents
     * @param int $iLineNo
     */
    public function __construct(array $aComponents = [], $iLineNo = 0)
    {
        parent::__construct($aComponents, ' ', $iLineNo);
    }
    /**
     * @return LineName
     *
     * @throws UnexpectedTokenException
     * @throws UnexpectedEOFException
     */
    public static function parse(\DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\ParserState $oParserState)
    {
        $oParserState->consume('[');
        $oParserState->consumeWhiteSpace();
        $aNames = [];
        do {
            if ($oParserState->getSettings()->bLenientParsing) {
                try {
                    $aNames[] = $oParserState->parseIdentifier();
                } catch (\DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\UnexpectedTokenException $e) {
                    if (!$oParserState->comes(']')) {
                        throw $e;
                    }
                }
            } else {
                $aNames[] = $oParserState->parseIdentifier();
            }
            $oParserState->consumeWhiteSpace();
        } while (!$oParserState->comes(']'));
        $oParserState->consume(']');
        return new \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Value\LineName($aNames, $oParserState->currentLine());
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
        return '[' . parent::render(\DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\OutputFormat::createCompact()) . ']';
    }
}
