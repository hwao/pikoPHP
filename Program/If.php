<?php

class Program_If extends Program
{
	/**
	 * @var Program
	 */
	private $Them;
	/**
	 * @var Program
	 */
	private $Else;
	/**
	 * @var Expression
	 */
	private $Condition;

	public function __construct(Programm $Them, Program $Else, Expression $Condition)
	{
		$this->Them = $Them;
		$this->Else = $Else;
		$this->Condition = $Condition;
	}

	public function execute(Memory $Memory)
	{
		$value = $this->Condition->evalExpression($Memory);
		if ($value == true) {
			$this->Them->execute($Memory);
		} else {
			$this->Else->execute($Memory);
		}
	}
}