<HTML>

    <?php
    
    require_once '../config/funciones.php';
    require_once '../config/db.php';
    global $conn;
    
    session_start();

    if (!isset($_SESSION['idUsuario'])) {
        header("Location: ../users/login.php");
        exit();
    }

    $idUser = $_SESSION['idUsuario'];
    $rolUser = $_SESSION['rolUsuario'];
    $asig = $_GET['idAsignatura'];

    $sql = ("SELECT nomAsignatura FROM notas.asignaturas where idAsignatura='$asig'");
    $result = $conn->query($sql);
    $code = mysqli_fetch_row($result);
	$nasignatura = $code[0]; 

    ?>

<HEAD>

    <TITLE>Unidades</TITLE>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
</HEAD>

<body class="bg-light">

<div class="container mt-5 text-center">
    <?php echo "<a href='../sites/asignaturas.php'" ?> class="btn btn-link mb-4">← Volver</a><br><br><br><br><br><br>
    <center>
    <h1 style="text-align:center;"><img src='../iconos/tarta.png'> UNIDADES </h1><br>
    <h3><div align="center"><?php echo 'Asignatura ', $asig, " : ", $nasignatura;?></div></h3><br><br>

    
    <FORM METHOD=POST ACTION="">
        <div class="table-responsive">
            <TABLE>
                <?php 

                    procesarCambiosUnidades();
                    displayUnidades($asig, $idUser, $rolUser);
                    
                ?>
            </TABLE><br/>
        </div><br>
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
</div>
</BODY>

</HTML>