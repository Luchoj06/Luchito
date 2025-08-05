<?php include("../controladores/seguridad2.php");
      include('../layout/visuales/css.php');
?>

<script src="JsBarcode.all.min.js"></script>

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
										include("../controladores/clsAlumno.php");
										include("../bd/conexion.php");
                                    
                                        
                                        $documento = $_POST['documento'];
                                        $nombre = $_POST['nombre'];
                                        $apellido = $_POST['apellido'];
                                        $curso = $_POST['curso'];
                                        $jornada = $_POST['jornada'];
                                        
                                        $estudiante = new Estudiante();
                                        $estudiante->registrar_estudiante($documento, $nombre, $apellido, $curso, $jornada);
                                        
                                        echo "Estudiante registrado correctamente.";

                                        
                                        ?>
                                        

                            </div>
                        </div>
                    </div>
                    <br><br><br>
                    
                    <a href="../vistas/admin.php" class="btn btn-outline-info">Volver</a>
                    
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
        <div class="footer-copyright text-center py-3 p" class="p">© 2023 Creado por:Sicesoft
            </div>
        </footer>
    </section>
    <?php 
        include('../layout/visuales/js.php');
    ?>