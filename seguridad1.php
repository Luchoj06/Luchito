<?php 
	session_start();
	if ($_SESSION['usuario']!=1) {
		header("location:../controladores/salir.php");
	}
?>