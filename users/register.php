<?php

    include('funciones.php');
    conectar();
    //DBCreation();
    //var_dump($_POST);
    error_reporting(E_ALL ^ E_NOTICE);
    if (!empty($_POST)) {
        createUserUD4($_POST['usuario'], $_POST['contraseña'], $_POST['email']);
        createUserWordpress($_POST['usuario'], $_POST['contraseña'], $_POST['email']);
        createUserEspo($_POST['usuario'], $_POST['contraseña'], $_POST['email']);
    }

?>

<HTML>

<h1> Bienvenido a la página de inicio. </h1>

<form method="post" action="register.php" name="signup-form">
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
    <div class="form-element">
        <label>Email</label>
        <input type="email" name="email" required />
    </div>
    <br>
    <button type="submit" name="registro" value="register">Registrarse</button>
</form>

<button onclick="location.href='login.php'">Iniciar sesión</button>

</HTML>