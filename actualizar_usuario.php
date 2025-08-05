<?php
include("../controladores/clsUsuario.php");

// Verifica que la solicitud sea un POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoge los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $jornada = $_POST['jornada'];

    // Crea una instancia de la clase Usuario
    $usuario = new Usuario();
    
    // Llama al método de actualización
    $usuario->actualizar_usuario($nombre, $apellido, $correo, $telefono, $jornada);
}
?>
