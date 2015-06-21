<?php
	ob_start();
	session_start();

	include 'classes/Enigma.php';

	$rotors = [5,6,12];
	//$rotors = [5,6,12];
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
					<?php foreach (array_reverse($rotors, true) as $key => $value): ?>
					<label>Rotor <?php echo $key+1 ?> <input type="text" name="rotor<?php echo $key+1 ?>" id="r<?php echo $key+1 ?>" value="<?php echo $value ?>" class="inputRotor"/></label>
					<?php endforeach ?>
				</div>
			</div>

			<div class="line">
				<textarea id="text" placeholder="Texto" style="width:100%" rows="7"></textarea>
			</div>
			<div class="line last">
				<?php
					$abc = Enigma::$alphabet;
					for($i = 0; $i<=count($abc)-1; $i++){
						echo '<a href="#" class="letra" id="'.$abc[$i].'">'.strtoupper($abc[$i]).'</a>';
					}
				?>
			</div>

			<button id="iniciar">Iniciar</button>

			<p id="rotors" data-rotors="<?php echo json_encode($rotors) ?>"></p>
			<div style="clear:both;"></div>
		</div>
	</body>
</html>