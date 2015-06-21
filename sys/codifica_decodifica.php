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

	$Enigma->addPlug('A', 'C');
	$Enigma->addPlug('D', 'Y');
	$Enigma->addPlug('X', 'K');
	$Enigma->addPlug('U', 'W');
	$Enigma->addPlug('Z', 'I');
	$Enigma->addPlug('J', 'G');
	$Enigma->addPlug('S', 'L');
	$Enigma->addPlug('Q', 'B');
	$Enigma->addPlug('E', 'F');
	$Enigma->addPlug('H', 'M');

	if($decodificar == 0){
		echo strtoupper($Enigma->encode($letraClicada));
	}else{
		echo strtoupper($Enigma->decode($letraClicada));
	}
}