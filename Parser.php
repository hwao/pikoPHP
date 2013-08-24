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
	private function parseSum()
	{
		$Expression = $this->parseMult();
		$char = $this->lookAhead();

		while (in_array($char, ['+', '-'])) {
			$this->incrementPosition();
			$Expression = new Expression_BinaryOperator($char, $Expression, $this->parseMult());
			$char = $this->lookAhead();
		}

		return $Expression;
	}

	/**
	 * Parsuje składnik.
	 * @return Expression
	 */
	protected function parseMult()
	{
		$Expression = $this->parseTerm();
		$char = $this->lookAhead();

		while ($char == '*' || $char == '/' || $char == '%') {
			$this->position++;
			$Expression = new Expression_BinaryOperator($char, $Expression, $this->parseTerm());
			$char = $this->lookAhead();
		}

		return $Expression;
	}

	/**
	 * Parsuje czynnik.
	 * @return Expression
	 */
	protected function parseTerm()
	{
		$char = $this->lookAhead();
		if (is_numeric($char))
			return $this->parseConstant();
		else if ($this->isAlnum($char))
			return $this->parseVarible();
		else if ($char == '(')
			return $this->parseParen();
		else
			throw new Exception_Parser_NotParsed($this->input);
	}

	/**
	 * Parsuje liczbę.
	 * @return Expression
	 */
	public function parseConstant()
	{
		$n = 0;
		while (is_numeric($this->activeChar())) {
			$n *= 10;
			$n += $this->activeChar() - '0';
			$this->position++;
		}
		return new Expression_Constant($n);
	}

	/**
	 * Parsuje nazwę zmiennej.
	 * @return Expression
	 */
	protected function parseVarible()
	{
		$s = '';
		while ($this->isAlnum($this->activeChar())) {
			$s .= $this->activeChar();
			$this->position++;
		}
		return new Expression_Variable($s);
	}

	private function isAlnum($char)
	{
		return (bool)preg_match('@^[a-z]$@i', $char);
	}

	/**
	 * Parsuje "sumę" w nawiasie.
	 * @return Expression
	 */
	protected function parseParen()
	{
		$this->position++; // parse_term zapewnia, że wskaźnik
		// stoi na nawiasie otwierającym '('
		$Expression = $this->parseSum();
		if ($this->lookAhead() == ')') {
			$this->position++;
			return $Expression;
		} else
			throw new Exception_Parser_NotParsed($this->input);
	}
}