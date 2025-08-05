<?php
include("../controladores/clsAlumno.php");

// Verifica que la solicitud sea un POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoge los datos del formulario
    $documento = $_POST['documento'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$curso = $_POST['curso'];
$jornada = $_POST['jornada'];

// Crea una instancia de la clase Estudiante y llama al método de actualización
$estudiante = new Estudiante();
$estudiante->actualizar_estudiante($documento, $nombre, $apellido, $curso, $jornada);
}
?>
