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
    var_dump($_GET);
    $unidad = $_GET['idUnidad'];

    $sql = ("SELECT U.nomUnidad, U.idUnidad, U.idAsignatura, A.nomAsignatura FROM notas.unidades AS U
            INNER JOIN notas.asignaturas AS A ON U.idAsignatura = A.idAsignatura where idUnidad='$unidad'");
    $result = $conn->query($sql);
    $row = $result -> fetch_assoc();
	$nomUnidad = $row['nomUnidad'];
    $nomAsignatura = $row['nomAsignatura'];
    
    ?>

<head>
    <meta charset="UTF-8">
    <title>Instrumentos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5 text-center">
    <a href="../sites/unidades.php" class="btn btn-link mb-4">← Volver</a>

    <h1 class="mb-4">Instrumentos de Evaluación</h1>

    <form method="post">
        <div class="table-responsive">
            <table class="table table-striped table-bordered mx-auto">
                <?php displayInstrumentos($unidad, $idUser, $rolUser); ?>
            </table>
        </div>

        <?php if ($rolUser === "admin"): ?>
            <button type="submit" name="procesar" value="Guardar" class="btn btn-primary">Guardar Cambios</button>
            <button type="submit" name="procesar" value="Descartar" class="btn btn-secondary ml-2">Descartar Cambios</button>
        <?php endif; ?>
    </form>
</div>

</body>
</html>