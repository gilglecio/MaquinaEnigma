<?php
	class Enigma{
		public $configuracaoRotorUm;
		public $configuracaoRotorDois;
		public $configuracaoRotorTres;
		private $abc = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
		private $plugs = array();

		private $rotorUm = array();
		private $rotorDois = array();
		private $rotorTres = array();

		public function __construct($rotUm = array(), $rotDois = array(), $rotTres = array()){
			$this->setRotorUm($rotUm);
			$this->setRotorDois($rotDois);
			$this->setRotorTres($rotTres);
		}

		public function addPlug($letra1, $letra2){
			$this->plugs[$letra2] = $letra1;
		}

		public function setRotorUm($arrRotor){
			if(count($arrRotor) > 0){
				$this->rotorUm = $arrRotor;
			}else{
				$this->rotorUm = $this->geraRotor();
			}
		}

		public function setRotorDois($arrRotor){
			if(count($arrRotor) > 0){
				$this->rotorDois = $arrRotor;
			}else{
				$this->rotorDois = $this->geraRotor();
			}
		}

		public function setRotorTres($arrRotor){
			if(count($arrRotor) > 0){
				$this->rotorTres = $arrRotor;
			}else{
				$this->rotorTres = $this->geraRotor();
			}
		}


		public function getRotorUm(){
			return $this->rotorUm;
		}

		public function getRotorDois(){
			return $this->rotorDois;
		}

		public function getRotorTres(){
			return $this->rotorTres;
		}

		public function retornaLetra(){
			return $this->abc[rand(0,25)];
		}

		public function geraArrayRandomico(){
			$array = array();
			$i = 0;
			while($i <= 25){
				$indiceNovo = $this->retornaLetra();
				if(in_array($indiceNovo, $array)){
					$indiceNovo = $this->retornaLetra();
				}else{
					$array[] = $indiceNovo;
					$i++;
				}
			}

			return $array;
		}

		public function geraRotor(){
			return $this->geraArrayRandomico();
		}

		public function retornaIndiceLetra($letra, $rotor){
			return array_search($letra, $rotor);
		}

		public function retornaMatch($indiceEntrada, $inicioRotorUm, $inicioRotorDois, array $arrayRotorDois){
			if($indiceEntrada > $inicioRotorUm){
				$calculoUm = $indiceEntrada-$inicioRotorUm;
				$match = $inicioRotorDois+$calculoUm;

				if($match > (count($arrayRotorDois)-1) ){
					$match = $match-(count($arrayRotorDois)-1);
					$match = $match-1;
				}
			}elseif($indiceEntrada < $inicioRotorUm){
				$calculoUm = $inicioRotorUm-$indiceEntrada;
				$match = $inicioRotorDois-$calculoUm;
				if($match < 0){
					$match = ($match*(-1))-1;
					$arrayRotorDois = array_reverse($arrayRotorDois);
				}
			}elseif($indiceEntrada == $inicioRotorUm){
				$match = $inicioRotorDois;
			}

			return $arrayRotorDois[$match];
		}

		public function codifica($letraEntrada){
			if(count($this->plugs) > 0){
				if(array_search($letraEntrada, $this->plugs)){
					$letraEntrada = array_search($letraEntrada, $this->plugs);
				}elseif(in_array($letraEntrada, array_keys($this->plugs))){
					$letraEntrada = $this->plugs[$letraEntrada];
				}
			}

			$pegaIndice = $this->retornaIndiceLetra($letraEntrada, $this->getRotorUm());
			$letraMatch = $this->retornaMatch($pegaIndice, $this->configuracaoRotorUm, $this->configuracaoRotorDois, $this->getRotorDois());
			$indiceLetraRotorDois = $this->retornaIndiceLetra($letraMatch, $this->getRotorDois());

			$letraSaida = $this->retornaMatch($indiceLetraRotorDois, $this->configuracaoRotorDois, $this->configuracaoRotorTres, $this->getRotorTres());
			
			return $letraSaida;
		}

		public function decodifica($letraEntrada){
			$pegaIndice = $this->retornaIndiceLetra($letraEntrada, $this->getRotorTres());

			$letraMatch = $this->retornaMatch($pegaIndice, $this->configuracaoRotorTres, $this->configuracaoRotorDois, $this->getRotorDois());
			$indiceLetraRotorDois = $this->retornaIndiceLetra($letraMatch, $this->getRotorDois());

			$letraSaida = $this->retornaMatch($indiceLetraRotorDois, $this->configuracaoRotorDois, $this->configuracaoRotorUm, $this->getRotorUm());
			
			if(count($this->plugs) > 0){
				if(array_search($letraSaida, $this->plugs)){
					$letraSaida = array_search($letraSaida, $this->plugs);
				}elseif(in_array($letraSaida, array_keys($this->plugs))){
					$letraSaida = $this->plugs[$letraSaida];
				}
			}
			return $letraSaida;
		}
	}
?>