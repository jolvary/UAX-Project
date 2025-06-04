<HTML>

    <?php
    
    include('../config/funciones.php');
    require_once '../config/db.php';
   
    error_reporting(E_ALL ^ E_NOTICE);

    session_start();

    var_dump($_SESSION);
    var_dump($_POST);

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
                //var_dump($_GET);
                //var_dump($_POST);
                echo "<br>";
                procesarCambiosAsignatura();
                displayAsignaturas();
            ?>
        </TABLE><br/>
		<INPUT TYPE="submit" name="procesar" value="Guardar Cambios">
		<INPUT TYPE="submit" name="procesar" value="Descartar Cambios">            
    </FORM>
    </center>
</BODY>

</HTML>