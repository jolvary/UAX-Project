<?php
require_once '../config/funciones.php';
require_once '../config/db.php';
require_once '../vendor/autoload.php';  // Twilio SDK
use Twilio\Rest\Client;

global $twilioAccountSid, $twilioAuthToken;

//error_reporting(E_ALL ^ E_NOTICE);
//var_dump("POST -> ", $_POST); // Debugging: check POST data
//var_dump("GET -> ", $_GET);  // Debugging: check GET data


session_start();

$twilio = new Client($twilioAccountSid, $twilioAuthToken);

$service = $twilio->verify->v2->services->create(
                "Register Verify Service" // FriendlyName
            );

$sid = $service->sid;

global $sid;

//var_dump("SID -> ", $sid);
//var_dump("SESSION -> ", $_SESSION); // Debugging: check session data

if (isset($_POST['sendSMS'])) {

    $telefono = $_POST['tlf'];
    $usuario = $_SESSION['usuario'] = $_POST['usuario'];
    $_SESSION['contraseña'] = $_POST['contraseña'];
    $_SESSION['tlf'] = $telefono;

    if (!empty($telefono) && preg_match('/^\+?[1-9]\d{1,14}$/', $telefono)) {
        
        if (comprobarUsuario($usuario, $telefono) == TRUE) {
            function alert($msg) {
                echo "<script type='text/javascript'>alert('$msg');</script>";
            }
            alert("El usuario o el teléfono ya están registrados.");

        } else {
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
        }
    } else {
        function alert($msg) {
            echo "<script type='text/javascript'>alert('$msg');</script>";
        }
        
        alert("Por favor ingrese un número de teléfono válido.");
    }
}

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
        
        //var_dump(comprobarUsuario($usuario, $telefono));

        if (comprobarUsuario($usuario, $telefono) == TRUE) {
            function alert($msg) {
                echo "<script type='text/javascript'>alert('$msg');</script>";
            }
            alert("El usuario o el teléfono ya están registrados.");

        } else {
            try {
                $verificationCheck = $twilio->verify
                                            ->v2
                                            ->services($_SESSION['sid'])
                                            ->verificationChecks
                                            ->create([
                                                'to' => $telefono,
                                                'code' => $codigo
                                            ]);

                //var_dump("Verification check status: ", $verificationCheck->status);

                if ($verificationCheck->status == "approved") {

                    crearUsuario($usuario, $contraseña, $telefono);

                    header("Location: https://jolvary.com/users/login.php");
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
        }

    } else {

        function alert($msg) {
                echo "<script type='text/javascript'>alert('$msg');</script>";
            }

        alert("Por favor solicite e ingrese el código recibido por SMS.");

    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <h2><a href="../index.php"><div style="float: left">Volver</div></a></h2>
    <link rel="stylesheet" href="https://jolvary.com/assets/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-lg mt-5">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Registro de Usuario</h4>                        
                    </div>
                    <div class="card-body">
                        <form method="post" action="">
                            <div class="form-group">
                                <label for="usuario">Usuario</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="usuario" 
                                    name="usuario" 
                                    pattern="[a-zA-Z0-9]+" 
                                    value="<?php echo htmlspecialchars($_SESSION['usuario'] ?? '', ENT_QUOTES); ?>" 
                                    required
                                >
                            </div>
                            <div class="form-group">
                                <label for="contraseña">Contraseña</label>
                                <input 
                                    type="password" 
                                    class="form-control" 
                                    id="contraseña" 
                                    name="contraseña" 
                                    value="<?php echo htmlspecialchars($_SESSION['contraseña'] ?? '', ENT_QUOTES); ?>" 
                                    required
                                >
                            </div>
                            <div class="form-group">
                                <label for="tlf">Teléfono</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="tlf" 
                                    name="tlf" 
                                    value="<?php echo htmlspecialchars($_SESSION['tlf'] ?? '', ENT_QUOTES); ?>" 
                                    required
                                >
                            </div>
                            <div class="form-group">
                                <label for="code">Código</label>
                                <div class="input-group">
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="code" 
                                        name="code"
                                    >
                                    <div class="input-group-append">
                                        <button 
                                            class="btn btn-outline-secondary" 
                                            type="submit" 
                                            name="sendSMS" 
                                            value="sendSMS"
                                        >
                                            Recibir código
                                        </button>
                                    </div>
                                </div>
                            </div><br>
                            <div class="d-flex justify-content-between">
                                <button 
                                    type="submit" 
                                    class="btn btn-success" 
                                    name="registro" 
                                    value="register"
                                >
                                    Registrarse
                                </button>
                                <a href="https://jolvary.com/users/login.php" class="btn btn-secondary">Iniciar sesión</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
