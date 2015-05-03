<?php
	ob_start();
	session_start();

	if(isset($_POST['decodificar'])){
		
		require_once('../classes/Enigma.php');
		
		$Enigma = new Enigma($_SESSION['r1'], $_SESSION['r2'], $_SESSION['r3']);

		$r1 = $_POST['r1'];
		$r2 = $_POST['r2'];
		$r3 = $_POST['r3'];

		$letraClicada = $_POST['letraClicada'];
		$decodificar = $_POST['decodificar'];

		$Enigma->initRotorUm = $r1;
		$Enigma->initRotorDois = $r2;
		$Enigma->initRotorTres = $r3;

		$Enigma->addPlug('i', 'c');
		$Enigma->addPlug('d', 'y');
		$Enigma->addPlug('x', 'k');
		$Enigma->addPlug('u', 'w');
		$Enigma->addPlug('z', 'a');
		$Enigma->addPlug('j', 'l');
		$Enigma->addPlug('f', 'e');
		$Enigma->addPlug('q', 'b');
		$Enigma->addPlug('g', 's');
		$Enigma->addPlug('h', 'm');

		if($decodificar == 0){
			echo  $Enigma->encode($letraClicada);
		}else{
			echo $Enigma->decode($letraClicada);
		}
	}
?>