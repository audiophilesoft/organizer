<?php

namespace AppBundle\ORM;


use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

class CurDate extends FunctionNode
{

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sql_walker): string
    {
        return 'CURDATE()';
    }


    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

}