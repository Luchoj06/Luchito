<?php
include("../controladores/clsAlumno.php");
include("../bd/conexion.php");

$documento = $_POST['documento'];

$estudiante = new Estudiante();
$estudiante->registrar_almuerzo($documento);
?>
