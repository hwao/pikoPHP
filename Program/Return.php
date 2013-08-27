<?php

class Program_Return extends Program
{
	private $variableName;

	public function __construct($variableName)
	{
		$this->variableName = $variableName;
	}

	public function execute(Memory $Memory)
	{
		$value = $Memory->find($this->variableName);
		return $value;
	}
}