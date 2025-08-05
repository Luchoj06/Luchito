<?php  
	session_start(); 
	$password1=$_POST['pass1'];
	$password2=$_POST['pass2']; 
	$documento=$_SESSION['documento']; 
	include("../db/conexion.php");
	include("../controladores/clsusuario.php"); 
	$ps=new Usuario();
	$ps-> actualzacion_password($documento,$password2);
		
?>