<?php 
    include('../controladores/clsusuario.php');
    $act=new Usuario();
    $act->actualizacion_usuario($_POST['nombre'],$_POST['apellido'],$_POST['correo'],$_POST['telefono'],$_POST['jornada']);
   
 ?>