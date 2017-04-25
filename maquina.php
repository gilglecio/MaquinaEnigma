<?php
	ob_start();
	session_start();

	include 'classes/Enigma.php';
	$rotors = $_SESSION['rotoresArray'];
?>
<!DOCTYPE HTML>
<html lang="pt-BR">
	<head>
		<meta charset=UTF-8>
		<title>Maquina Enigma</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/functions.js"></script>
	</head>

	<body>
		<div id="enigma_box">
			<div class="line">
				
				<div class="rotores">
					<?php foreach (array_reverse($rotors, true) as $key => $value): ?>
					<label><span>Rotor <?php echo $key+1 ?></span> <input type="text" name="rotor<?php echo $key+1 ?>" id="r<?php echo $key+1 ?>" value="<?php echo $value ?>" class="inputRotor"/></label>
					<?php endforeach ?>
				</div>
			</div>

			<div class="line">
				<textarea id="text" placeholder="Texto" rows="7"></textarea>
			</div>
			<div class="line controles">
				<p>Adicionar plugs <input type="checkbox" id="addplug" /></p>
				<p>Descriptografar <input type="checkbox" id="decript" /></p>
				<input type="button" value="Remover Plugs" id="removePlugs" />
			</div>
			<div class="line last">
				<?php
					$abc = Enigma::$alphabet;
					for($i = 0; $i<=count($abc)-1; $i++){
						echo '<a href="#" class="letra" id="'.$abc[$i].'">'.strtoupper($abc[$i]).'</a>';
					}
				?>
			</div>
			<form action="" method="post" style="display:none;" id="meusPlugs">
				<select name="plugsCriados">
					
				</select>
			</form>

			<button id="iniciar">Iniciar</button>

			<p id="rotors" data-rotors='<?php echo json_encode($rotors) ?>'></p>
			<div style="clear:both;"></div>
		</div>
	</body>
</html>