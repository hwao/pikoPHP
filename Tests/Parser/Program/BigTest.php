<?php

class BigTest extends PHPUnit_Framework_TestCase
{
	public function testSimpleCode()
	{
		$source = <<<CODE
p = 2
return p
CODE;
		$this->assertEquals(2, $this->executeCode($source));
	}

	public function testStandardCode()
	{
		// todo fail!
		$source = <<<CODE
  if 1
  {
	skip
  }
  else
  {
  	skip
  }

CODE;
		$this->expectOutputString('test');
		$this->executeCode($source);
	}

	public function testComplexCode()
	{
		$source = <<<CODE
p = 2
while 40 - p
{
  pierwsza = 1
  r = 2
  while p - r
  {
    if p % r
      skip
    else
      pierwsza = 0
    r = r + 1
  }
  if pierwsza
    write p
  else
    skip
  p = p + 1
}
CODE;
	}

	private function executeCode($source)
	{
		$Parser = new Parser_Program($source);
		$Program = $Parser->parseProgram();
		return $Program->execute(new Memory());

	}
}
