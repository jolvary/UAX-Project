<?php
require_once '../config/funciones.php';
require_once '../config/db.php';
require_once '../vendor/autoload.php';  // Twilio SDK
use Twilio\Rest\Client;

global $twilioAccountSid, $twilioAuthToken, $conn;

//error_reporting(E_ALL ^ E_NOTICE);
//var_dump("POST -> ", $_POST);
//var_dump("GET -> ", $_GET);


session_start(); // For storing status messages

$twilio = new Client($twilioAccountSid, $twilioAuthToken);

$service = $twilio->verify->v2->services->create(
                "Login Verify Service" // FriendlyName
            );

$sid = $service->sid;

global $sid;

//var_dump("SID -> ", $sid);
//var_dump("SESSION -> ", $_SESSION);

// Handle "Send SMS" button click
if (isset($_POST['sendSMS'])) {

    $usuario = $_SESSION['usuario'] = $_POST['usuario'];
    $contraseña = $_SESSION['contraseña'] = $_POST['contraseña'];
    $telefono = iniSesion($usuario, $contraseña, 'check');

    if ($telefono == FALSE) {
        function alert($msg) {
            echo "<script type='text/javascript'>alert('$msg');</script>";
        }
        alert("El usuario o contraseña no son correctos.");

    } else {
        try {

            $verification = $twilio->verify
                                ->v2
                                ->services($sid)
                                ->verifications
                                ->create($telefono, "sms");

            $_SESSION['sid'] = $sid;
            $_SESSION['telefono'] = $telefono; 
                
        } catch (Exception $e) {
            function alert($msg) {
                echo "<script type='text/javascript'>alert('$msg');</script>";
            }
                
            alert("Error al enviar código: " . $e->getMessage());

        }
    }
}

if (isset($_POST['login'])) {

    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];
    $codigo = $_POST['code'];
    $sid = $_SESSION['sid'];
    $telefono = $_SESSION['telefono'];

    [$idUser, $rolUser] = iniSesion($usuario, $contraseña, 'login');
    $_SESSION['idUsuario'] = $idUser;
    $_SESSION['rolUsuario'] = $rolUser;

    header("Location: ../sites/asignaturas.php");

    $service = $twilio->verify->v2->services->create(
        "My First Verify Service"
    );


    if (!empty($codigo) && !empty($usuario) && !empty($sid)) {
        
        //var_dump(comprobarUsuario($usuario, $telefono)); // Debugging: check user existence

        [$idUser, $rolUser] = iniSesion($usuario, $contraseña, 'login');
        $_SESSION['idUsuario'] = $_POST['idUsuario'] = $idUser;
        $_SESSION['rolUsuario'] = $_POST['rolUsuario'] = $rolUser;

        if ($idUser == FALSE) {
            function alert($msg) {
                echo "<script type='text/javascript'>alert('$msg');</script>";
            }
            alert("El usuario, contraseña o teléfono no son correctos.");

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

                if ($verificationCheck->status === "approved") {

                    header("Location: ./sites/asignaturas.php");
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
    <title>Iniciar Sesión</title>
    <h2><a href="../index.php"><div style="float: left">Volver</div></a></h2>
    <link rel="stylesheet" href="https://jolvary.com/assets/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-lg mt-5">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Inicio de Sesión</h4>                        
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
                                    name="login" 
                                    value="login"
                                    method="POST"
                                >
                                    Iniciar Sesión
                                </button>
                                <a href="./users/register.php" class="btn btn-secondary" >Registrarse</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
