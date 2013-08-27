<?php

class BottlesOfBeerTest extends PHPUnit_Framework_TestCase
{
	public function testSing()
	{
		$lines = [];
		$lines[] = '0 bottles of beer on the wall';
		$lines[] = '1 bottles of beer on the wall';
		$lines[] = '2 bottles of beer on the wall';
		$lines[] = '3 bottles of beer on the wall';
		$lines[] = '4 bottles of beer on the wall';
		$lines[] = '5 bottles of beer on the wall';
		$lines[] = '6 bottles of beer on the wall';
		$lines[] = '7 bottles of beer on the wall';
		$lines[] = '8 bottles of beer on the wall';
		$lines[] = '9 bottles of beer on the wall';
		$lines[] = '';

		$this->expectOutputString(join($lines, "\n"));

		$Program = new Program_Composition(
			new Program_Composition(
				new Program_Assign('i', new Expression_Constant(0)),
				new Program_Assign('text', new Expression_Constant(' bottles of beer on the wall'))
			),
			new Program_While(
				new Expression_BinaryOperator('-', new Expression_Constant(10), new Expression_Variable("i")),
				new Program_Composition(
					new Program_Composition(
						new Program_Write("i"),
						new Program_Write_Line("text")
					),
					new Program_Assign("i",
						new Expression_BinaryOperator('+', new Expression_Variable('i'), new Expression_Constant(1)))
				)
			)
		);

		$Program->execute(new Memory());
	}
}
 