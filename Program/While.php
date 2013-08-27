<?php

class Program_While extends Program
{
	/**
	 * @var Program
	 */
	private $Body;
	/**
	 * @var Expression
	 */
	private $Condition;

	public function __construct(Expression $Condition, Program $Body)
	{
		$this->Body = $Body;
		$this->Condition = $Condition;
	}

	public function execute(Memory $Memory)
	{
		$value = $this->Condition->evalExpression($Memory);
		if ($value == true) {
			$this->Body->execute($Memory);
			$this->execute($Memory);
		}
	}
}