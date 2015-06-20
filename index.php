<?php 
	ob_start();
	session_start();

	//$rotors = [5,6,12,8,7,10,15,2,9,1];
	$rotors = [5,6,12];
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

			<p id="rotors" data-rotors="<?php echo json_encode($rotors) ?>"></p>
			<div style="clear:both;"></div>
		</div>
	</body>
</html>