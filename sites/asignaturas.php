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

    <h2><a href="../index.php"><div style="float: left">Volver</div></a></h2>
    <TITLE>RA5</TITLE>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">

</HEAD>

<BODY>
    <center>
    <br><br><br><br><br><br><br><h2>ASIGNATURAS</h2>
    <FORM METHOD=POST ACTION="">
        <TABLE>
            <?php 
                echo "<br>";
                procesarCambiosAsignatura();
                displayAsignaturas($idUser, $rolUser);
            ?>
        </TABLE><br/>
        <?php
            if ($rolUser !== 'admin') {
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