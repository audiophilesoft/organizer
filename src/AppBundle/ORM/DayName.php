<?php

namespace AppBundle\ORM;


use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

class DayName extends FunctionNode
{
    public $date;


    public function getSql(\Doctrine\ORM\Query\SqlWalker $sql_walker): string
    {
        return 'DAYNAME(' . $this->date->dispatch($sql_walker) . ')';
    }


    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->date = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

}