<?php

namespace CashMachine;

class CashMachine 
{
	
	protected $noteMachine = array(100, 50, 20, 10);
	protected $input;
	
	public function setInput($input) 
	{
		$this->checkValidInput($input);
		$this->input = $input;
		return $this;
	}
	
	public function getInput()
	{
		if (empty($this->input))
			return 'Empty Set';
		return $this->input;
	}
	
	private function checkValidInput($input)
	{
		if (empty($input))
			return;
		if (!is_numeric($input))
			throw new \InvalidArgumentException;
		if ($input < 0)
			throw new \InvalidArgumentException;
				
		if ($input % 2 !== 0)
			throw new NoteUnavailableException;
	}
	
	public function execute()
	{
		$return = array();
		$input = $this->getInput();
		if (is_string($input))
			return $input;
		if (in_array($input, $this->noteMachine))
			return array($this->format($input));
		
		return $this->calcNote($input);		
	}
	
	private function format($input) 
	{
		return number_format($input, 2);
	}
	
	private function calcNote($input)
	{
		$notes = array();
		$notesPossible = array_filter($this->noteMachine, function($note) use($input) {
			return $note < $input;
		});		
		$max = max($notesPossible);
		if ($input % $max == 0) {
			$qtd = $input / $max;
			for ($i = 0; $i < $qtd; $i++)
			  $notes[] = $this->format($max);
		} else {
			$qtd = count($notesPossible);
			$partial = 0;
			foreach ($notesPossible as $note) {
				if ($partial + $note > $input)
					continue;
				$partial += $note;
				$notes[] = $this->format($note);		
				if ($partial == $input)
					break;
			}
		}
				
		return $notes;
	}
	
}

