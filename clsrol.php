<?php
	class Rol{
		public function seguridad($documento) {
			include("../bd/conexion.php");
			$sql = "SELECT * FROM permiso WHERE usuario_fk='$documento'";
			if (!$result = $db->query($sql)) {
				die("Error en la consulta de datos [" . $db->error . "]");
			}
			while ($row = $result->fetch_assoc()) {
				$rrol_fk = $row['rol_fk'];
				switch ($rrol_fk) {
					case '1':
						$_SESSION['usuario'] = '1';
						break;
					case '2':
						$_SESSION['superadmin'] = '1';
						break;
					case '3':
						$_SESSION['admin'] = '1';
						break;
					default:
						header("refresh:2;url=../index.php");
						break;
				}
				header("location:../vistas/index1.php");
			}
		}
		
		public function accesos($documento){
			include("../bd/conexion.php");
			$sql="SELECT*FROM permiso INNER JOIN rol ON permiso.rol_fk=rol.id_rol WHERE '$documento'=usuario_fk";
			//INSERT INTO rol(id_rol, rol_nombre)
			if (!$result=$db->query($sql)) {
				die("Error en la consulta de datos[".$db->error."]");
			}
			while ($row=$result->fetch_assoc()) {
				$iid_rol=$row['id_rol'];
				$rrol_nombre=$row['rol_nombre'];
				switch ($iid_rol) {
					case '1':
						echo "<a class='dropdown-item' href='../vistas/index1.php'>$rrol_nombre</a>";
					break;
					case '2':
						echo "<a class='dropdown-item' href='../vistas/superadmin.php'>$rrol_nombre</a>";
					break;
					case '3':
						echo "<a class='dropdown-item' href='../vistas/admin.php'>$rrol_nombre</a>";
					break;
					default:
						# code...
					break;
				}
			}
		}
		public function rol_asignados($documento){
			include("../bd/conexion.php");
			$sqlr="SELECT*FROM rol";
			if (!$result_r=$db->query($sqlr)) 
			{
				die("Error en la consulta de los datos [".$db->error."]");
			}
			echo "<table class='table'>
					<thead class='thead-dark'>
						<tr>
							<th>Roles</th>
							<th>Accion</th>
					
						</tr>
					</thead>
			";
			//INSERT INTO `rol`(`id_rol`, `rol_nombre`)
			while ($rows=$result_r->fetch_assoc()) 
			{  
				$rrol=$rows['rol_nombre'];
				$iid_rol=$rows['id_rol'];
				$sqls="SELECT*FROM permiso WHERE $documento=usuario_fk AND rol_fk=$iid_rol";
				if (!$result_s=$db->query($sqls)) 
				{
					die("Error en la consulta de los datos [".$db->error."]");
				}
				
				while ($row_s=$result_s->fetch_assoc()) 
				{
					$rrol_fk=$row_s['rol_fk'];
				}
				if($iid_rol!=1){
				
				echo"<tr><td>$rrol</td>";
				//INSERT INTO `permiso`(`id_permiso`, `usuario_fk`, `rol_fk`)
				
				echo "<td>";		
				if ($iid_rol==$rrol_fk) {
						echo "<a href='../controladores/neg_estusrs.php?estado=$iid_rol&aci=2&doc=$documento ' class='btn btn-danger'  >Desactivar</a>";
				}
				if ($iid_rol!=$rrol_fk) {
					echo "<a href='../controladores/neg_estusrs.php?estado=$iid_rol&aci=1&doc=$documento ' class='btn btn-success' >Activar</a>";
				}
				echo "</td>";
				echo "</tr>";
			} 
				
			}
			echo"</table>";
		}
		public function insercion_roles($documento,$est){
			include("../bd/conexion.php");
				//se inserta los datos en la tabla permisos
			$sql="INSERT INTO permiso(id_permiso,usuario_fk,rol_fk) VALUES (NULL,$documento,$est)";
			mysqli_query($db,$sql) or die (mysqli_error($db));
			header("location:../vistas/lista_users.php");
		}
	}
?>