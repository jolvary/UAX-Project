<HTML>

    <?php
    
    include('funciones.php');
    require_once 'db.php';
    global $conn;
    
    //DBCreation();
 
    $asig = $_GET['asignatura'];

    $asignatura = $asig;
    $sql = ("SELECT nombre FROM Notas.asignaturas where codigo='$asig'");
    $result = $conn->query($sql);
    $code = mysqli_fetch_row($result);
	$nasignatura = $code[0];

    error_reporting(E_ALL ^ E_NOTICE);
    error_reporting(E_ALL ^ E_WARNING); 
    
    ?>

<HEAD>

    <TITLE>UNIDADES</TITLE>

</HEAD>

<BODY>
    <center>
    <h2><a href="index.php"><div style="float: left">Volver</div></a>
    <div align="center"><?php echo 'Asignatura ', $asig, " : ", $nasignatura;?></div></h2>

    <h1 style="text-align:center;"><img src='iconos/tarta.png'> UNIDADES </h1>
    <FORM METHOD=POST ACTION="">
        <TABLE>
			<TR><TH>NÚM</TH><TH>NOMBRE</TH><TH>PESO (%)</TH></TR>
		    <?php 
                //var_dump($_GET);
                //var_dump($_POST);
                procesarCambiosUnidades($asig);
                displayUnidades($asig);
                
            ?>
        </TABLE><br/>
		<INPUT TYPE="submit" name="procesar" value="Guardar Cambios">
		<INPUT TYPE="submit" name="procesar" value="Descartar Cambios">            
    </FORM>
    </center>
</BODY>

</HTML>