<?php

// Asignaturas
require_once __DIR__ . '/db.php';
global $conn;


function displayAsignaturas() {

    global $conn;

    $idUser = $_SESSION['idUsuario'];

    $sql = "SELECT A.idAsignatura, A.nomAsignatura, A.horasSemana, P.nomProfesor FROM notas.asignaturas AS A 
            INNER JOIN notas.profesores AS P ON A.idProfesor = P.idProfesor
            INNER JOIN notas.unidades AS U ON A.idAsignatura = U.idAsignatura
            INNER JOIN notas.instrumentos AS I ON U.idUnidad = I.idUnidad
            INNER JOIN notas.calificaciones AS C ON I.idInstrumento = C.idInstrumento
            INNER JOIN notas.usuarios as Us ON C.idUsuario = Us.idUsuario
            where Us.idUsuario = $idUser
            GROUP BY A.idAsignatura";

    $result = $conn->query($sql);

	if ($result->num_rows > 0) {

        $cont=0;

        echo "<TR>";
            echo "<TH class='text-center'>CÓDIGO</TH>";
            echo "<TH class='text-center'>NOMBRE</TH>";
            echo "<TH class='text-center'>HORAS</TH>";
            echo "<TH class='text-center'>PROFESOR</TH>";
            echo "<tbodyclass='table-group-divider' >";
        echo "</TR>";

		while ($fila = mysqli_fetch_row($result)) {

            echo "<TR>";
	        echo "    <INPUT TYPE='hidden' name='codigo[$cont]' value='$fila[0]'>";
	        echo "    <TD class='text-center'><INPUT TYPE='text' name='newCodigo[$cont]' value='$fila[0]' size='3'></TD>";
	        echo "    <TD class='text-center'><INPUT TYPE='text' name='nombre[$cont]' value='$fila[1]' size='50'></TD>";
	        echo "    <TD class='text-center'><INPUT TYPE='text' name='horas_semana[$cont]' value='$fila[2]' size='2'></TD>";
	        echo "    <TD class='text-center'><INPUT TYPE='text' name='profesor[$cont]' value='$fila[3]' size='44'></TD>";
	        echo "    <TD><a href='index.php?operacion=eliminar&asignatura=$fila[0]'><img src='../iconos/remove32.png'></a></TD>";
            echo "    <TD><a href='/sites/unidades.php?asignatura=$fila[0]'><img src='../iconos/tarta.png'></a></TD>";
            echo "    <TD><a href='/sites/instrumentos.php?asignatura=$fila[0]'><img src='../iconos/smile.png'></a></TD>";
            echo "    <TD><a href='/sites/expediente.php'><img src='../iconos/birrete.png'></a></TD>";
            echo "</TR>";
            
            $cont++;

        }

        echo "<TR>";
	    echo "    <TD class='text-center'><INPUT TYPE='text' name='addCodigo' size='3'></TD>";
	    echo "    <TD class='text-center'><INPUT TYPE='text' name='addNombre' size='50'></TD>";
	    echo "    <TD class='text-center'><INPUT TYPE='text' name='addHoras' size='2'></TD>";
	    echo "    <TD class='text-center'><INPUT TYPE='text' name='addProfesor' size='44'></TD>";
        echo "</TR>";

		mysqli_free_result($result);

	}

}

function procesarCambiosAsignatura() {

    global $conn;

    if(isset($_GET['operacion'])&&$_GET['operacion']=="eliminar") {

        // encuentra las unidades de la asignatura

        $codigo = $_GET['asignatura'];
        $sql = "SELECT clave from notas.unidades where asignatura='$codigo'";
        $result = $conn->query($sql);

        foreach ($result as $row) {

            //$sql2 = "SELECT clave from notas.instrumentos where unidad='$row'";
            $unidad = $row['clave'];
            $sql2 = "DELETE FROM notas.instrumentos where unidad=$unidad";
            $result2 = $conn->query($sql2);
            $sql3 = "DELETE FROM notas.unidades where clave=$unidad";
            $result3 = $conn->query($sql3);

        }

        $sql = "DELETE FROM notas.asignaturas where codigo=$codigo";
        $result = $conn->query($sql);
        
    }

    if(isset($_POST['addCodigo'])&&$_POST['addCodigo']!="") {

     	$ncodigo = $_POST["addCodigo"];
        $nnombre = $_POST["addNombre"];
        $nhoras = $_POST["addHoras"];
        $nprofesor = $_POST["addProfesor"];
	    $sql = "INSERT INTO notas.asignaturas VALUES ( '$ncodigo','$nnombre', '$nhoras', '$nprofesor' )";
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

    global $conn;

	$sql = "UPDATE notas.asignaturas SET codigo='$unewCodigo', nombre='$unombre', horas_semana='$uhoras', profesor='$uprofesor' WHERE codigo='$ucodigo'";
	$conn->query( $sql );

}

// Unidades

function displayUnidades($asignatura) {

    global $conn;

    $sql = "SELECT * FROM notas.unidades where asignatura=$asignatura";
    $result = $conn->query($sql);

	if ($result) {

        $cont=0;

		while ($fila = mysqli_fetch_row($result)) {

            echo "<TR>";
	        echo "    <INPUT TYPE='hidden' name='clave[$cont]' value='$fila[0]'>";
	        echo "    <TD><INPUT TYPE='text' name='numero[$cont]' value='$fila[2]' size='3'></TD>";
	        echo "    <TD><INPUT TYPE='text' name='nombre[$cont]' value='$fila[3]' size='40'></TD>";
	        echo "    <TD><INPUT TYPE='text' name='porcentaje[$cont]' value='$fila[4]' size='5'></TD>";
	        echo "    <TD><a href='../sites/unidades.php?asignatura=$asignatura&operacion=eliminar&unidad=$fila[0]'><img src='../iconos/remove32.png'></a></TD>";
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

function procesarCambiosUnidades($asignatura) {

    global $conn;

    if(isset($_GET['operacion'])&&$_GET['operacion']=="eliminar") {

        $unidad = $_GET['unidad'];
	    $sql = "DELETE FROM notas.instrumentos WHERE unidad='$unidad'";
	    $conn->query( $sql );
        $sql2 = "DELETE FROM notas.unidades WHERE clave='$unidad'";
        $conn->query( $sql2 );

    }

    if(isset($_POST['addNumero'])&&$_POST['addNumero']!=""&&$_POST['procesar']=="Guardar Cambios") {

     	$nnumero = $_POST["addNumero"];
        $nnombre = $_POST["addNombre"];
        $nporcentaje = $_POST["addPorcentaje"];
	    $sql = "INSERT INTO notas.unidades ( asignatura, numero, nombre, porcentaje ) VALUES ( '$asignatura', '$nnumero','$nnombre', '$nporcentaje' )";
	    $conn->query( $sql );   

    }

    if(isset($_POST['procesar'])&&$_POST['procesar']=="Guardar Cambios"&&isset($_POST["clave"])) {

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

    global $conn;

	$sql = "UPDATE notas.unidades SET clave='$uclave', nombre='$unombre', numero='$unumero', porcentaje='$uporcentaje' WHERE clave='$uclave'";
	$conn->query( $sql );

}

// Instrumentos


function displayInstrumentos($codigoAsignatura) {

    global $conn;

    $consulta = "SELECT instrumentos.*, unidades.numero FROM `instrumentos` INNER JOIN unidades on unidades.clave= unidad WHERE unidades.asignatura = '$codigoAsignatura'";

    if ($result = mysqli_query($conn, $consulta)) {
        $cont=0;
		foreach ($result as $fila) {
            echo "<TR>";
            echo "    <INPUT TYPE='hidden' name='clave[$cont]' value='" . $fila["clave"] . "'>";
            dropdownUnidad($codigoAsignatura, $cont, $fila['unidad']);
            echo "    <TD><INPUT TYPE='text' name='nombre[$cont]' value='" . $fila["nombre"] . "' size='40'></TD>";
            echo "    <TD><INPUT TYPE='number' name='peso[$cont]' value='" . $fila["peso"] . "' size='10'></TD>";
            echo "    <TD><INPUT TYPE='text' name='calificacion[$cont]' value='" . $fila["calificacion"] . "' size='10'></TD>";
	        echo "    <TD><a href='../sites/instrumentos.php?operacion=eliminar&clave=" . $fila["clave"] . "&asignatura=".$codigoAsignatura."'><img src='../iconos/remove32.png' title='eliminar'></a></TD>";
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

    global $conn;

    $consulta = "SELECT clave, nombre FROM unidades WHERE asignatura = '$codigoAsignatura'";

    echo "<TD><select name='unidad[$cont]'>";
    echo "<option value=''></option>";
    if ($result = mysqli_query($conn, $consulta)) {
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

    global $conn;

    if(!isset($datos["clave"])) {
       return;
    }
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

    global $conn;

    if(isset($_GET['operacion'])&&$_GET['operacion']=="eliminar") {

        $instrumento = $_GET['clave'];
	    $sql = "DELETE FROM notas.instrumentos WHERE clave='$instrumento'";
	    $conn->query( $sql );

    }

}

function updateInstrumento ($clave, $unidad, $nombre, $peso, $calificacion) {
	
    global $conn;

	$sql = "UPDATE instrumentos SET unidad='$unidad', nombre='$nombre', peso='$peso', calificacion='$calificacion' WHERE clave='$clave'";
    $conn->query($sql);
}

function newInstrumento($unidad, $nombre, $peso, $calificacion) {

    global $conn;

    if(!empty($nombre)) {
	    $sql = "INSERT INTO instrumentos (unidad, nombre, peso, calificacion) VALUES ( '$unidad','$nombre', '$peso', '$calificacion')";
	    $conn->query($sql);   
    }   
}

// EXPEDIENTES

function displayExpediente () {
        
    global $conn;

    $consulta="select codigo, nombre,
    (select sum((u.porcentaje/100)*
                (select sum((peso/100)*calificacion)
                from instrumentos as i
                where i.unidad=u.clave))
    from unidades as u
    where u.asignatura=a.codigo) as notamedia
    from asignaturas as a";

    if ($result = $conn->query($consulta)) {
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

function comprobarUsuario($usuario, $telefono) {

    global $conn;

    $sql = "SELECT * FROM notas.usuarios WHERE nomUsuario='$usuario' OR tlfUsuario='$telefono'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }

}

function crearUsuario($usuario, $password, $telefono) {

    global $conn;

    $sql = "INSERT INTO notas.usuarios (nomUsuario, passUsuario, tlfUsuario) VALUES ('$usuario', MD5('$password'), '$telefono')";
    $result = $conn->query( $sql ); 

}

function iniSesion($usuario, $password, $accion) {

    global $conn;

    $sql = "SELECT * FROM notas.usuarios WHERE nomUsuario = '$usuario' AND passUsuario = MD5('$password')";
    $result = $conn->query($sql);
    $row = $result -> fetch_assoc();

   if ($result->num_rows == 0) {
        return false;
    } else if ($result->num_rows > 0 && $accion == "check") {
        return $row['tlfUsuario'];
    } else if ($result->num_rows > 0 && $accion == "login") {
        return [$row['idUsuario'], $row['rolUsuario']];
    }

}

?>