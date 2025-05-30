<?php

    include('funciones.php');
    session_start();
    conectar();

    error_reporting(E_ALL ^ E_NOTICE);

    if (!empty($_POST)) {

        $usuario = iniSesion($_POST["usuario"], $_POST["contraseña"]);
    
    if ($usuario === null) {

        $error = '<div">El usuario o contraseña introducido es incorrecto</div>';

    } else {

        $_SESSION["idUsu"] = $usuario["idUsu"];
        $_SESSION["password"] = $usuario["password"];
        $_SESSION["nombre"] = $usuario["nombre"];
        header("Location: pagina2.php");
        exit;

    }
};

?>

<HTML>

<h1> Bienvenido a la página de inicio. </h1>

<form method="post" action="" name="signin-form">
    <div class="form-element">
        <label>Usuario</label>
        <input type="text" name="usuario" pattern="[a-zA-Z0-9]+" required />
    </div>
    <br>
    <div class="form-element">
        <label>Contraseña</label>
        <input type="password" name="contraseña" required />
    </div>
    <br>
    <button type="submit" name="login" value="login">Iniciar Sesión</button>
</form>

<button onclick="location.href='register.php'">Registrarse</button>

</HTML>
