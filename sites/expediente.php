<HTML>

    <?php
    
    require_once '../config/db.php';
    require_once '../config/funciones.php';
    
    ?>

<HEAD>

    <TITLE>Expediente</TITLE>

</HEAD>

<BODY>
    <center>

    <h2><a href="../index.php"><div style="float: left">Volver</div></a>
    <div align="center"><img src='../iconos/birrete.png'> EXPEDIENTE </div></h2>

    <FORM METHOD=POST ACTION="">
        <TABLE>
			<TR><TH>Código</TH><TH>Nombre</TH><TH>Nota Media</TH></TR>
		    <?php 
                //var_dump($_GET);
                //var_dump($_POST);
                displayExpediente();
                
            ?>
        </TABLE><br/>
             
    </FORM>
    </center>
</BODY>

</HTML>