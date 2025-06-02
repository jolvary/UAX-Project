<?php
require_once '../config/funciones.php';
require_once '../config/db.php';
require_once '../vendor/autoload.php';  // Twilio SDK
use Twilio\Rest\Client;

//error_reporting(E_ALL ^ E_NOTICE);
//var_dump("POST -> ", $_POST); // Debugging: check POST data
//var_dump("GET -> ", $_GET);  // Debugging: check GET data


session_start(); // For storing status messages

global $twilioAccountSid, $twilioAuthToken;

$twilio = new Client($twilioAccountSid, $twilioAuthToken);

$service = $twilio->verify->v2->services->create(
                "My First Verify Service" // FriendlyName
            );

$sid = $service->sid;

global $sid;

//var_dump("SID -> ", $sid);
//var_dump("SESSION -> ", $_SESSION); // Debugging: check session data

// Handle "Send SMS" button click
if (isset($_POST['sendSMS'])) {

    $telefono = $_POST['tlf'];
    $_SESSION['usuario'] = $_POST['usuario'];
    $_SESSION['contraseña'] = $_POST['contraseña'];

    if (!empty($telefono) && preg_match('/^\+?[1-9]\d{1,14}$/', $telefono)) {
        try {

            $verification = $twilio->verify
                                   ->v2
                                   ->services($sid)
                                   ->verifications
                                   ->create($telefono, "sms");

            $_SESSION['sid'] = $sid;
            
        } catch (Exception $e) {
            function alert($msg) {
                echo "<script type='text/javascript'>alert('$msg');</script>";
            }
            
            alert("Error al enviar código: " . $e->getMessage());

        }
    } else {
        function alert($msg) {
            echo "<script type='text/javascript'>alert('$msg');</script>";
        }
        
        alert("Por favor ingrese un número de teléfono válido.");
    }
}

// Handle "Registrarse" button click
if (isset($_POST['registro'])) {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];
    $telefono = $_POST['tlf'];
    $codigo = $_POST['code'];
    $sid = $_SESSION['sid'];

    $service = $twilio->verify->v2->services->create(
        "My First Verify Service"
    );

    if (!empty($codigo) && !empty($telefono) && !empty($sid)) {
        try {
            
            $verificationCheck = $twilio->verify
                                        ->v2
                                        ->services($_SESSION['sid'])
                                        ->verificationChecks
                                        ->create([
                                            'to' => $telefono,
                                            'code' => $codigo
                                        ]);

            if ($verificationCheck->status === "approved") {

                header("Location: http://jolvary.com/users/login.php");
                exit();
                
            } else {

                function alert($msg) {
                    echo "<script type='text/javascript'>alert('$msg');</script>";
                }
                alert("Código incorrecto. Por favor intente de nuevo.");                

            }
        } catch (Exception $e) {
            
            function alert($msg) {
                echo "<script type='text/javascript'>alert('$msg');</script>";
            }

            alert("Error al verificar el código: " . $e->getMessage());
            
        }
    } else {

        function alert($msg) {
                echo "<script type='text/javascript'>alert('$msg');</script>";
            }

        alert("Por favor solicite e ingrese el código recibido por SMS.");

    }
}
?>

<html5>
<head>
    <h2><a href="../index.php"><div style="float: left">Volver</div></a>
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
</head> 
<body>
<center>
<br><br><br><br><br><br><br><br>
<h2>Registro de Usuario</h2><br>
<form method="post" action="">
    <table class="table table-borderless" width="400">
        <tr>
            <td style="width:27%">Usuario</td>
            <td style="width:43%"><input size="22" type="text" name="usuario" pattern="[a-zA-Z0-9]+" value="<?php echo $_SESSION['usuario']; ?>" required /></td>
            <td></td>
        </tr>
        <tr>
            <td>Contraseña</td>
            <td><input size="22" type="password" name="contraseña" value="<?php echo $_SESSION['contraseña']; ?>" required /></td>
            <td></td>
        </tr>
        <tr>
            <td>Teléfono</td>
            <td><input size="22" type="text" name="tlf" value="<?php echo $_SESSION['tlf']; ?>" required /></td>
            <td></td>
        </tr>
        <tr>
            <td style="width:27%">Código</td>
            <td style="width:43%"><input size="22" type="text" name="code" /></td>
            <td style="width:27%"><button type="submit" name="sendSMS" value="sendSMS">Recibir código</button></td>
        </tr>
    </table>
    
    <br>
    <button onclick="location.href='http://jolvary.com/users/register.php'">Registrarse</button>
    <button type="submit" name="login" value="login">Iniciar Sesión</button>
    
</form>
</center>
</body>
</html>
