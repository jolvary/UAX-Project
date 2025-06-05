<HTML>

    <?php
    
    include('../config/funciones.php');
    require_once '../config/db.php';
   
    error_reporting(E_ALL ^ E_NOTICE);

    session_start();

    if (!isset($_SESSION['idUsuario'])) {
        header("Location: ../users/login.php");
        exit();
    }

    $idUser = $_SESSION['idUsuario'];
    $rolUser = $_SESSION['rolUsuario'];

    ?>

<HEAD>

    <h2><a href="../index.php"><div style="float: left">Volver</div></a></h2>
    <TITLE>RA5</TITLE>
    <link rel="stylesheet" href="https://jolvary.com/assets/css/bootstrap.min.css">

</HEAD>

<BODY>
    <center>
    <br><br><br><br><br><br><br><br><h2>ASIGNATURAS</h2>
    <FORM METHOD=POST ACTION="">
        <TABLE>
            <?php 
                echo "<br>";
                displayAsignaturas(40, 'admin');
            ?>
        </TABLE><br/>
        <?php
            if ($rolUser == 'alumno') {
                return;
            } else {
                echo "<INPUT TYPE='submit' name='procesar' value='Guardar Cambios'>";
		        echo "<INPUT TYPE='submit' name='procesar' value='Descartar Cambios'>";
            }
            
        ?>
    </FORM>
    </center>
</BODY>

</HTML>