<?php
class Estudiante {
    public function registrar_estudiante($documento, $nombre, $apellido, $curso, $jornada) {
    include("../bd/conexion.php");
    $sql = "INSERT INTO alumno (documento, Nombre, Apellido, curso, jornada) VALUES ('$documento', UPPER('$nombre'), UPPER('$apellido'), '$curso', '$jornada')";
    mysqli_query($db, $sql) or die(mysqli_error($db));
    $id = mysqli_insert_id($db);
    $codigo = $id . date('is');
    $sql = "UPDATE alumno SET codigo = '$codigo' WHERE id_alumno = '$id'";
    mysqli_query($db, $sql) or die(mysqli_error($db));
    $sql_info = "SELECT * FROM alumno WHERE id_alumno = '$id'";
    $result = mysqli_query($db, $sql_info);
    }

    public function registrar_almuerzo($documento) {
        include("../bd/conexion.php");
        $sql = "SELECT id_alumno FROM alumno WHERE documento='$documento'";
        $result = mysqli_query($db, $sql) or die(mysqli_error($db));
        $row = mysqli_fetch_assoc($result);
        $estudiante_id = $row['id_alumno'];
       
        if(isset($estudiante_id)){
                
        
        $fecha_hoy = date('Y-m-d ');
        $sql = "SELECT * FROM comedor WHERE id_alumno='$estudiante_id' AND fecha_hora='$fecha_hoy'";
        $sql2="SELECT*FROM usuario INNER JOIN comedor ON comedor.usuario_fk=usuario.id_usuario  WHERE '$estudiante_id= id_alumno";
        $result = mysqli_query($db, $sql) or die(mysqli_error($db));

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $contador = $row['contador'];
            
            if ($contador >= 1) {
                echo "<script>alert('Este estudiante ya se alimento.'); window.location.href='../vistas/contador.php';</script>";
            } else {
                $contador++;
                $sql = "UPDATE comedor SET contador='$contador' WHERE id_alumno='$estudiante_id' AND fecha_hora='$fecha_hoy'";
                mysqli_query($db, $sql) or die(mysqli_error($db));
                echo "<script>alert('Estudiante registrado correctamente.'); window.location.href='../vistas/contador.php';</script>";
            }
        } else {
            $sql = "INSERT INTO comedor (id_alumno, fecha_hora, contador) VALUES ('$estudiante_id', '$fecha_hoy', 1)";
            mysqli_query($db, $sql) or die(mysqli_error($db));
            echo "<script>alert('Estudiante registrado correctamente.'); window.location.href='../vistas/contador.php';</script>";
            
            
        }
    }
    else{
        echo "<script>alert('El estudiante no se encuentra en la base de datos.'); window.location.href='../vistas/contador.php';</script>";

    }
    }

    

    public function actualizar_estudiante($documento, $nombre, $apellido, $curso, $jornada) {
        include("../bd/conexion.php");

       
        $sql = "UPDATE alumno SET Nombre=UPPER('$nombre'), Apellido=UPPER('$apellido'), curso='$curso', jornada='$jornada' WHERE documento='$documento'";
        
      
        if (mysqli_query($db, $sql)) {
            echo "<script>alert('Datos actualizados correctamente.'); window.location.href='../vistas/lista_alumno.php';</script>";
        } else {
            echo "<script>alert('Error al actualizar los datos.'); window.location.href='../vistas/editar_estudiante.php?documento=$documento';</script>";
        }
    }

    public function eliminar_estudiante($documento) {
        include("../bd/conexion.php");

       
        $sql = "DELETE FROM comedor WHERE id_alumno IN (SELECT id_alumno FROM alumno WHERE documento='$documento')";
        mysqli_query($db, $sql) or die(mysqli_error($db));
  
        $sql = "DELETE FROM alumno WHERE documento='$documento'";
        mysqli_query($db, $sql) or die(mysqli_error($db));
        
        echo "<script>alert('Estudiante eliminado correctamente.'); window.location.href='../vistas/lista_alumno.php';</script>";
    }

    public function registrar_por_codigo_barras($codigo_barras) {
        include("../bd/conexion.php");
    
        // Buscar el alumno por el código de barras
        $sql = "SELECT id_alumno FROM alumno WHERE codigo = '$codigo_barras'";
        $result = mysqli_query($db, $sql) or die(mysqli_error($db));
    
        if ($row = mysqli_fetch_assoc($result)) {
            $id_alumno = $row['id_alumno'];
    
            // Obtener la fecha de hoy
            $fecha_hoy = date('Y-m-d');
    
            // Verificar si el alumno ya ha registrado un almuerzo hoy
            $sql = "SELECT * FROM comedor WHERE id_alumno = '$id_alumno' AND fecha_hora = '$fecha_hoy'";
            $result = mysqli_query($db, $sql) or die(mysqli_error($db));
    
            if (mysqli_num_rows($result) > 0) {
                // Si ya está registrado hoy, aumentar el contador
                $row = mysqli_fetch_assoc($result);
                $contador = $row['contador'];
    
                if ($contador >= 1) {
                    echo "<script>alert('Este estudiante ya se alimentó hoy.'); window.location.href='../vistas/contador.php';</script>";
                } else {
                    $contador++;
                    $sql = "UPDATE comedor SET contador = '$contador' WHERE id_alumno = '$id_alumno' AND fecha_hora = '$fecha_hoy'";
                    mysqli_query($db, $sql) or die(mysqli_error($db));
                    echo "<script>alert('Registro actualizado correctamente.'); window.location.href='../vistas/contador.php';</script>";
                }
            } else {
                // Si no está registrado hoy, insertar un nuevo registro
                $sql = "INSERT INTO comedor (id_alumno, fecha_hora, contador) VALUES ('$id_alumno', '$fecha_hoy', 1)";
                mysqli_query($db, $sql) or die(mysqli_error($db));
                echo "<script>alert('Estudiante registrado correctamente.'); window.location.href='../vistas/contador.php';</script>";
            }
        } else {
            // Si no se encuentra el código de barras en la base de datos
            echo "<script>alert('Código de barras no encontrado.'); window.location.href='../vistas/contador.php';</script>";
        }
    }
    
}
?>
