<?php
/**
 * Obsluga zmiennych
 */
class Expression_Variable extends Expression
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function evalExpression(Memory $Memory)
    {
        $value = $Memory->find($this->name);
        return $value;
    }
}