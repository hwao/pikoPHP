<?php
include_once __DIR__ . '/../bootstrap.php';

$Memory = new Memory();

// (1 + 7) * (4 * 5)
$n4 = new Expression_Constant(4);
$n5 = new Expression_Constant(5);
$e1 = new Expression_BinaryOperator('*', $n4, $n5);
$n1 = new Expression_Constant(1);
$n7 = new Expression_Constant(7);
$e2 = new Expression_BinaryOperator('+', $n1, $n7);
$e3 = new Expression_BinaryOperator('*', $e2, $e1);

var_dump($e3->evalExpression($Memory) == 160);

// 2 + (1 + 7) * (4 * 5)
$n2 = new Expression_Constant(2);
$e4 = new Expression_BinaryOperator('+', $n2, $e3);

var_dump($e4->evalExpression($Memory) == 162);
