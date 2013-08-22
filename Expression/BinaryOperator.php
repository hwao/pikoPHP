<?php
/**
 * Operatory binarne
 * np.: dodawanie:
 * Lewa + Prawa
 * 1 + 2
 * Lewa * Prawa
 * 4 * 6
 * etc
 */
class Expression_BinaryOperator extends Expression
{
    /**
     * Operacja arytmetyczna
     * @var string
     */
    private $symbol;

    /**
     * @var Expression
     */
    private $ExpressionLeft;
    /**
     * @var Expression
     */
    private $ExpressionRight;

    public function __construct($symbol, Expression $left, Expression $right)
    {
        $this->symbol = $symbol;
        $this->ExpressionLeft = $left;
        $this->ExpressionRight = $right;
    }

    public function evalExpression(Memory $Memory)
    {
        switch ($this->symbol) {
            case '*':
                return $this->ExpressionLeft->evalExpression($Memory) * $this->ExpressionRight->evalExpression($Memory);
            case '/':
                return $this->ExpressionLeft->evalExpression($Memory) / $this->ExpressionRight->evalExpression($Memory);
            case '+':
                return $this->ExpressionLeft->evalExpression($Memory) + $this->ExpressionRight->evalExpression($Memory);
            case '-':
                return $this->ExpressionLeft->evalExpression($Memory) - $this->ExpressionRight->evalExpression($Memory);
        }
    }
}