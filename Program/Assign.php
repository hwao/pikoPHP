<?php
/**
 * Created by PhpStorm.
 * User: hwao
 * Date: 26.08.13
 * Time: 22:20
 */

class Program_Assign extends Program
{
	private $variableName;
	/**
	 * @var Expression
	 */
	private $Expression;

	public function __construct($variableName, Expression $Expression)
	{
		$this->variableName = $variableName;
		$this->Expression = $Expression;
	}

	public function execute(Memory $Memory)
	{
		$value = $this->Expression->evalExpression($Memory);
		$Memory->set($this->variableName, $value);
	}
}