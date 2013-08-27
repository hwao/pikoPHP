<?php

class Parser_Program extends Parser
{
	public function parseProgram()
	{
		$Program = $this->parseBlock();
		if ($this->lookAhead() === NULL) {
			return $Program;
		}
		throw new Exception_Parser_NotParsed('end of program excepted');
	}

	private function parseBlock()
	{
		$Program = $this->parseInstruction();
		$char = $this->lookAhead();
		while (!in_array($char, ['}', NULL])) {
			$ProgramSecond = $this->parseInstruction();
			$Program = new Program_Composition($Program, $ProgramSecond);
			$char = $this->lookAhead();
		}
		return $Program;
	}

	private function parseIdentifier()
	{
		$string = '';
		// todo refactoring - brzydki kod
		while ($this->isAlnum($this->activeChar())) {
			$string .= $this->activeChar();
			$this->incrementPosition();
		}
		return $string;
	}

	private function parseInstruction()
	{
		$char = $this->lookAhead();
		if ($char == '{') {
			$this->incrementPosition();

			$Program = $this->parseBlock();
			if ($this->lookAhead() == '}') {
				$this->incrementPosition();
				return $Program;
			}
			throw new Exception_Parser_NotParsed('"}" not found');
		} elseif ($this->isAlnum($char)) {
			$string = $this->parseIdentifier();

			switch ($string) {
				case 'read':
					return $this->parseRead();
				case 'write':
					return $this->parseWrite();
				case 'return':
					return $this->parseReturn();
				case 'if':
					return $this->parseIf();
				case 'while':
					return $this->parseWhile();
				case 'skip':
					return $this->parseSkip();
				default:
					return $this->parseAssign($string);
			}
			throw new Exception_Parser_NotParsed('identifier or keyword not found');
		}
	}

	private function parseRead()
	{
		$char = $this->lookAhead();
		if ($this->isAlnum($char)) {
			$string = $this->parseIdentifier();
			return new Program_Read($string);
		}
		throw new Exception_Parser_NotParsed('znaki powinny byc a-z :(');
	}

	private function parseWrite()
	{
		$char = $this->lookAhead();
		if ($this->isAlnum($char)) {
			$string = $this->parseIdentifier();
			return new Program_Write($string);
		}
		throw new Exception_Parser_NotParsed('variable not found');
	}

	private function parseReturn()
	{
		// todo taka sama metoda jak parseWrite
		$char = $this->lookAhead();
		if ($this->isAlnum($char)) {
			$string = $this->parseIdentifier();
			return new Program_Return($string);
		}
		throw new Exception_Parser_NotParsed('variable not found');
	}

	private function parseIf()
	{
		$Expression = $this->parseSum();
		$Program = $this->parseInstruction();
		if ($this->isAlnum($this->lookAhead())) {
			if ($this->parseInstruction() == 'else') {
				$Else = $this->parseInstruction();
				return new Program_If($Expression, $Program, $Else);
			}
			throw new Exception_Parser_NotParsed('"else" not found (2)');
		}
		throw new Exception_Parser_NotParsed('"else" not found (1)');
	}

	private function parseWhile()
	{
		$Expression = $this->parseSum();
		$Program = $this->parseInstruction();
		return new Program_While($Expression, $Program);
	}

	private function parseSkip()
	{
		return new Program_Skip();
	}

	private function parseAssign($string)
	{
		$char = $this->lookAhead();
		if ($char == '=') {
			$this->incrementPosition();
			$Expression = $this->parseSum();
			return new Program_Assign($string, $Expression);
		}
		throw new Exception_Parser_NotParsed('"=" not found');
	}
} 