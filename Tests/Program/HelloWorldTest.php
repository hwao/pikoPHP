<?php

class HelloWorldTest extends PHPUnit_Framework_TestCase
{
	public function testHelloWorld()
	{
		$this->expectOutputString('Hello world!');

		$Program = new Program_Composition(
			new Program_Assign('text', new Expression_Constant('Hello world!')),
			new Program_Write('text')
		);

		$Program->execute(new Memory());
	}
}