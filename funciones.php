<?php

use Google\Cloud\Core\Compute\Metadata;

$metadata = new Metadata();
$projectId = $metadata->getProjectId();

if ($projectId === false) {
    echo "Variable de entorno no definida.";
} else {
    echo "Soy basura y esta es mi mierda: $projectId";
    conectar();
}

$username = getenv('DB_USER');
$password = getenv('DB_PASS');
$instanceHost = getenv('INSTANCE_HOST');

function DBCreation(){

    $conn = mysqli_connect ( $instanceHost, $username, $password);

    $sql = ("drop database if exists Notas");
    $conn->query($sql);

    $sql = ("create database if not exists Notas");
    $conn->query($sql);

    $sql = ("use Notas");
    $conn->query($sql);

    $sql = file_get_contents('notas.sql');
    $conn->multi_query($sql);

}

function conectar() {

    $username = getenv('DB_USER');
    $password = getenv('DB_PASS');
    $instanceHost = getenv('INSTANCE_HOST');

    $conn = mysqli_connect($instanceHost, $username, $password, "Notas");

    return $conn;

}

// Asignaturas

function displayAsignaturas() {

    $conn = conectar();

    $sql = "SELECT * FROM Notas.asignaturas";
    $result = $conn->query($sql);

	if ($result) {

        $cont=0;

		while ($fila = mysqli_fetch_row($result)) {

            echo "<TR>";
	        echo "    <INPUT TYPE='hidden' name='codigo[$cont]' value='$fila[0]'>";
	        echo "    <TD><INPUT TYPE='text' name='newCodigo[$cont]' value='$fila[0]' size='10'></TD>";
	        echo "    <TD><INPUT TYPE='text' name='nombre[$cont]' value='$fila[1]' size='40'></TD>";
	        echo "    <TD><INPUT TYPE='text' name='horas_semana[$cont]' value='$fila[2]' size='9'></TD>";
	        echo "    <TD><INPUT TYPE='text' name='profesor[$cont]' value='$fila[3]' size='40'></TD>";
	        echo "    <TD><a href='index.php?operacion=eliminar&asignatura=$fila[0]'><img src='./iconos/remove32.png'></a></TD>";
            echo "    <TD><a href='unidades.php?asignatura=$fila[0]'><img src='./iconos/tarta.png'></a></TD>";
            echo "    <TD><a href='instrumentos.php?asignatura=$fila[0]'><img src='./iconos/smile.png'></a></TD>";
            echo "    <TD><a href='expediente.php'><img src='./iconos/birrete.png'></a></TD>";
            echo "</TR>";
            
            $cont++;

        }

        echo "<TR>";
	    echo "    <TD><INPUT TYPE='text' name='addCodigo' size='10'></TD>";
	    echo "    <TD><INPUT TYPE='text' name='addNombre' size='40'></TD>";
	    echo "    <TD><INPUT TYPE='text' name='addHoras' size='9'></TD>";
	    echo "    <TD><INPUT TYPE='text' name='addProfesor' size='40'></TD>";
        echo "</TR>";

		mysqli_free_result($result);

	}

}

function procesarCambiosAsignatura() {

    $conn = conectar();

    if(isset($_GET['operacion'])&&$_GET['operacion']=="eliminar") {

        // encuentra las unidades de la asignatura

        $codigo = $_GET['asignatura'];
        $sql = "SELECT clave from Notas.unidades where asignatura='$codigo'";
        $result = $conn->query($sql);

        foreach ($result as $row) {

            //$sql2 = "SELECT clave from Notas.instrumentos where unidad='$row'";
            $unidad = $row['clave'];
            $sql2 = "DELETE FROM Notas.instrumentos where unidad=$unidad";
            $result2 = $conn->query($sql2);
            $sql3 = "DELETE FROM Notas.unidades where clave=$unidad";
            $result3 = $conn->query($sql3);

        }

        $sql = "DELETE FROM Notas.asignaturas where codigo=$codigo";
        $result = $conn->query($sql);
        
    }

    if(isset($_POST['addCodigo'])&&$_POST['addCodigo']!="") {

     	$ncodigo = $_POST["addCodigo"];
        $nnombre = $_POST["addNombre"];
        $nhoras = $_POST["addHoras"];
        $nprofesor = $_POST["addProfesor"];
	    $sql = "INSERT INTO Notas.asignaturas VALUES ( '$ncodigo','$nnombre', '$nhoras', '$nprofesor' )";
	    $conn->query( $sql );   

    }

    if(isset($_POST['procesar'])&&$_POST['procesar']=="Guardar Cambios") {

        $ucodigo = $_POST["codigo"];
        $unewCodigo = $_POST["newCodigo"];
        $unombre = $_POST["nombre"];
        $uhoras = $_POST["horas_semana"];
        $uprofesor = $_POST["profesor"];

        for($i=0; $i<count($_POST["codigo"]); $i++) {

            updateAsignaturas ($ucodigo[$i], $unewCodigo[$i], $unombre[$i], $uhoras[$i], $uprofesor[$i] );

        }

    }

    $_POST = array();
    $_GET = array();

}

function updateAsignaturas ($ucodigo, $unewCodigo, $unombre, $uhoras, $uprofesor) {

    $conn = conectar();
	$sql = "UPDATE Notas.asignaturas SET codigo='$unewCodigo', nombre='$unombre', horas_semana='$uhoras', profesor='$uprofesor' WHERE codigo='$ucodigo'";
	$conn->query( $sql );

}

// Unidades

function displayUnidades() {

    $conn = conectar();
    
    $asignatura = $_GET['asignatura'];    

    $sql = "SELECT * FROM Notas.unidades where asignatura=$asignatura";
    $result = $conn->query($sql);

	if ($result) {

        $cont=0;

		while ($fila = mysqli_fetch_row($result)) {

            echo "<TR>";
	        echo "    <INPUT TYPE='hidden' name='clave[$cont]' value='$fila[0]'>";
	        echo "    <TD><INPUT TYPE='text' name='numero[$cont]' value='$fila[2]' size='3'></TD>";
	        echo "    <TD><INPUT TYPE='text' name='nombre[$cont]' value='$fila[3]' size='40'></TD>";
	        echo "    <TD><INPUT TYPE='text' name='porcentaje[$cont]' value='$fila[4]' size='5'></TD>";
	        echo "    <TD><a href='unidades.php?asignatura=$asignatura&operacion=eliminar&unidad=$fila[0]'><img src='iconos/remove32.png'></a></TD>";
            echo "</TR>";
            
            $cont++;

        }

        echo "<TR>";
	    echo "    <TD><INPUT TYPE='text' name='addNumero' size='3'></TD>";
	    echo "    <TD><INPUT TYPE='text' name='addNombre' size='40'></TD>";
	    echo "    <TD><INPUT TYPE='text' name='addPorcentaje' size='5'></TD>";
        echo "</TR>";

		mysqli_free_result($result);

	}

}

function procesarCambiosUnidades() {

    $conn = conectar();
    $asignatura = $_GET['asignatura'];

    if(isset($_GET['operacion'])&&$_GET['operacion']=="eliminar") {

        $unidad = $_GET['unidad'];
	    $sql = "DELETE FROM Notas.instrumentos WHERE unidad='$unidad'";
	    $conn->query( $sql );
        $sql2 = "DELETE FROM Notas.unidades WHERE clave='$unidad'";
        $conn->query( $sql2 );

    }

    if(isset($_POST['addNumero'])&&$_POST['addNumero']!=""&&$_POST['procesar']=="Guardar Cambios") {

     	$nnumero = $_POST["addNumero"];
        $nnombre = $_POST["addNombre"];
        $nporcentaje = $_POST["addPorcentaje"];
	    $sql = "INSERT INTO Notas.unidades ( asignatura, numero, nombre, porcentaje ) VALUES ( '$asignatura', '$nnumero','$nnombre', '$nporcentaje' )";
	    $conn->query( $sql );   

    }

    if(isset($_POST['procesar'])&&$_POST['procesar']=="Guardar Cambios") {

        $uclave = $_POST["clave"];
        $unumero = $_POST["numero"];
        $unombre = $_POST["nombre"];
        $uporcentaje = $_POST["porcentaje"];

        for($i=0; $i<count($_POST["clave"]); $i++) {

            updateUnidades ($uclave[$i], $unumero[$i], $unombre[$i], $uporcentaje[$i]);

        }

    }
    
}

function updateUnidades ($uclave, $unumero, $unombre, $uporcentaje) {

    $conn = conectar();
	$sql = "UPDATE Notas.unidades SET clave='$uclave', nombre='$unombre', numero='$unumero', porcentaje='$uporcentaje' WHERE clave='$uclave'";
	$conn->query( $sql );

}

// Instrumentos


function displayInstrumentos($codigoAsignatura) {
    $conexion = conectar();
    $consulta = "SELECT instrumentos.*, unidades.numero FROM `instrumentos` INNER JOIN unidades on unidades.clave= unidad WHERE unidades.asignatura = '$codigoAsignatura'";

    if ($result = mysqli_query($conexion, $consulta)) {
        $cont=0;
		foreach ($result as $fila) {
            echo "<TR>";
            echo "    <INPUT TYPE='hidden' name='clave[$cont]' value='" . $fila["clave"] . "'>";
            dropdownUnidad($codigoAsignatura, $cont, $fila['unidad']);
            echo "    <TD><INPUT TYPE='text' name='nombre[$cont]' value='" . $fila["nombre"] . "' size='40'></TD>";
            echo "    <TD><INPUT TYPE='number' name='peso[$cont]' value='" . $fila["peso"] . "' size='10'></TD>";
            echo "    <TD><INPUT TYPE='text' name='calificacion[$cont]' value='" . $fila["calificacion"] . "' size='10'></TD>";
	        echo "    <TD><a href='instrumentos.php?operacion=eliminar&clave=" . $fila["clave"] . "&asignatura=".$codigoAsignatura."'><img src='iconos/remove32.png' title='eliminar'></a></TD>";
            echo "</TR>";
            $cont++;
        }
        echo "<TR>";
            echo "    <INPUT TYPE='hidden' name='clave[$cont]' value=''>";
            dropdownUnidad($codigoAsignatura, $cont, 0);
            echo "    <TD><INPUT TYPE='text' name='nombre[$cont]' value='' size='40'></TD>";
            echo "    <TD><INPUT TYPE='number' name='peso[$cont]' value='' size='10'></TD>";
            echo "    <TD><INPUT TYPE='text' name='calificacion[$cont]' value='' size='10'></TD>";
	        echo "    <TD></TD>";
            echo "</TR>";
		mysqli_free_result($result);
    }
}

function dropdownUnidad($codigoAsignatura, $cont, $activo) {
    $conexion = conectar();
    $consulta = "SELECT clave, nombre FROM unidades WHERE asignatura = '$codigoAsignatura'";

    echo "<TD><select name='unidad[$cont]'>";
    echo "<option value=''></option>";
    if ($result = mysqli_query($conexion, $consulta)) {
        foreach ($result as $fila) {
            echo "<option value='".$fila['clave']."'";
            if ($fila['clave'] == $activo) {
                echo "selected='selected'";
            }
            echo ">".$fila['nombre']."</option>";
        }
    }
    echo "</select></td>";
}

function procesarCambiosInstrumentos($datos) {
    if(!isset($datos["clave"])) {
       return;
    }
	$conexion = conectar();
	$claves = $datos["clave"];
	$unidades = $datos["unidad"];
	$nombres = $datos["nombre"];
	$pesos = $datos["peso"];
	$calificaciones = $datos["calificacion"];
	for($i=0; $i<count($claves); $i++) {
		updateInstrumento($claves[$i], $unidades[$i], $nombres[$i], $pesos[$i], $calificaciones[$i] );
    }
    newInstrumento($unidades[$i-1], $nombres[$i-1], $pesos[$i-1], $calificaciones[$i-1]);
}

function deleteInstrumento() {

    $conn = conectar();

    if(isset($_GET['operacion'])&&$_GET['operacion']=="eliminar") {

        $instrumento = $_GET['clave'];
	    $sql = "DELETE FROM Notas.instrumentos WHERE clave='$instrumento'";
	    $conn->query( $sql );

    }

}

function updateInstrumento ($clave, $unidad, $nombre, $peso, $calificacion) {
	$conn = conectar();
	$sql = "UPDATE instrumentos SET unidad='$unidad', nombre='$nombre', peso='$peso', calificacion='$calificacion' WHERE clave='$clave'";
    $conn->query($sql);
}

function newInstrumento($unidad, $nombre, $peso, $calificacion) {
    $conn = conectar();
    if(!empty($nombre)) {
	    $sql = "INSERT INTO instrumentos (unidad, nombre, peso, calificacion) VALUES ( '$unidad','$nombre', '$peso', '$calificacion')";
	    $conn->query($sql);   
    }   
}

// EXPEDIENTES

function displayExpediente () {
    $conexion = conectar();
    $consulta="select codigo, nombre,
    (select sum((u.porcentaje/100)*
                (select sum((peso/100)*calificacion)
                from instrumentos as i
                where i.unidad=u.clave))
    from unidades as u
    where u.asignatura=a.codigo) as notamedia
    from asignaturas as a";
    if ($result=mysqli_query($conexion, $consulta)) {
        $cont=0;
        while($fila=mysqli_fetch_row($result)){
            echo "<TR>";
            echo "  <TD><INPUT type='text' disabled='disabled' name='codigo[$cont]' value='$fila[0]' size='10'></TD>";
            echo "  <TD><INPUT type='text' disabled='disabled' name='nombre[$cont]' value='$fila[1]' size='40'></TD>";
            echo "  <TD><INPUT type='text' disabled='disabled' name='nota media[$cont]' value='$fila[2]' size='9'></TD>";
            echo "<TR>";
            echo "</TR>";
            $cont++;
        }   
        mysqli_free_result($result);
     }
}

?>
