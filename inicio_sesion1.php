<?php  
	include("../controladores/clsusuario.php");
	$veri=new Usuario();
	$veri->autenticacion_usuario($documento=$_POST['documento'],$password=$_POST['password']);
?>