<HTML>

    <?php
    
    require_once '../config/funciones.php';
    require_once '../config/db.php';

    session_start();

    if (!isset($_SESSION['idUsuario'])) {
        header("Location: ../users/login.php");
        exit();
    }

    $idUser = $_SESSION['idUsuario'];
    $rolUser = $_SESSION['rolUsuario'];

    ?>

<HEAD>

    <TITLE>RA5</TITLE>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</HEAD>

<body class="bg-light">

<div class="container mt-5 text-center">
    <a href='../users/login.php' class="btn btn-link mb-4">← Volver</a>
    <center>
    <br><br><br><br><br><br><br><h2>ASIGNATURAS</h2>
    <FORM METHOD=POST ACTION="">
        <div class="table-responsive">
            <table><?php 
                echo "<br>";
                procesarCambiosAsignatura();
                displayAsignaturas($idUser, $rolUser);
            ?></table>
        </TABLE><br/>
        <?php
            if ($rolUser !== 'admin') {
                return;
            } else {
                echo "<INPUT TYPE='submit' name='procesar' value='Guardar Cambios'>";
		        echo "<INPUT TYPE='submit' name='procesar' value='Descartar Cambios'>";
            }
            
        ?>
        </div>
    </FORM>
    </center>
</BODY>

</HTML>