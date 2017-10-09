<?php

namespace AppBundle\ORM;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

/**
 * DateAddFunction ::=
 *     "DATE_ADD" "(" ArithmeticPrimary ", INTERVAL" ArithmeticPrimary Identifier ")"
 */
class DateAddMod extends FunctionNode
{
    public $firstDateExpression;
    public $intervalExpression;
    public $unit;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->firstDateExpression = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_COMMA);
        $parser->match(Lexer::T_IDENTIFIER);

        $this->intervalExpression = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_IDENTIFIER);

        /* @var $lexer Lexer */
        $lexer = $parser->getLexer();
        $this->unit = $lexer->token['value'];

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'DATE_ADD(' .
            $this->firstDateExpression->dispatch($sqlWalker) . ', INTERVAL ' .
            $this->intervalExpression->dispatch($sqlWalker) . ' ' . $this->unit .
            ')';
    }
}