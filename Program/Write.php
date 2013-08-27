<?php

class Program_Write extends Program_Return
{
	public function execute(Memory $Memory)
	{
		echo parent::execute($Memory);
	}
}