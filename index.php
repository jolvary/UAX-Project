<HTML>

    <?php
    
    include('funciones.php');
    
    //DBCreation();
    conectar();

    //error_reporting(E_ALL ^ E_NOTICE);

    ?>

<HEAD>

    <TITLE>RA5</TITLE>

</HEAD>

<BODY>
    <center>
    <h2>ASIGNATURAS</h2>
    <FORM METHOD=POST ACTION="">
        <TABLE>
			<TR><TH>CÓDIGO</TH><TH>NOMBRE</TH><TH>HORAS</TH><TH>PROFESOR</TH></TR>
		    <?php 
                //var_dump($_GET);
                //var_dump($_POST);
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