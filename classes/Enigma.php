<?php

class Enigma
{
	/**
	 * Rotors init
	 * @var array
	 */
	public $initRotors = [];

	/**
	 * Alphabet
	 * @var array
	 */
	static $alphabet = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];

	/**
	 * Plugs
	 * @var array
	 */
	private $plugs = [];

	/**
	 * Rotors alphabet
	 * @var array
	 */
	private $rotors = [];

	/**
	 * Initialize rotores
	 * 
	 * @param array $rotorOne  
	 * @param array $rotorTwo  
	 * @param array $rotorThree
	 */
	public function __construct(array $initRotors, $rotors = [])
	{
		$this->initRotors = $initRotors;
		$this->setRotors($rotors);
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

	public function setRotors(array $rotors)
	{
		$this->rotors = count($rotors) > 0 ? $rotors : $this->generateRotors();
	}

	public function getRotors($key = null)
	{
		if ( ! is_null($key)) {
			return $this->rotors[$key];
		}

		return $this->rotors;
	}

	public function getRandChar()
	{
		return self::$alphabet[rand(0,25)];
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

	public function generateRotors()
	{
		$rotors = [];

		for ($i=0; $i < count($this->initRotors); $i++) { 
			$rotors[] = $this->getChars();
		}

		return $rotors;
	}

	public function getIndByChar($char, $rotor)
	{
		return array_search($char, $rotor);
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

	public function encode($charInput) 
	{
		$charInput = $this->getCharByPlugs($charInput);

		for ($i=0; $i < count($this->initRotors)-1; $i++) {
			$charIndice = $this->getIndByChar($charInput, $this->getRotors($i));
			$charInput = $this->getMath($charIndice, $this->initRotors[$i], $this->initRotors[$i+1], $this->getRotors($i+1));
		}
		
		return $charInput;
	}

	public function decode($charInput)
	{
		for ($i = (count($this->initRotors) - 1); $i > 0; $i--) {
		
			$charIndice = $this->getIndByChar($charInput, $this->getRotors($i));
			$charInput = $this->getMath($charIndice, $this->initRotors[$i], $this->initRotors[$i-1], $this->getRotors($i-1));
		}
		
		$charOutput = $this->getCharByPlugs($charInput);

		return $charOutput;
	}
}