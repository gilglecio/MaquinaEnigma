<?php
	session_start();
	//print_r($_SESSION);
?>
<html lang="pt-BR">
	<head>
		<meta charset=UTF-8>
		<title>Maquina Enigma</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/functions.js"></script>
	</head>

	<body>
		<div id="configura-rotores">
			<h2>Configure os rotores <a href="#" class="more">+</a></h2>

			<form action="" method="post" enctype="multipart/form-data">
				<label>
					<span>Rotor 1</span>
					<input type="text" name="r1" id="r1" class="rotorAdd" value="1" maxlength="2"/>
				</label>
				<div id="maisRotores"></div>
			</form>
			<div style="float:left; width:100%;"></div>
			<input type="button" class="botao" id="add" value="Criar rotores" />

			<div style="clear:both;"></div>
		</div>
	</body>
</html>