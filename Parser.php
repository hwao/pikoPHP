<?php

class Parser
{
	private $input = '';
	private $position = 0;

	public function __construct($input)
	{
		$this->input = trim($input);
		$this->position = 0;
	}

	private function skipWhitespace()
	{
		return true;
	}

	private function lookAhead()
	{
		$this->skipWhitespace();
		return $this->activeChar();
	}

	private function activeChar()
	{
		if (isSet($this->input[$this->position])) {
			return $this->input[$this->position];
		}
		return null;
	}

	private function incrementPosition()
	{
		$this->position++;
	}

	private function isAlnum($char)
	{
		return (bool)preg_match('@^[a-z]$@i', $char);
	}

	/**
	 * @return Expression
	 */
	public function parseExpression()
	{
		$Expression = $this->parseSum();
		try {
			if (is_null($this->lookAhead())) {
				return $Expression;
			}
		} catch (Exception_Parser_EndOfString $e) {
			throw new Exception_Parser_NotParsed($this->input, 0, $e);
		}
	}

	/**
	 * @return Expression
	 */
	protected function parseSum()
	{
		$Expression = $this->parseMult();
		$char = $this->lookAhead();

		while (in_array($char, ['+', '-'])) {
			$this->incrementPosition();
			$Expression = new Expression_BinaryOperator($char, $Expression, $this->parseMult());
//			$char = $this->lookAhead();
		}

		return $Expression;
	}

	/**
	 * @return Expression
	 */
	protected function parseMult()
	{
		$Expression = $this->parseTerm();
		$char = $this->lookAhead();

		while (in_array($char, ['*', '/', '%'])) {
			$this->incrementPosition();
			$Expression = new Expression_BinaryOperator($char, $Expression, $this->parseTerm());
//			$char = $this->lookAhead();
		}
		return $Expression;
	}

	/**
	 * @return Expression
	 */
	protected function parseTerm()
	{
		$char = $this->lookAhead();
		if (is_numeric($char))
			return $this->parseConstant();
		else if ($this->isAlnum($char))
			return $this->parseVariable();
		else if ($char == '(')
			return $this->parseParent();

		throw new Exception_Parser_NotParsed($this->input);
	}

	/**
	 * @return Expression
	 */
	protected function parseConstant()
	{
		$int = 0;
		while (is_numeric($this->activeChar())) {
			$int *= 10;
			$int += $this->activeChar();
			$this->incrementPosition();
		}
		return new Expression_Constant($int);
	}

	/**
	 * @return Expression
	 */
	protected function parseVariable()
	{
		$variable = '';
		while ($this->isAlnum($this->activeChar())) {
			$variable .= $this->activeChar();
			$this->incrementPosition();
		}
		return new Expression_Variable($variable);
	}

	/**
	 * @return Expression
	 */
	protected function parseParent()
	{
		$this->incrementPosition(); // parse_term zapewnia, że 'wskaźnik' jest na nawiasie otwierającym '(', chcemy być dalej
		$Expression = $this->parseSum();
		if ($this->lookAhead() == ')') {
			$this->incrementPosition();
			return $Expression;
		}
		throw new Exception_Parser_NotParsed($this->input);
	}
}