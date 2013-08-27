<?php

class Program_Write_Line extends Program_Write
{
	public function execute(Memory $Memory)
	{
		parent::execute($Memory);
		echo "\n";
	}
}