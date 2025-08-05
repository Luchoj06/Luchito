<?php include("../controladores/seguridad2.php");
      include('../layout/visuales/css.php');
?>

   

<title>SiceSoft | Inicio</title>
</head>
<body>
    <section>
    <nav class="navbar navbar-expand-lg navbar-dark" class="navbar navbar-expand-lg navbar-dark" style="background:linear-gradient( rgba(42, 9, 190, 0.82), rgba(17, 130, 235, 0.82));">
       
       <a class="h1" href="#"><img src="../layout/img/Sicesoft_Logo.png" width="100" height="100" style="filter: drop-shadow(0 0 10px rgb(255, 255, 255)); margin-left:10px;"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto"></ul>
                <ul class="nav justify-content-end navbar-nav mr-md-6 ">
                <div class="btn-group dropdown">
                    
                </div>
                    <li class="nav-item ">
                        <a class="nav-link active" href="../controladores/salir.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </nav>
    </section>
    <br><br>
    <section id="creadores" class="sesion">
        <div class="jumbotron text-center container" id="rgba">
            <h1>Usuarios</h1>
                <p><u>Bienvenido a SiceSoft</u></p> 
                <br><br>
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-4 offset-sm-4">

                            		<?php
										include("../controladores/clsusuario.php");
										include("../bd/conexion.php");
										$documento=$_POST['documento'];
										$ddocumento="";
										//INSERT INTO `usuario`(`usr_documento`, `password_usrs`, `apellido_usrs`, `correo_usrs`, `usur_nombre`)
										$sql="SELECT*FROM usuario WHERE '$documento'=usr_documento";
										if (!$result=$db->query($sql)) {
											die("Error en la consulta de la base de datos [".$db->error."]");
										}
										while ($row = $result->fetch_assoc()) {
											$ddocumento=$row['usr_documento'];
										}
										if ($documento==$ddocumento) {
											echo " <p class='p3'>Este usuario ya existe intente de nuevo<b>";
											echo $documento;
											echo "</b></p>";
											header("refresh:5;url=../vistas/registro.php");
										}
										if ($documento!=$ddocumento) {
											$reg=new Usuario();
											$reg->registro_usuario($documento,$_POST['password'],$_POST['apellido'],$_POST['nombre'],$_POST['correo'],$_POST['telefono'],$_POST['jornada']);
											echo "<p class='p3'>Sr/Srñ se ha registrado corectamente el nuevo usuario<b>";
											echo "</b></p>";
											header("refresh:5;url=../vistas/lista_users.php");
										}
									?>

                            </div>
                        </div>
                    </div>
        </div>
    </section>
    <div class="area" >
            <ul class="circles">
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
            </ul>
    </div >
    <section>
        <footer class="page-footer font-small blue">
        <div class="footer-copyright text-center py-3 p" class="p">© 2023 Creado por:SiceSoft
            </div>
        </footer>
    </section>
    <?php 
        include('js.php');
    ?>