<?php
	ob_start();
	session_start();

	if(isset($_POST['decodificar'])){
		require_once('../classes/Enigma.class.php');
		$enigma = new Enigma($_SESSION['r1'], $_SESSION['r2'], $_SESSION['r3']);

		$r1 = $_POST['r1'];
		$r2 = $_POST['r2'];
		$r3 = $_POST['r3'];
		$letraClicada = $_POST['letraClicada'];
		$decodificar = $_POST['decodificar'];

		$enigma->configuracaoRotorUm = $r1;
		$enigma->configuracaoRotorDois = $r2;
		$enigma->configuracaoRotorTres = $r3;

		$enigma->addPlug('a', 'c');
		$enigma->addPlug('d', 'y');
		$enigma->addPlug('x', 'k');
		$enigma->addPlug('u', 'w');
		$enigma->addPlug('z', 'i');
		$enigma->addPlug('j', 'g');
		$enigma->addPlug('s', 'l');
		$enigma->addPlug('q', 'b');
		$enigma->addPlug('e', 'f');
		$enigma->addPlug('h', 'm');

		if($decodificar == 0){
			echo  $enigma->codifica($letraClicada);
		}else{
			echo $enigma->decodifica($letraClicada);
		}
	}
?>