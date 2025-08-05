<?php
    include("../controladores/clsusuario.php");

    $usuario = new Usuario();

    if (isset($_GET['action']) && $_GET['action'] == 'eliminar' && isset($_GET['documento'])) {
        $documento = $_GET['documento'];
        $usuario->eliminacion_usuario($documento);
    } else {
        header("location:../vistas/lista_users.php");
    }
?>
