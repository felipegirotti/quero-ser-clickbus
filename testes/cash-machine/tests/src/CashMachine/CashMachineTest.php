<?php

namespace CashMachine;

use PHPUnit_Framework_TestCase;

class CashMachineTest extends PHPUnit_Framework_TestCase
{
	
	/**
	 *
	 * @var \CashMachine\CashMachine
	 */
	protected $cashMachine;
	
	public function setUp() 
	{
		$this->cashMachine = new CashMachine();
	}
	
	/**
     * @expectedException \InvalidArgumentException
     */
	public function testSholdBeInputInvalidString()
	{
		$input = 'something';
		$this->cashMachine->setInput($input);
	}
	
	/**
     * @expectedException \InvalidArgumentException
     */
	public function testSholdBeInputInvalidLessZero()
	{
		$input = -1;
		$this->cashMachine->setInput($input);
	}
	
	/**
     * @expectedException \CashMachine\NoteUnavailableException
     */
	public function testSholdBeInputInvalidNote()
	{
		$input = 125;
		$this->cashMachine->setInput($input);
	}
		
	public function testSholdBeInputEmpty()
	{		
		$this->cashMachine->setInput(null);
		$this->assertEquals('Empty Set', $this->cashMachine->getInput());
	}
	
	public function testSholdBeInputValid()
	{
		$input = 120;
		$cashMachine = $this->cashMachine->setInput($input);
		$this->assertTrue($cashMachine instanceof \CashMachine\CashMachine);
	}
	
	public function testSholdBeOneNote()
	{
		$input = 10;
		$notes = $this->cashMachine->setInput($input)
							->execute();
		$expected = array(10.00);
		$this->assertEquals($expected, $notes);
	}
	
	public function testSholdBeLessNote30()
	{
		$input = 30;
		$notes = $this->cashMachine->setInput($input)
							->execute();
		$expected = array(20.00, 10.00);
		$this->assertEquals($expected, $notes);
	}
	
	public function testSholdBeLessNote80()
	{
		$input = 80;
		$notes = $this->cashMachine->setInput($input)
							->execute();
		$expected = array(50.00, 20.00, 10.00);
		$this->assertEquals($expected, $notes);
	}
	
	public function testSholdBeReturnEmpty()
	{
		$input = 0;
		$notes = $this->cashMachine->setInput($input)
							->execute();		
		$this->assertEquals('Empty Set', $notes);
	}
	
}

