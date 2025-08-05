<?php
include("../controladores/clsAlumno.php");

if (isset($_GET['documento'])) {
    $documento = $_GET['documento'];

    $estudiante = new Estudiante();
    $estudiante->eliminar_estudiante($documento);
}
?>
