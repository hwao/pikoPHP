<?php
/**
 * Fasada
 */
class Calculator
{
	public function __construct()
	{
	}

	public function calculate($input, $memory = [])
	{
		$Parser = new Parser($input);
		$Expression = $Parser->parseExpression();

		// Gdy input jest valid - obliczenia
		$Memory = new Memory();
		foreach ($memory As $k => $v) {
			$Memory->set($k, $v);
		}
		return $Expression->evalExpression($Memory);
	}
}