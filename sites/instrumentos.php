<HTML>

    <?php
    
    require_once '../config/funciones.php';
    require_once '../config/db.php';
    
    //DBCreation();
    $asig = $_GET['asignatura'];

    $sql = ("SELECT nombre FROM Notas.asignaturas where codigo='$asig'");
    $nombre = $conn->query($sql);
    $code = mysqli_fetch_row($nombre);
	$nasignatura = $code[0];

    if (!empty($_POST)) {
        procesarCambiosInstrumentos($_POST);
    };

    error_reporting(E_ALL ^ E_NOTICE);
    error_reporting(E_ALL ^ E_WARNING); 
    ?>

<HEAD>

    <TITLE>Instrumentos</TITLE>

</HEAD>

<BODY>
    <center>
    <h2><a href="../index.php"><div style="float: left">Volver</div></a>
    <div align="center"><?php echo 'Asignatura ', $asig, " : ", $nasignatura;?></div></h2>

    <h1 style="text-align:center;"><img src='../iconos/smile.png'> INSTRUMENTOS </h1>
    <FORM METHOD=POST ACTION="">
        <TABLE>
			<TR><TH>Unidad</TH><TH>Nombre del Instrumento</TH><TH>Peso (%)</TH><TH>Calificación</TH></TR>
		    <?php 
                //var_dump($_GET);
                //var_dump($_POST);
                deleteInstrumento($asig);
                displayInstrumentos($asig);               
            ?>
        </TABLE><br/>
		<INPUT TYPE="submit" name="procesar" value="Guardar Cambios">
		<INPUT TYPE="submit" name="procesar" value="Descartar Cambios">            
    </FORM>
    </center>
</BODY>

</HTML>