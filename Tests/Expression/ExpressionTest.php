<?php

class ExpressionTest extends PHPUnit_Framework_TestCase
{
	public function testBasic()
	{
		$Memory = new Memory();

		// (1 + 7) * (4 * 5)
		$n4 = new Expression_Constant(4);
		$n5 = new Expression_Constant(5);
		$e1 = new Expression_BinaryOperator('*', $n4, $n5);
		$n1 = new Expression_Constant(1);
		$n7 = new Expression_Constant(7);
		$e2 = new Expression_BinaryOperator('+', $n1, $n7);
		$e3 = new Expression_BinaryOperator('*', $e2, $e1);

		$this->assertEquals(160, $e3->evalExpression($Memory));

		// 2 + (1 + 7) * (4 * 5)
		$n2 = new Expression_Constant(2);
		$e4 = new Expression_BinaryOperator('+', $n2, $e3);

		$this->assertEquals(162, $e4->evalExpression($Memory));
	}

	/**
	 * @expectedException Exception_Memory_VaribleNotFound
	 */
	public function testExceptionVaribleNotFound()
	{
		$e1 = new Expression_BinaryOperator(
			'+',
			new Expression_BinaryOperator(
				'*',
				new Expression_Constant(2),
				new Expression_Variable('x')
			),
			new Expression_Variable('y')
		);
		$Memory = new Memory();
		$e1->evalExpression($Memory);
	}

	public function testUsingVars()
	{
		// 2 * x + y
		// x = 10
		// y = 5:
		$e1 = new Expression_BinaryOperator(
			'+',
			new Expression_BinaryOperator(
				'*',
				new Expression_Constant(2),
				new Expression_Variable('x')
			),
			new Expression_Variable('y')
		);

		$Memory = new Memory();
		$Memory->set('x', 10);
		$Memory->set('y', 5);

		$this->assertEquals(25, $e1->evalExpression($Memory));
	}
}
 