<?php
	ob_start();
	session_start();
	
	if(isset($_POST['plugsCriados'])){
		$_SESSION['plugsCriados'] = $_POST['plugsCriados'];
	}
?>