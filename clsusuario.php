<?php
	class Usuario{
		public function registro_usuario($documento, $pawd, $apellido, $nombre, $correo, $telefono, $jornada) {
			include("../bd/conexion.php");
			$pasword = password_hash($pawd, PASSWORD_DEFAULT);
			$sql = "INSERT INTO usuario VALUES (NULL, '$documento', '$pasword', UPPER('$apellido'), '$correo', '$jornada', '$telefono', UPPER('$nombre'), NULL)";
			mysqli_query($db, $sql) or die(mysqli_error($db));
			$sqli = "INSERT INTO permiso (id_permiso, usuario_fk, rol_fk) VALUES (NULL, '$documento', '1')";
			mysqli_query($db, $sqli) or die(mysqli_error($db));
		}
		
		public function autenticacion_usuario($documento,$password){
			include("../bd/conexion.php");
			include("../controladores/clsrol.php");
			$cont="0";
			session_start();
			$sql="SELECT*FROM usuario WHERE '$documento'=usr_documento";
			//`usuario`(`usr_documento`, `password_usrs`, `apellido_usrs`, `correo_usrs`, `usur_nombre`, `id_usuario`) 
			if (!$result=$db->query($sql)) {
				die("Error en la consulta de la base de datos [".$db->error."]");
			}
			while ($row=$result->fetch_assoc()) {
				$cont=$cont+1;
				$ppasword=$row['password_usrs']; 
				$nnombre=$row['usur_nombre'];
				$pass_temp=$row['pass_temp_usrs'];
			}
			if ($cont=='1') {
				if (password_verify($password,$ppasword)) {
					$_SESSION['nombre']=$nnombre;
					$_SESSION['documento']=$documento;
					 $secu=new Rol();
					 $secu->seguridad($documento);
				} 
				elseif ($password == $pass_temp){

					$_SESSION['nombre']=$nnombre;
					$_SESSION['documento']=$documento;
					 $secu=new Rol();
					 $secu->seguridad($documento);
					 $sql="UPDATE usuario SET pass_temp_usrs=NULL WHERE usr_documento='$documento'";
					 mysqli_query($db,$sql) or die (mysqli_error($db));
				} 
				else {
					header("location:../vistas/inicio_sesion_res.php");
				}
			}
			if ($cont!='1') {
				header("location:../vistas/inicio_sesion_res.php");
			}
		}
		public function actualizacion_usuario($nombre,$apellido,$correo,$telefono,$jornada){
			session_start();
			$documento=$_SESSION['documento'];
			include("../bd/conexion.php");
			$sql="UPDATE usuario SET usur_nombre=UPPER('$nombre'), apellido_usrs=UPPER('$apellido'), correo_usrs='$correo', jornada_usrs='$jornada', phone_usrs='$telefono' WHERE usr_documento='$documento'";
			mysqli_query($db,$sql) or die (mysqli_error($db));
			$sqlb="SELECT usur_nombre from usuario WHERE usr_documento=$documento";
			if (!$result1=$db->query($sqlb)) {
				die("Error en la consulta de la base de datos [".$db->error."]");
			}
			while ($rown=$result1->fetch_assoc()) {
				$nnombre=$rown['usur_nombre'];
			}
			$_SESSION['nombre']=$nnombre;
			 header("location:../vistas/index1.php");
		}
		public function lista_usuarios(){
			include("../bd/conexion.php");
                        	$sql="SELECT*FROM usuario";
                        	if (!$result=$db->query($sql)) {
                        		die("Error en la consulta de base de datos [".$db->error."]");
                        	}
                        	//`usuario`(`usr_documento`, `password_usrs`, `apellido_usrs`, `correo_usrs`, `usur_nombre`, `id_usuario`) 
                        	while ($row = $result->fetch_assoc()) {
								$uusr_documento = $row['usr_documento'];
								$nnombre = $row['usur_nombre'];
								$aapellido = $row['apellido_usrs'];
								$ttelefono = $row['phone_usrs'];
								$jjornada = $row['jornada_usrs'];
						
								echo "<tr>
										<td>$uusr_documento</td>
										<td>$nnombre</td>
										<td>$aapellido</td>
										<td>$ttelefono</td>
										<td>$jjornada</td>
										<td>
											<a href='../vistas/cambioestado_usuario.php?iden=$uusr_documento' class='btn btn-outline-info'>Editar</a></td>
											<td><a href='../controladores/usuario.php?action=eliminar&documento=$uusr_documento' class='btn btn-outline-danger' onclick='return confirm(\"¿Está seguro de que desea eliminar este usuario?\")'>Eliminar</a></td>
										
									  </tr>";
							}
		}
		public function eliminacion_permiso($documento,$permiso){
			//Elimina los permisos de el usuario  
			include("../bd/conexion.php");
			$sql="DELETE FROM permiso WHERE usuario_fk=$documento AND rol_fk=$permiso";
			mysqli_query($db,$sql) or die (mysqli_error($db));
			header("location:../vistas/lista_users.php");
		}
		public function actualzacion_password($documento,$passw1){
			include("../bd/conexion.php");
					//echo $passw1;
					$pasword1=password_hash($passw1, PASSWORD_DEFAULT);
					$sql="UPDATE usuario SET password_usrs='$pasword1' WHERE usr_documento='$documento'";
					mysqli_query($db,$sql) or die (mysqli_error($db));
					header("location:../vistas/index1.php");
			
		}
		public function Recuperar_usuario($documento){
			include("../bd/conexion.php");
			$sql="SELECT*FROM usuario WHERE '$documento'=usr_documento";
			if (!$result=$db->query($sql)) {
				die("Error en la consulta de datos [".$db->error."]");
			}
			while ($row=$result->fetch_assoc()) {
				$ccorreo=$row['correo_usrs'];
				$nnombre=$row['usur_nombre'];
				$caracteres = "abcdefghijklmnopqrstuvwxyz0123456789";
				$cadena = str_shuffle($caracteres);
				$pass_temp= substr($cadena, 0, 7);
				$destinatario = $ccorreo;
				$asunto = "RECUPERACIÓN DE CONTRASEÑA";
				$mensaje = "
				<html>
					<head>
						<title>RECUPERACIÓN DE CONTRASEÑA</title>
					</head>
					<body>
						<p>Buen día.<br>Ha solicitado una nueva contraseña: <strong>$pass_temp</strong><br><strong>¡RECUERDE!</strong> Cuando inicie sesión deberá cambiar la contraseña</p>
					</body>
				</html>
				";
				
				$header = "MIME-Version: 1.0\r\n";
				$header.= "Content-type: text/html; charset=utf-8\r\n";
				$header.= "From: $nnombre <$ccorreo> ";
				$header.= "Return-path: $ccorreo \r\n";
				$mail = mail($destinatario, $asunto, $mensaje, $header);
				if($mail){
					echo "Mail enviado exitosamente";
				}else{
					echo "Error al enviar el correo";
				}

				$sql="UPDATE usuario SET pass_temp_usrs='$pass_temp' WHERE usr_documento='$documento'";
				mysqli_query($db,$sql) or die (mysqli_error($db));
				header("location:../vistas/inicio_sesion.php");
			}
		}
		
		
		
		public function eliminacion_usuario($documento) {
			include("../bd/conexion.php");
			
			// Primero, elimina los permisos del usuario
			$sql = "DELETE FROM permiso WHERE usuario_fk='$documento'";
			mysqli_query($db, $sql) or die(mysqli_error($db));
			
			// Luego, elimina el usuario
			$sql = "DELETE FROM usuario WHERE usr_documento='$documento'";
			mysqli_query($db, $sql) or die(mysqli_error($db));
			
			header("location:../vistas/lista_users.php");
		}
		
	}
?>