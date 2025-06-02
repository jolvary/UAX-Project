<?php

    require_once '../config/funciones.php';
    require_once '../config/db.php';
    
    error_reporting(E_ALL ^ E_NOTICE);

?>

<html5>
<head>
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
</head> 
<body>
    <center>
    <br><br><br><br><br><br><br><br>
    <h2>Registro de Usuario</h2>
    <form method="post" action="" name="signup-form">

    <br><br><table class="table table-borderless" width="500">
        <tr>
            <td>Usuario</td>
            <td><input type="text" name="usuario" pattern="[a-zA-Z0-9]+" required /></td>
        </tr>
        <tr>
            <td>Contraseña</td>
            <td><input type="password" name="contraseña" required /></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="email" name="email" required /></td>
        </tr>
    </form>
    </table><br><br>
        <button type="submit" name="registro" value="register">Registrarse</button>
        <button onclick="location.href='login.php'">Iniciar sesión</button>
        </center>
    </body>
</html>
