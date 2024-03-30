<?php

namespace DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\CSSList;

use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Comment\Comment;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Comment\Commentable;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\OutputFormat;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\ParserState;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\SourceException;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\UnexpectedEOFException;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\UnexpectedTokenException;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Property\AtRule;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Property\Charset;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Property\CSSNamespace;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Property\Import;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Property\Selector;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Renderable;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\RuleSet\AtRuleSet;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\RuleSet\DeclarationBlock;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\RuleSet\RuleSet;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Settings;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Value\CSSString;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Value\URL;
use DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Value\Value;
/**
 * A `CSSList` is the most generic container available. Its contents include `RuleSet` as well as other `CSSList`
 * objects.
 *
 * Also, it may contain `Import` and `Charset` objects stemming from at-rules.
 */
abstract class CSSList implements \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Renderable, \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Comment\Commentable
{
    /**
     * @var array<array-key, Comment>
     */
    protected $aComments;
    /**
     * @var array<int, RuleSet|CSSList|Import|Charset>
     */
    protected $aContents;
    /**
     * @var int
     */
    protected $iLineNo;
    /**
     * @param int $iLineNo
     */
    public function __construct($iLineNo = 0)
    {
        $this->aComments = [];
        $this->aContents = [];
        $this->iLineNo = $iLineNo;
    }
    /**
     * @return void
     *
     * @throws UnexpectedTokenException
     * @throws SourceException
     */
    public static function parseList(\DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\ParserState $oParserState, \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\CSSList\CSSList $oList)
    {
        $bIsRoot = $oList instanceof \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\CSSList\Document;
        if (\is_string($oParserState)) {
            $oParserState = new \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\ParserState($oParserState, \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Settings::create());
        }
        $bLenientParsing = $oParserState->getSettings()->bLenientParsing;
        while (!$oParserState->isEnd()) {
            $comments = $oParserState->consumeWhiteSpace();
            $oListItem = null;
            if ($bLenientParsing) {
                try {
                    $oListItem = self::parseListItem($oParserState, $oList);
                } catch (\DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\UnexpectedTokenException $e) {
                    $oListItem = \false;
                }
            } else {
                $oListItem = self::parseListItem($oParserState, $oList);
            }
            if ($oListItem === null) {
                // List parsing finished
                return;
            }
            if ($oListItem) {
                $oListItem->setComments($comments);
                $oList->append($oListItem);
            }
            $oParserState->consumeWhiteSpace();
        }
        if (!$bIsRoot && !$bLenientParsing) {
            throw new \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\SourceException("Unexpected end of document", $oParserState->currentLine());
        }
    }
    /**
     * @return AtRuleBlockList|KeyFrame|Charset|CSSNamespace|Import|AtRuleSet|DeclarationBlock|null|false
     *
     * @throws SourceException
     * @throws UnexpectedEOFException
     * @throws UnexpectedTokenException
     */
    private static function parseListItem(\DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\ParserState $oParserState, \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\CSSList\CSSList $oList)
    {
        $bIsRoot = $oList instanceof \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\CSSList\Document;
        if ($oParserState->comes('@')) {
            $oAtRule = self::parseAtRule($oParserState);
            if ($oAtRule instanceof \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Property\Charset) {
                if (!$bIsRoot) {
                    throw new \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\UnexpectedTokenException('@charset may only occur in root document', '', 'custom', $oParserState->currentLine());
                }
                if (\count($oList->getContents()) > 0) {
                    throw new \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\UnexpectedTokenException('@charset must be the first parseable token in a document', '', 'custom', $oParserState->currentLine());
                }
                $oParserState->setCharset($oAtRule->getCharset()->getString());
            }
            return $oAtRule;
        } elseif ($oParserState->comes('}')) {
            if (!$oParserState->getSettings()->bLenientParsing) {
                throw new \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\UnexpectedTokenException('CSS selector', '}', 'identifier', $oParserState->currentLine());
            } else {
                if ($bIsRoot) {
                    if ($oParserState->getSettings()->bLenientParsing) {
                        return \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\RuleSet\DeclarationBlock::parse($oParserState);
                    } else {
                        throw new \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\SourceException("Unopened {", $oParserState->currentLine());
                    }
                } else {
                    return null;
                }
            }
        } else {
            return \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\RuleSet\DeclarationBlock::parse($oParserState, $oList);
        }
    }
    /**
     * @param ParserState $oParserState
     *
     * @return AtRuleBlockList|KeyFrame|Charset|CSSNamespace|Import|AtRuleSet|null
     *
     * @throws SourceException
     * @throws UnexpectedTokenException
     * @throws UnexpectedEOFException
     */
    private static function parseAtRule(\DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\ParserState $oParserState)
    {
        $oParserState->consume('@');
        $sIdentifier = $oParserState->parseIdentifier();
        $iIdentifierLineNum = $oParserState->currentLine();
        $oParserState->consumeWhiteSpace();
        if ($sIdentifier === 'import') {
            $oLocation = \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Value\URL::parse($oParserState);
            $oParserState->consumeWhiteSpace();
            $sMediaQuery = null;
            if (!$oParserState->comes(';')) {
                $sMediaQuery = \trim($oParserState->consumeUntil([';', \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\ParserState::EOF]));
            }
            $oParserState->consumeUntil([';', \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\ParserState::EOF], \true, \true);
            return new \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Property\Import($oLocation, $sMediaQuery ?: null, $iIdentifierLineNum);
        } elseif ($sIdentifier === 'charset') {
            $sCharset = \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Value\CSSString::parse($oParserState);
            $oParserState->consumeWhiteSpace();
            $oParserState->consumeUntil([';', \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\ParserState::EOF], \true, \true);
            return new \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Property\Charset($sCharset, $iIdentifierLineNum);
        } elseif (self::identifierIs($sIdentifier, 'keyframes')) {
            $oResult = new \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\CSSList\KeyFrame($iIdentifierLineNum);
            $oResult->setVendorKeyFrame($sIdentifier);
            $oResult->setAnimationName(\trim($oParserState->consumeUntil('{', \false, \true)));
            \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\CSSList\CSSList::parseList($oParserState, $oResult);
            if ($oParserState->comes('}')) {
                $oParserState->consume('}');
            }
            return $oResult;
        } elseif ($sIdentifier === 'namespace') {
            $sPrefix = null;
            $mUrl = \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Value\Value::parsePrimitiveValue($oParserState);
            if (!$oParserState->comes(';')) {
                $sPrefix = $mUrl;
                $mUrl = \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Value\Value::parsePrimitiveValue($oParserState);
            }
            $oParserState->consumeUntil([';', \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\ParserState::EOF], \true, \true);
            if ($sPrefix !== null && !\is_string($sPrefix)) {
                throw new \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\UnexpectedTokenException('Wrong namespace prefix', $sPrefix, 'custom', $iIdentifierLineNum);
            }
            if (!($mUrl instanceof \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Value\CSSString || $mUrl instanceof \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Value\URL)) {
                throw new \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\UnexpectedTokenException('Wrong namespace url of invalid type', $mUrl, 'custom', $iIdentifierLineNum);
            }
            return new \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Property\CSSNamespace($mUrl, $sPrefix, $iIdentifierLineNum);
        } else {
            // Unknown other at rule (font-face or such)
            $sArgs = \trim($oParserState->consumeUntil('{', \false, \true));
            if (\substr_count($sArgs, "(") != \substr_count($sArgs, ")")) {
                if ($oParserState->getSettings()->bLenientParsing) {
                    return null;
                } else {
                    throw new \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\SourceException("Unmatched brace count in media query", $oParserState->currentLine());
                }
            }
            $bUseRuleSet = \true;
            foreach (\explode('/', \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Property\AtRule::BLOCK_RULES) as $sBlockRuleName) {
                if (self::identifierIs($sIdentifier, $sBlockRuleName)) {
                    $bUseRuleSet = \false;
                    break;
                }
            }
            if ($bUseRuleSet) {
                $oAtRule = new \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\RuleSet\AtRuleSet($sIdentifier, $sArgs, $iIdentifierLineNum);
                \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\RuleSet\RuleSet::parseRuleSet($oParserState, $oAtRule);
            } else {
                $oAtRule = new \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\CSSList\AtRuleBlockList($sIdentifier, $sArgs, $iIdentifierLineNum);
                \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\CSSList\CSSList::parseList($oParserState, $oAtRule);
                if ($oParserState->comes('}')) {
                    $oParserState->consume('}');
                }
            }
            return $oAtRule;
        }
    }
    /**
     * Tests an identifier for a given value. Since identifiers are all keywords, they can be vendor-prefixed.
     * We need to check for these versions too.
     *
     * @param string $sIdentifier
     * @param string $sMatch
     *
     * @return bool
     */
    private static function identifierIs($sIdentifier, $sMatch)
    {
        return \strcasecmp($sIdentifier, $sMatch) === 0 ?: \preg_match("/^(-\\w+-)?{$sMatch}\$/i", $sIdentifier) === 1;
    }
    /**
     * @return int
     */
    public function getLineNo()
    {
        return $this->iLineNo;
    }
    /**
     * Prepends an item to the list of contents.
     *
     * @param RuleSet|CSSList|Import|Charset $oItem
     *
     * @return void
     */
    public function prepend($oItem)
    {
        \array_unshift($this->aContents, $oItem);
    }
    /**
     * Appends an item to tje list of contents.
     *
     * @param RuleSet|CSSList|Import|Charset $oItem
     *
     * @return void
     */
    public function append($oItem)
    {
        $this->aContents[] = $oItem;
    }
    /**
     * Splices the list of contents.
     *
     * @param int $iOffset
     * @param int $iLength
     * @param array<int, RuleSet|CSSList|Import|Charset> $mReplacement
     *
     * @return void
     */
    public function splice($iOffset, $iLength = null, $mReplacement = null)
    {
        \array_splice($this->aContents, $iOffset, $iLength, $mReplacement);
    }
    /**
     * Removes an item from the CSS list.
     *
     * @param RuleSet|Import|Charset|CSSList $oItemToRemove
     *        May be a RuleSet (most likely a DeclarationBlock), a Import,
     *        a Charset or another CSSList (most likely a MediaQuery)
     *
     * @return bool whether the item was removed
     */
    public function remove($oItemToRemove)
    {
        $iKey = \array_search($oItemToRemove, $this->aContents, \true);
        if ($iKey !== \false) {
            unset($this->aContents[$iKey]);
            return \true;
        }
        return \false;
    }
    /**
     * Replaces an item from the CSS list.
     *
     * @param RuleSet|Import|Charset|CSSList $oOldItem
     *        May be a `RuleSet` (most likely a `DeclarationBlock`), an `Import`, a `Charset`
     *        or another `CSSList` (most likely a `MediaQuery`)
     *
     * @return bool
     */
    public function replace($oOldItem, $mNewItem)
    {
        $iKey = \array_search($oOldItem, $this->aContents, \true);
        if ($iKey !== \false) {
            if (\is_array($mNewItem)) {
                \array_splice($this->aContents, $iKey, 1, $mNewItem);
            } else {
                \array_splice($this->aContents, $iKey, 1, [$mNewItem]);
            }
            return \true;
        }
        return \false;
    }
    /**
     * @param array<int, RuleSet|Import|Charset|CSSList> $aContents
     */
    public function setContents(array $aContents)
    {
        $this->aContents = [];
        foreach ($aContents as $content) {
            $this->append($content);
        }
    }
    /**
     * Removes a declaration block from the CSS list if it matches all given selectors.
     *
     * @param DeclarationBlock|array<array-key, Selector>|string $mSelector the selectors to match
     * @param bool $bRemoveAll whether to stop at the first declaration block found or remove all blocks
     *
     * @return void
     */
    public function removeDeclarationBlockBySelector($mSelector, $bRemoveAll = \false)
    {
        if ($mSelector instanceof \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\RuleSet\DeclarationBlock) {
            $mSelector = $mSelector->getSelectors();
        }
        if (!\is_array($mSelector)) {
            $mSelector = \explode(',', $mSelector);
        }
        foreach ($mSelector as $iKey => &$mSel) {
            if (!$mSel instanceof \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Property\Selector) {
                if (!\DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Property\Selector::isValid($mSel)) {
                    throw new \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Parsing\UnexpectedTokenException("Selector did not match '" . \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Property\Selector::SELECTOR_VALIDATION_RX . "'.", $mSel, "custom");
                }
                $mSel = new \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\Property\Selector($mSel);
            }
        }
        foreach ($this->aContents as $iKey => $mItem) {
            if (!$mItem instanceof \DevOwl\RealCookieBanner\Vendor\Sabberworm\CSS\RuleSet\DeclarationBlock) {
                continue;
            }
            if ($mItem->getSelectors() == $mSelector) {
                unset($this->aContents[$iKey]);
                if (!$bRemoveAll) {
                    return;
                }
            }
        }
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
        $sResult = '';
        $bIsFirst = \true;
        $oNextLevel = $oOutputFormat;
        if (!$this->isRootList()) {
            $oNextLevel = $oOutputFormat->nextLevel();
        }
        foreach ($this->aContents as $oContent) {
            $sRendered = $oOutputFormat->safely(function () use($oNextLevel, $oContent) {
                return $oContent->render($oNextLevel);
            });
            if ($sRendered === null) {
                continue;
            }
            if ($bIsFirst) {
                $bIsFirst = \false;
                $sResult .= $oNextLevel->spaceBeforeBlocks();
            } else {
                $sResult .= $oNextLevel->spaceBetweenBlocks();
            }
            $sResult .= $sRendered;
        }
        if (!$bIsFirst) {
            // Had some output
            $sResult .= $oOutputFormat->spaceAfterBlocks();
        }
        return $sResult;
    }
    /**
     * Return true if the list can not be further outdented. Only important when rendering.
     *
     * @return bool
     */
    public abstract function isRootList();
    /**
     * @return array<int, RuleSet|Import|Charset|CSSList>
     */
    public function getContents()
    {
        return $this->aContents;
    }
    /**
     * @param array<array-key, Comment> $aComments
     *
     * @return void
     */
    public function addComments(array $aComments)
    {
        $this->aComments = \array_merge($this->aComments, $aComments);
    }
    /**
     * @return array<array-key, Comment>
     */
    public function getComments()
    {
        return $this->aComments;
    }
    /**
     * @param array<array-key, Comment> $aComments
     *
     * @return void
     */
    public function setComments(array $aComments)
    {
        $this->aComments = $aComments;
    }
}
