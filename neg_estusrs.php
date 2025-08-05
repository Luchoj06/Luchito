<?php
	include("../bd/conexion.php");
	include("../controladores/clsusuario.php");
	include("../controladores/clsrol.php");
	session_start();
	$iden=$_REQUEST['doc'];
	$est=$_REQUEST['estado'];
	$accion=$_REQUEST['aci'];
	$sqlbus="SELECT*FROM permiso WHERE rol_fk=$est ";
	if (!$result=$db->query($sqlbus)) {
		die("Error en la base de datos !!!! [".$db->error."]");
	}
	$con='0';
	while ($row=$result->fetch_assoc()) {
		$rrol_fk=$row['rol_fk'];
	}
	switch ($accion) {
		case '1':
			//asignacion de los roles en la tabla de permisos de la clase rol
			$ins=new Rol();
			$ins->insercion_roles($iden,$est);
			break;
		case '2':
			$sqlsup="SELECT COUNT(*) FROM permiso WHERE rol_fk='2'";
			if (!$results=$db->query($sqlsup)) {
				die("Error en la base de datos !!!![".$db->error."]");
			}
			while ($row=$results->fetch_assoc()) {
				$num=$row['COUNT(*)'];
			}
			if ($est=='2') {
				if ($num!=1) {
					//eliminacion de los permisos
					$eli=new Usuario();
					$eli->eliminacion_permiso($iden,$est);
				}
				if ($num==1) {
					//mensaje
					header("location:../vistas/neg_estusrs2.php");
					echo "Error no se puede eliminar el rol SUPERADMINISTRADOR del usuario identificado : ";
					echo $iden;
					echo "<br>Intente con otro rol";
					header("refresh:5;url=../vistas/lista_users.php");
				}
			}
			if($est!='2'){
				$eli=new Usuario();
				$eli->eliminacion_permiso($iden,$est);
			}
			
			break;
		default:
			# code...
			break;
	}
	
?>