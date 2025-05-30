<HTML>

    <?php
    
    include('./config/funciones.php');
    require_once './config/db.php';
   
    error_reporting(E_ALL ^ E_NOTICE);

    ?>

<HEAD>

    <TITLE>RA5</TITLE>
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">

</HEAD>

<BODY>
    <center>
    <br><br><br><br><br><br><br><br><h2>ASIGNATURAS</h2>
    <FORM METHOD=POST ACTION="">
        <TABLE>
			<TR><TH>CÓDIGO</TH><TH>NOMBRE</TH><TH>HORAS</TH><TH>PROFESOR</TH></TR>
            <br>
            <tbody class="table-group-divider" >
		    <br>
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
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
</BODY>

</HTML>