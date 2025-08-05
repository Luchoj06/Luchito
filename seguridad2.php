<?php
	session_start();
	if ($_SESSION['superadmin']!='1') {
		header("location:../controladores/salir.php");
	}
?>