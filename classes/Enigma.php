<?php

class Enigma
{
	/**
	 * Rotor 1 initial value
	 * @var integer
	 */
	public $initRotorOne;

	/**
	 * Rotor 2 initial value
	 * @var integer
	 */
	public $initRotorTwo;

	/**
	 * Rotor 3 initial value
	 * @var integer
	 */
	public $initRotorThree;

	/**
	 * Alphabet
	 * @var array
	 */
	private $alphabet = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];

	/**
	 * Plugs
	 * @var array
	 */
	private $plugs = [];

	/**
	 * Rotor one alphabet
	 * @var array
	 */
	private $rotorOne = [];

	/**
	 * Rotor one alphabet
	 * @var array
	 */
	private $rotorTwo = [];

	/**
	 * Rotor one alphabet
	 * @var array
	 */
	private $rotorThree = [];

	/**
	 * Initialize rotores
	 * 
	 * @param array $rotorOne  
	 * @param array $rotorTwo  
	 * @param array $rotorThree
	 */
	public function __construct($rotorOne = [], $rotorTwo = [], $rotorThree = [])
	{
		$this->setRotorOne($rotorOne);
		$this->setRotorTwo($rotorTwo);
		$this->setRotorThree($rotorThree);
	}

	/**
	 * To add plugs
	 * 
	 * @param string $char1
	 * @param string $char2
	 */
	public function addPlug($char1, $char2)
	{
		$this->plugs[$char2] = $char1;
	}

	public function setRotorOne(array $rotor)
	{
		$this->rotorOne = count($rotor) > 0 ? $rotor : $this->generateRotor();
	}

	public function setRotorTwo(array $rotor)
	{
		$this->rotorTwo = count($rotor) > 0 ? $rotor : $this->generateRotor();
	}

	public function setRotorThree(array $rotor)
	{
		$this->rotorThree = count($rotor) > 0 ? $rotor : $this->generateRotor();
	}

	public function getRotorOne()
	{
		return $this->rotorOne;
	}

	public function getRotorTwo()
	{
		return $this->rotorTwo;
	}

	public function getRotorThree()
	{
		return $this->rotorThree;
	}

	public function getRandChar()
	{
		return $this->alphabet[rand(0,25)];
	}

	public function getChars()
	{
		$chars = [];
		$i = 0;
		
		while($i <= 25) {

			$indice = $this->getRandChar();

			if ( ! in_array($indice, $chars)) {
				$chars[] = $indice;
				$i++;
			}
		}

		return $chars;
	}

	public function generateRotor()
	{
		return $this->getChars();
	}

	public function getIndByChar($char, $rotor)
	{
		return array_search($char, $rotor);
	}

	public function getMath($charInput, $initRotorOne, $initRotorTwo, array $rotorTwo)
	{
		if ($charInput > $initRotorOne) {

			$match = $initRotorTwo + ($charInput - $initRotorOne);

			if ($match > (count($rotorTwo)-1)) {
				$match = ($match - (count($rotorTwo) - 1)) - 1;
			}

			return $rotorTwo[$match];
		}

		if ($charInput < $initRotorOne) {

			$match = $initRotorTwo - ($initRotorOne - $charInput);

			if ($match < 0) {
				$match = ($match * (-1)) - 1;
				$rotorTwo = array_reverse($rotorTwo);
			}

			return $rotorTwo[$match];
		}

		$match = $initRotorTwo;

		return $rotorTwo[$match];
	}

	public function getCharByPlugs($char)
	{
		if ( ! count($this->plugs)) {
			return $char;
		}
		
		if ($search = array_search($char, $this->plugs)) {
			return $search;
		}
		
		if (in_array($char, array_keys($this->plugs))) {
			return $this->plugs[$char];
		}

		return $char;
	}

	public function encode($charInput) 
	{
		$charInput = $this->getCharByPlugs($charInput);
		$charIndice = $this->getIndByChar($charInput, $this->getRotorOne());

		$charMatch = $this->getMath($charIndice, $this->initRotorOne, $this->initRotorTwo, $this->getRotorTwo());
		
		$indiceCharRotorTwo = $this->getIndByChar($charMatch, $this->getRotorTwo());

		$charMatch = $this->getMath($indiceCharRotorTwo, $this->initRotorTwo, $this->initRotorThree, $this->getRotorThree());
		
		return $charMatch;
	}

	public function decode($charInput)
	{
		$charIndice = $this->getIndByChar($charInput, $this->getRotorThree());

		$charMatch = $this->getMath($charIndice, $this->initRotorThree, $this->initRotorTwo, $this->getRotorTwo());
		$indiceCharRotorTwo = $this->getIndByChar($charMatch, $this->getRotorTwo());

		$charOutput = $this->getMath($indiceCharRotorTwo, $this->initRotorTwo, $this->initRotorOne, $this->getRotorOne());
		
		$charOutput = $this->getCharByPlugs($charOutput);

		return $charOutput;
	}
}