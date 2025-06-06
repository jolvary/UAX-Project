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
    $unidad = $_GET['idUnidad'];

    $sql = ("SELECT U.nomUnidad, U.idUnidad, U.idAsignatura, A.nomAsignatura FROM notas.unidades AS U
            INNER JOIN notas.asignaturas AS A ON U.idAsignatura = A.idAsignatura where idUnidad='$unidad'");
    $result = $conn->query($sql);
    $row = $result -> fetch_assoc();
	$nomUnidad = $row['nomUnidad'];
    $nomAsignatura = $row['nomAsignatura'];
    
    ?>

<HEAD>

    <TITLE>Instrumentos</TITLE>

</HEAD>

<BODY>
    <center>
    <h2><a href="../index.php"><div style="float: left">Volver</div></a></h2><br><br><br><br>
    <h3><div align="center"><?php echo $nomAsignatura, " -> Unidad ", $unidad, ": ", $nomUnidad;?></div></h3>

    <h1 style="text-align:center;"><img src='../iconos/smile.png'> INSTRUMENTOS </h1>
    <FORM METHOD=POST ACTION="">
        <TABLE>
			<TR><TH>Unidad</TH><TH>Nombre del Instrumento</TH><TH>Peso (%)</TH><TH>Calificación</TH></TR>
		    <?php 

                //procesarCambiosInstrumento();
                displayCalificaciones($unidad, $idUser, $rolUser);          

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