<?php

namespace DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Value;

use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\ParserState;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\UnexpectedEOFException;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\UnexpectedTokenException;
class CalcFunction extends \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Value\CSSFunction
{
    /**
     * @var int
     */
    const T_OPERAND = 1;
    /**
     * @var int
     */
    const T_OPERATOR = 2;
    /**
     * @return CalcFunction
     *
     * @throws UnexpectedTokenException
     * @throws UnexpectedEOFException
     */
    public static function parse(\DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\ParserState $oParserState)
    {
        $aOperators = ['+', '-', '*', '/'];
        $sFunction = \trim($oParserState->consumeUntil('(', \false, \true));
        $oCalcList = new \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Value\CalcRuleValueList($oParserState->currentLine());
        $oList = new \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Value\RuleValueList(',', $oParserState->currentLine());
        $iNestingLevel = 0;
        $iLastComponentType = null;
        while (!$oParserState->comes(')') || $iNestingLevel > 0) {
            $oParserState->consumeWhiteSpace();
            if ($oParserState->comes('(')) {
                $iNestingLevel++;
                $oCalcList->addListComponent($oParserState->consume(1));
                $oParserState->consumeWhiteSpace();
                continue;
            } elseif ($oParserState->comes(')')) {
                $iNestingLevel--;
                $oCalcList->addListComponent($oParserState->consume(1));
                $oParserState->consumeWhiteSpace();
                continue;
            }
            if ($iLastComponentType != \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Value\CalcFunction::T_OPERAND) {
                $oVal = \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Value\Value::parsePrimitiveValue($oParserState);
                $oCalcList->addListComponent($oVal);
                $iLastComponentType = \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Value\CalcFunction::T_OPERAND;
            } else {
                if (\in_array($oParserState->peek(), $aOperators)) {
                    if ($oParserState->comes('-') || $oParserState->comes('+')) {
                        if ($oParserState->peek(1, -1) != ' ' || !($oParserState->comes('- ') || $oParserState->comes('+ '))) {
                            throw new \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\UnexpectedTokenException(" {$oParserState->peek()} ", $oParserState->peek(1, -1) . $oParserState->peek(2), 'literal', $oParserState->currentLine());
                        }
                    }
                    $oCalcList->addListComponent($oParserState->consume(1));
                    $iLastComponentType = \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Value\CalcFunction::T_OPERATOR;
                } else {
                    throw new \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\UnexpectedTokenException(\sprintf('Next token was expected to be an operand of type %s. Instead "%s" was found.', \implode(', ', $aOperators), $oVal), '', 'custom', $oParserState->currentLine());
                }
            }
            $oParserState->consumeWhiteSpace();
        }
        $oList->addListComponent($oCalcList);
        $oParserState->consume(')');
        return new \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Value\CalcFunction($sFunction, $oList, ',', $oParserState->currentLine());
    }
}
