<?php

class CalculatorTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var Calculator
	 */
	protected $Calculator;

	protected function setUp()
	{
		$this->Calculator = new Calculator();
	}

	public function testConstants()
	{
		$this->assertEquals($this->Calculator->calculate('0'), 0);
		$this->assertEquals($this->Calculator->calculate('1'), 1);
		$this->assertEquals($this->Calculator->calculate('2'), 2);
		$this->assertEquals($this->Calculator->calculate('3'), 3);
		$this->assertEquals($this->Calculator->calculate('5'), 5);
		$this->assertEquals($this->Calculator->calculate('7'), 7);
		$this->assertEquals($this->Calculator->calculate('11'), 11);
		$this->assertEquals($this->Calculator->calculate('13'), 13);
		// ...
		$this->assertEquals($this->Calculator->calculate('101'), 101);
		$this->assertEquals($this->Calculator->calculate('113'), 113);
		$this->assertEquals($this->Calculator->calculate('173'), 173);
		// ...
		$this->assertEquals($this->Calculator->calculate('1013'), 1013);
		$this->assertEquals($this->Calculator->calculate('1019'), 1019);
	}

	public function testPlus()
	{
		$this->assertEquals($this->Calculator->calculate('0+0'), 0);
		$this->assertEquals($this->Calculator->calculate('1+1'), 2);
		$this->assertEquals($this->Calculator->calculate('1+11'), 12);
		$this->assertEquals($this->Calculator->calculate('12+15'), 27);
		$this->assertEquals($this->Calculator->calculate('100+17'), 117);
		$this->assertEquals($this->Calculator->calculate('1+111'), 112);
		$this->assertEquals($this->Calculator->calculate('11+1111'), 1122);
	}

	public function testMinus()
	{
		$this->assertEquals($this->Calculator->calculate('0-0'), 0);
		$this->assertEquals($this->Calculator->calculate('1-1'), 0);
		$this->assertEquals($this->Calculator->calculate('1-11'), -10);
		$this->assertEquals($this->Calculator->calculate('12-15'), -3);
		$this->assertEquals($this->Calculator->calculate('100-17'), 83);
		$this->assertEquals($this->Calculator->calculate('1-111'), -110);
		$this->assertEquals($this->Calculator->calculate('11-1111'), -1100);
	}

	public function testMultiplication()
	{
		$this->assertEquals($this->Calculator->calculate('0*0'), 0);
		$this->assertEquals($this->Calculator->calculate('1*7'), 7);
		$this->assertEquals($this->Calculator->calculate('2*5'), 10);
	}

	public function testDivision()
	{
		$this->assertEquals($this->Calculator->calculate('0/1'), 0);
		$this->assertEquals($this->Calculator->calculate('10/2'), 5);
		$this->assertEquals($this->Calculator->calculate('3/4'), 0.75);
	}

	/**
	 * @expectedException Exception_Memory_VariableNotFound
	 */
	public function testCalculatorVariableNotFound()
	{
		$this->assertEquals($this->Calculator->calculate('2+x'), 0);
	}

	public function testSimpleSyntax()
	{
		$this->assertEquals($this->Calculator->calculate('(1+7)*(4*5)'), 160);
		$this->assertEquals($this->Calculator->calculate('2+(1+7)*(4*5)'), 162);

		$this->assertEquals($this->Calculator->calculate('x+(1+7)*(4*5)', ['x' => 5]), 165);
		$this->assertEquals($this->Calculator->calculate('x+(1+7)*(4*5)', ['x' => -5]), 155);
	}

	public function testRemoveWhitespace()
	{
		$this->assertEquals($this->Calculator->calculate(' ( 1 + 7 ) * ( 4 * 5 ) '), 160);
		$this->assertEquals($this->Calculator->calculate(' 1 '), 1);
		$this->assertEquals($this->Calculator->calculate(' ( 0 - 1 ) '), -1);
		$this->assertEquals($this->Calculator->calculate(' ( 0 - 1 ) * 2 '), -2);
		$this->assertEquals($this->Calculator->calculate(' 1 / 2 '), 0.5);
	}
}
 