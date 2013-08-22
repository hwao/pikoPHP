<?php
/**
 * Obsługa stałych (np liczby 1,2,3 etc)
 */
class Expression_Constant extends Expression
{
    private $value;

    public function __construct($val)
    {
        $this->value = $val;
    }

    public function evalExpression(Memory $Memory)
    {
        return $this->value;
    }
} 