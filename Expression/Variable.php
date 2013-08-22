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
        try {
            $value = $Memory->find($this->name);

        } catch (Exception $E) {
            throw new Exception_Memory_VaribleNotFound('Varible "' . $this->name . '" not found!');
        }
    }
}