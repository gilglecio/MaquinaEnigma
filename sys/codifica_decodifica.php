<?php
ob_start();
session_start();

if(isset($_POST['decodificar'])){
	
	require_once('../classes/Enigma.php');
	
	$Enigma = new Enigma($_POST['initRotors']);

	if ( ! isset($_SESSION['rotors'])) {
		$_SESSION['rotors'] = $Enigma->getRotors();
	} else {
		$Enigma->setRotors($_SESSION['rotors']);
	}
	$letraClicada = $_POST['letraClicada'];
	$decodificar = $_POST['decodificar'];
	if(isset($_SESSION['plugsCriados'])){
		foreach($_SESSION['plugsCriados'] as $a => $b){
			$Enigma->addPlug($a, $b);
		}
	}

	if($decodificar == 0){
		echo  $Enigma->encode($letraClicada);
	}else{
		echo $Enigma->decode($letraClicada);
	}
}