<?php  
	include("../controladores/clsusuario.php");
	$veri=new Usuario();
	$veri->Recuperar_usuario($documento=$_POST['documento']);
?>  