<?php
/**
 * Created by PhpStorm.
 * User: hwao
 * Date: 26.08.13
 * Time: 22:22
 */

class Program_Read extends Program
{
	private $variableName;

	public function __construct($variableName)
	{
		$this->variableName = $variableName;
	}

	public function execute(Memory $Memory)
	{
		$handle = fopen("php://stdin", "r");
		$value = fgets($handle);
		$Memory->set($this->variableName, $value);
	}


} 