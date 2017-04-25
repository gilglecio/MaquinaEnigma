<?php
ob_start();
session_start();
	if(isset($_POST['rotoresAdd'])){
		unset($_SESSION['rotors']);

		$_SESSION['rotoresArray'] = $_POST['rotoresAdd'];
		echo 'ok';
		exit;
	}
?>