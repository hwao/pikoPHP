<?php

class Memory
{
    /**
     * 'Pamięć'
     * Klucz (zmienna) => wartość (stała)
     * @var array
     */
    private $map;

    public function set($variable, $value)
    {
        $this->map[$variable] = $value;
    }

    public function find($variableName)
    {
        if (isSet($this->map[$variableName])) {
            return $this->map[$variableName];
        }

        throw new Exception_Memory_VaribleNotFound('Variable "' . $variableName . '" not found!');
    }
}