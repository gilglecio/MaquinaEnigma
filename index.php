<?php 
	ob_start();
	session_start();
?>
<!DOCTYPE HTML>
<html lang="pt-BR">
	<head>
		<meta charset=UTF-8>
		<title>Maquina Enigma</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="//code.jquery.com/jquery-1.11.2.min.js"></script>
		<script type="text/javascript" src="js/functions.js"></script>
	</head>

	<body>
		<div id="enigma_box">
			<div class="line">
				<div class="descrip">Descriptografar <input type="checkbox" id="decript" /></div>
				<div class="rotores">
					<label>Rotor 3 <input type="text" name="rotor3" id="r3" value="5"/></label>
					<label>Rotor 2 <input type="text" name="rotor3" id="r2" value="8"/></label>
					<label>Rotor 1 <input type="text" name="rotor3" id="r1" value="22"/></label>
				</div>
			</div>

			<div class="line">
				<span id="result">Resultado: <span class="resultado"></span></span>
			</div>
			<div class="line last">
				<?php
					$abc = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
					for($i = 0; $i<=count($abc)-1; $i++){
						echo '<a href="#" class="letra" id="'.$abc[$i].'">'.strtoupper($abc[$i]).'</a>';
					}
				?>
			</div>

			<div class="line">
				<pre>
					<?php
						/*require_once('classes/Enigma.class.php');
						$enigma = new Enigma();
						$_SESSION['r1'] = $enigma->getRotorUm();
						$_SESSION['r2'] = $enigma->getRotorDois();
						$_SESSION['r3'] = $enigma->getRotorTres();*/

						print_r($_SESSION);
					?>
				</pre>
			</div>
			<div style="clear:both;"></div>
		</div>
	</body>
</html>