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

	$Enigma->addPlug('a', 'c');
	$Enigma->addPlug('d', 'y');
	$Enigma->addPlug('x', 'k');
	$Enigma->addPlug('u', 'w');
	$Enigma->addPlug('z', 'i');
	$Enigma->addPlug('j', 'g');
	$Enigma->addPlug('s', 'l');
	$Enigma->addPlug('q', 'b');
	$Enigma->addPlug('e', 'f');
	$Enigma->addPlug('h', 'm');

	if($decodificar == 0){
		echo  $Enigma->encode($letraClicada);
	}else{
		echo $Enigma->decode($letraClicada);
	}
}