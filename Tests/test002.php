<?php
include_once __DIR__ . '/../bootstrap.php';

$Memory = new Memory();

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


// Test 1
try {
    $e1->evalExpression($Memory);
} catch (Exception_Memory_VaribleNotFound $e) {
    var_dump(true);
}

// Test 2
$Memory->set('x', 10);
$Memory->set('y', 5);

var_dump($e1->evalExpression($Memory) === 25);
