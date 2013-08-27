<?php
/**
 * Created by PhpStorm.
 * User: hwao
 * Date: 26.08.13
 * Time: 22:25
 */

class Program_Composition extends Program
{
	/**
	 * @var Program
	 */
	private $Left;
	/**
	 * @var Program
	 */
	private $Right;

	public function __construct(Program $Left, Program $Right)
	{
		$this->Left = $Left;
		$this->Right = $Right;
	}

	public function execute(Memory $Memory)
	{
		$this->Left->execute($Memory);
		return $this->Right->execute($Memory);
	}
}