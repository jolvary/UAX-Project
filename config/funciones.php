<?php

require_once __DIR__ . '/db.php';
global $conn;

function displayAsignaturas($idUser, $rolUser) {

    global $conn;

	if ($rolUser == "admin") {

        $sql = "SELECT A.idAsignatura, A.nomAsignatura, A.horasSemana, P.idProfesor FROM notas.asignaturas AS A 
            INNER JOIN notas.profesores AS P ON A.idProfesor = P.idProfesor
            GROUP BY A.idAsignatura";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            $cont=0;

            echo "<table class='table table-bordered table-hover'>";
            echo "<thead class='thead-dark'><tr class='text-center'>";
            echo "        <TH>CÓDIGO</TH>";
            echo "        <TH>NOMBRE</TH>";
            echo "        <TH>HORAS</TH>";
            echo "        <TH>PROFESOR</TH>";
            echo "</tr></thead><tbody>";

            while ($row = $result -> fetch_assoc()) {

                echo "<TR>";
                echo "    <INPUT TYPE='hidden' name='idAsig[$cont]' value='$row[idAsignatura]'>";
                echo "    <TD class='text-center'><INPUT TYPE='text' name='idAsignatura[$cont]' value='$row[idAsignatura]' size='3'></TD>";
                echo "    <TD class='text-center'><INPUT TYPE='text' name='nomAsignatura[$cont]' value='$row[nomAsignatura]' size='50'></TD>";
                echo "    <TD class='text-center'><INPUT TYPE='text' name='horasSemana[$cont]' value='$row[horasSemana]' size='2'></TD>";
                echo "    <TD class='text-center'><INPUT TYPE='text' name='idProfesor[$cont]' value='$row[idProfesor]' size='44'></TD>";
                echo "    <TD><a href='asignaturas.php?operacion=eliminar&idAsignatura=$row[idAsignatura]'><img src='../iconos/remove32.png'></a></TD>";
                echo "    <TD><a href='../sites/unidades.php?idAsignatura=$row[idAsignatura]'><img src='../iconos/tarta.png'></a></TD>";
                echo "</TR>";
                
                $cont++;

            }
            
            echo "<TR>";
            echo "    <TD class='text-center'><INPUT TYPE='text' name='addAsig' size='3'></TD>";
            echo "    <TD class='text-center'><INPUT TYPE='text' name='addNombre' size='50'></TD>";
            echo "    <TD class='text-center'><INPUT TYPE='text' name='addHoras' size='2'></TD>";
            echo "    <TD class='text-center'><INPUT TYPE='text' name='addProfesor' size='44'></TD>";
            echo "</TR>";
            echo "</tbody></table>";
        } else {

            echo "<TR><TD colspan=4>No hay asignaturas disponibles.</TD></TR>";
            
        }
            

    } else if ($rolUser == "profesor") {

        $sql = "SELECT A.idAsignatura, A.nomAsignatura, A.horasSemana, P.nomProfesor FROM notas.asignaturas AS A 
            INNER JOIN notas.profesores AS P ON A.idProfesor = P.idProfesor
            where P.idProfesor = $idUser
            GROUP BY A.idAsignatura";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        
            $cont=0;

            echo "<table class='table table-bordered table-hover'>";
            echo "<thead class='thead-dark'><tr class='text-center'>";
            echo "        <TH>CÓDIGO</TH>";
            echo "        <TH>NOMBRE</TH>";
            echo "        <TH>HORAS</TH>";
            echo "</tr></thead><tbody>";

            while ($row = $result -> fetch_assoc()) {

                echo "<TR>";
                echo "    <INPUT TYPE='hidden' name='idAsig[$cont]' value='$row[idAsignatura]'>";
                echo "    <TD class='text-center'><INPUT readonly='readonly' TYPE='text' name='idAsignatura[$cont]' value='$row[idAsignatura]' size='3'></TD>";
                echo "    <TD class='text-center'><INPUT readonly='readonly' TYPE='text' name='nomAsignatura[$cont]' value='$row[nomAsignatura]' size='50'></TD>";
                echo "    <TD class='text-center'><INPUT readonly='readonly' TYPE='text' name='horasSemana[$cont]' value='$row[horasSemana]' size='2'></TD>";
                echo "    <TD><a href='/sites/unidades.php?idAsignatura=$row[idAsignatura]'><img src='../iconos/tarta.png'></a></TD>";
                echo "</TR>";

                $cont++;

            }
            echo "</tbody></table>";

        }  else {

            echo "<TR><TD colspan=4>No hay asignaturas disponibles.</TD></TR>";
            
        }

    } else if ($rolUser == "alumno") {

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

            echo "<table class='table table-bordered table-hover'>";
            echo "<thead class='thead-dark'><tr class='text-center'>";
            echo "        <TH>CÓDIGO</TH>";
            echo "        <TH>NOMBRE</TH>";
            echo "        <TH>HORAS</TH>";
            echo "        <TH>PROFESOR</TH>";
            echo "</tr></thead><tbody>";

            while ($row = $result -> fetch_assoc()) {

                echo "<TR>";
                echo "    <TD class='text-center'><INPUT readonly='readonly' TYPE='text' name='idAsignatura[$cont]' value='$row[idAsignatura]' size='3'></TD>";
                echo "    <TD class='text-center'><INPUT readonly='readonly' TYPE='text' name='nomAsignatura[$cont]' value='$row[nomAsignatura]' size='50'></TD>";
                echo "    <TD class='text-center'><INPUT readonly='readonly' TYPE='text' name='horasSemana[$cont]' value='$row[horasSemana]' size='2'></TD>";
                echo "    <TD class='text-center'><INPUT readonly='readonly' TYPE='text' name='nomProfesor[$cont]' value='$row[nomProfesor]' size='44'></TD>";
                echo "    <TD><a href='/sites/unidades.php?idAsignatura=$row[idAsignatura]'><img src='../iconos/tarta.png'></a></TD>";
                echo "    <TD><a href='../sites/expediente.php'><img src='../iconos/birrete.png'></a></TD>";
                echo "</TR>";

                $cont++;

            }

            echo "</tbody></table>";

        } else {

            echo "<TR><TD colspan=4>No hay asignaturas asignadas.</TD></TR>";

        }

		mysqli_free_result($result);

	}

}

function procesarCambiosAsignatura() {

    global $conn;

    if(isset($_GET['operacion'])&&$_GET['operacion']=="eliminar"&&!$_POST['procesar']=="Guardar Cambios") {

        $idAsig = $_GET['idAsignatura'];
        $sql = "DELETE FROM notas.asignaturas where idAsignatura=$idAsig";
        $conn->query($sql);
        
    }

    if(isset($_POST['procesar'])&&$_POST['procesar']== "Guardar Cambios") {

        if (isset($_POST['addAsig']) && $_POST['addAsig'] != "") {
            $nuidAsignatura = $_POST["addAsig"];
            $nunomAsignatura = $_POST["addNombre"];
            $uhorasSemana = $_POST["addHoras"];
            $nuidProfesor = $_POST["addProfesor"];

            $sql = "INSERT INTO notas.asignaturas (idAsignatura, nomAsignatura, horasSemana, idProfesor) VALUES ('$nuidAsignatura', '$nunomAsignatura', '$uhorasSemana', '$nuidProfesor')";
            $conn->query($sql);
        }

        $uidAsig = $_POST["idAsig"];
        $uidAsignatura = $_POST["idAsignatura"];
        $unomAsignatura = $_POST["nomAsignatura"];
        $uhorasSemana = $_POST["horasSemana"];
        $uidProf = $_POST["idProfesor"];

        for($i=0; $i<count($_POST["idAsig"]); $i++) {

            updateAsignaturas ($uidAsig[$i], $uidAsignatura[$i], $unomAsignatura[$i], $uhorasSemana[$i], $uidProf[$i]);
        
        }

    }

    $_POST = array();

}

function updateAsignaturas ($uidAsig, $uidAsignatura, $unomAsignatura, $uhorasSemana, $uidProf) {

    global $conn;

	$sql = "UPDATE notas.asignaturas SET idAsignatura='$uidAsignatura', nomAsignatura='$unomAsignatura', horasSemana='$uhorasSemana', idProfesor='$uidProf'  WHERE idAsignatura='$uidAsig'";
	$conn->query( $sql );

}

// Unidades

function displayUnidades($asignatura, $idUser, $rolUser) {

    
    global $conn;

    if ($rolUser == "admin") {

        $sql = "SELECT * FROM notas.unidades WHERE idAsignatura='$asignatura' ORDER BY numUnidad";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            $cont=0;

            echo "<table class='table table-bordered table-hover'>";
            echo "<thead class='thead-dark'><tr class='text-center'>";
            echo "        <TH>UNIDAD</TH>";
            echo "        <TH>NOMBRE</TH>";
            echo "        <TH>PESO %</TH>";
            echo "</tr></thead><tbody>";

            while ($row = $result -> fetch_assoc()) {

                echo "<TR>";
                echo "    <INPUT TYPE='hidden' name='idUnidad[$cont]' value='$row[idUnidad]'>";
                echo "    <TD><INPUT TYPE='text' name='numUnidad[$cont]' value=$row[numUnidad] size='3'></TD>";
                echo "    <TD><INPUT TYPE='text' name='nomUnidad[$cont]' value='$row[nomUnidad]' size='60'></TD>";
                echo "    <TD><INPUT TYPE='text' name='pesoUnidad[$cont]' value=$row[pesoUnidad] size='5'></TD>";
                echo "    <TD><a href='../sites/unidades.php?idAsignatura=$asignatura&operacion=eliminar&idUnidad=$row[idUnidad]'><img src='../iconos/remove32.png'></a></TD>";
                echo "    <TD><a href='../sites/instrumentos.php?idAsignatura=$asignatura&idUnidad=$row[idUnidad]'><img src='../iconos/smile.png'></a></TD>";
                echo "</TR>";
                
                $cont++;

            }

            echo "<TR>";
            echo "    <TD><INPUT TYPE='text' name='addNumero' size='3'></TD>";
            echo "    <TD><INPUT TYPE='text' name='addNombre' size='60'></TD>";
            echo "    <TD><INPUT TYPE='text' name='addPorcentaje' size='5'></TD>";
            echo "</TR>";

            echo "</tbody></table>";

            mysqli_free_result($result);

        }

    } else if ($rolUser == "profesor") {

        $sql = "SELECT * FROM notas.unidades WHERE idAsignatura='$asignatura' ORDER BY numUnidad";
        $result = $conn->query($sql);

        if ($result) {

            $cont=0;

            echo "<table class='table table-bordered table-hover'>";
            echo "<thead class='thead-dark'><tr class='text-center'>";
            echo "        <TH>UNIDAD</TH>";
            echo "        <TH>NOMBRE</TH>";
            echo "        <TH>PESO %</TH>";
            echo "</tr></thead><tbody>";

            while ($row = $result -> fetch_assoc()) {

                echo "<TR>";
                echo "    <TD><INPUT TYPE='text' readonly='readonly' name='numUnidad[$cont]' value=$row[numUnidad] size='3'></TD>";
                echo "    <TD><INPUT TYPE='text' readonly='readonly' name='nomUnidad[$cont]' value='$row[nomUnidad]' size='60'></TD>";
                echo "    <TD><INPUT TYPE='text' readonly='readonly' name='pesoUnidad[$cont]' value=$row[pesoUnidad] size='5'></TD>";
                echo "    <TD><a href='../sites/instrumentos.php?idUnidad=$row[idUnidad]'><img src='../iconos/smile.png'></a></TD>";
                echo "</TR>";
                
                $cont++;

            }

            echo "</tbody></table>";

        }

    } else {

        $sql = "SELECT * FROM notas.unidades WHERE idAsignatura='$asignatura' ORDER BY numUnidad";
        $result = $conn->query($sql);

        if ($result) {

            $cont=0;

            echo "<table class='table table-bordered table-hover'>";
            echo "<thead class='thead-dark'><tr class='text-center'>";
            echo "        <TH>UNIDAD</TH>";
            echo "        <TH>NOMBRE</TH>";
            echo "        <TH>PESO %</TH>";
            echo "</tr></thead><tbody>";

            while ($row = $result -> fetch_assoc()) {

                echo "<TR>";
                echo "    <TD><INPUT TYPE='text' readonly='readonly' name='numUnidad[$cont]' value=$row[numUnidad] size='3'></TD>";
                echo "    <TD><INPUT TYPE='text' readonly='readonly' name='nomUnidad[$cont]' value='$row[nomUnidad]' size='60'></TD>";
                echo "    <TD><INPUT TYPE='text' readonly='readonly' name='pesoUnidad[$cont]' value=$row[pesoUnidad] size='5'></TD>";
                echo "    <TD><a href='../sites/calificaciones.php?idUnidad=$row[idUnidad]'><img src='../iconos/birrete.png'></a></TD>";
                echo "</TR>";
                
                $cont++;

            }

            echo "</tbody></table>";

        }

    }

}

function procesarCambiosUnidades() {

    global $conn;

    if(isset($_GET['operacion'])&&$_GET['operacion']=="eliminar" && !$_POST['procesar']=="Guardar Cambios") {

        $unidad = $_GET['idUnidad'];
        $sql = "DELETE FROM notas.unidades WHERE idUnidad='$unidad'";
        $conn->query( $sql );

    }

    if(isset($_POST['procesar'])&&$_POST['procesar']== "Guardar Cambios") {

        if (isset($_POST['addNumero']) && $_POST['addNumero'] != "") {

            $nnumero = $_POST["addNumero"];
            $nnombre = $_POST["addNombre"];
            $nporcentaje = $_POST["addPorcentaje"];
            $asignatura = $_GET['idAsignatura'];
            $sql = "INSERT INTO notas.unidades ( numUnidad, idAsignatura, nomUnidad, pesoUnidad ) VALUES ('$nnumero', '$asignatura', '$nnombre', '$nporcentaje' )";
            $conn->query( $sql );   

        }

        $uclave = $_POST["idUnidad"];
        $unumero = $_POST["numUnidad"];
        $unombre = $_POST["nomUnidad"];
        $uporcentaje = $_POST["pesoUnidad"];

        for($i=0; $i<count($_POST["idUnidad"]); $i++) {

            updateUnidades ($uclave[$i], $unumero[$i], $unombre[$i], $uporcentaje[$i]);

        }

    }

}

function updateUnidades ($uclave, $unumero, $unombre, $uporcentaje) {

    global $conn;

	$sql = "UPDATE notas.unidades SET nomUnidad='$unombre', numUnidad='$unumero', pesoUnidad='$uporcentaje' WHERE idUnidad='$uclave'";
	$conn->query( $sql );

}

// Instrumentos


function displayInstrumentos($unidad, $idUser, $rolUser) {
    global $conn;

    if ($rolUser === "admin") {
        $result = getInstrumentosPorUnidad($unidad);

        if ($result->num_rows > 0) {
            $cont = 0;

            echo "<table class='table table-bordered table-hover'>";
            echo "<thead class='thead-dark'><tr class='text-center'>";
            echo "        <TH>UNIDAD</TH>";
            echo "        <TH>PESO %</TH>";
            echo "</tr></thead><tbody>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr class='text-center align-middle'>";
                echo "    <input type='hidden' name='idInstrumento[$cont]' value='{$row['idInstrumento']}'>";
                echo "    <td><input type='text' class='form-control' name='nomInstrumento[$cont]' value='" . htmlspecialchars($row['nomInstrumento']) . "' size='60'></td>";
                echo "    <td><input type='text' class='form-control text-center' name='pesoInstrumento[$cont]' value='{$row['pesoInstrumento']}' size='5'></td>";
                echo "    <td><a href='../sites/instrumentos.php?operacion=eliminar&idUnidad=$unidad&idInstrumento={$row['idInstrumento']}'><img src='../iconos/remove32.png' alt='Eliminar'></a></td>";
                echo "</tr>";
                $cont++;
            }

            // Extra row for adding a new instrument
            echo "<tr class='text-center'>";
            echo "    <td><input type='text' class='form-control' name='addNombre' size='60' placeholder='Nuevo instrumento'></td>";
            echo "    <td><input type='text' class='form-control text-center' name='addPorcentaje' size='5' placeholder='%'></td>";
            echo "    <td></td>";
            echo "</tr>";
            echo "</tbody>";
        }

        echo "</table></tbody>";

    } else if ($rolUser === "profesor") {

    $selectedInstrumento = isset($_POST['idInstrumento']) ? intval($_POST['idInstrumento']) : null;
    $resultInstrumentos = getInstrumentosPorUnidad($unidad);
    $calificaciones = [];

    echo "<form method='post' style='margin-bottom: 20px; text-align: center;'>";
    echo "<label for='idInstrumento'><strong>Selecciona un Instrumento:</strong></label><br>";
    echo "<select name='idInstrumento' id='idInstrumento' onchange='this.form.submit()' style='padding: 5px; width: 250px; margin-top: 10px;'>";
    echo "    <option value=''>-- Seleccione --</option>";

    while ($row = $resultInstrumentos->fetch_assoc()) {

        $selected = ($selectedInstrumento == $row['idInstrumento']) ? "selected" : "";
        echo "<option value='{$row['idInstrumento']}' $selected>" . htmlspecialchars($row['nomInstrumento']) . "</option>";
    }

    echo "</select>";
    echo "</form>";

    if ($selectedInstrumento) {
        $calificaciones = getCalificacionesPorInstrumento($selectedInstrumento);

        if (count($calificaciones) > 0) {
            echo "<table border='1' cellpadding='8' cellspacing='0' style='width: 90%; margin: 0 auto; border-collapse: collapse;'>";
            echo "<thead style='background-color: #333; color: #fff;'>";
            echo "<tr>";
            echo "    <th>Unidad</th>";
            echo "    <th>Instrumento</th>";
            echo "    <th>Usuario</th>";
            echo "    <th>Calificación</th>";
            echo "</tr>";
            echo "</thead><tbody>";

            foreach ($calificaciones as $cal) {
                echo "<tr style='text-align: center;'>";
                echo "    <td>{$cal['numUnidad']}</td>";
                echo "    <td>" . htmlspecialchars($cal['nomInstrumento']) . "</td>";
                echo "    <td>" . htmlspecialchars($cal['nomUsuario']) . "</td>";
                echo "    <td>{$cal['calificacion']}</td>";
                echo "</tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<p style='text-align: center; color: gray;'>No hay calificaciones para este instrumento.</p>";
        }
    }
    }
} 

function getInstrumentosPorUnidad($idUnidad) {

    global $conn;

    $stmt = $conn->prepare("SELECT idInstrumento, nomInstrumento FROM instrumentos WHERE idUnidad = ?");
    $stmt->bind_param("i", $idUnidad);
    $stmt->execute();
    return $stmt->get_result();
}

function getCalificacionesPorInstrumento($idInstrumento) {

    global $conn;

    $stmt = $conn->prepare("
        SELECT 
            Un.numUnidad, 
            I.nomInstrumento, 
            U.nomUsuario, 
            C.calificacion 
        FROM calificaciones AS C
        INNER JOIN instrumentos AS I ON C.idInstrumento = I.idInstrumento
        INNER JOIN usuarios AS U ON U.idUsuario = C.idUsuario
        INNER JOIN unidades AS Un ON I.idUnidad = Un.idUnidad
        WHERE I.idInstrumento = ?
    ");
    $stmt->bind_param("i", $idInstrumento);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $calificaciones = [];
    while ($row = $result->fetch_assoc()) {
        $calificaciones[] = $row;
    }
    return $calificaciones;
}

function procesarCambiosInstrumentos() {

    global $conn;

    if(isset($_GET['operacion'])&&$_GET['operacion']=="eliminar"&&!$_POST['procesar']=="Guardar Cambios") {

        $idInstrumento = $_GET['idAsignatura'];
        $sql = "DELETE FROM notas.asignaturas where idAsignatura=$idAsig";
        $conn->query($sql);
        
    }

    if(isset($_POST['procesar'])&&$_POST['procesar']== "Guardar Cambios") {

        if (isset($_POST['addAsig']) && $_POST['addAsig'] != "") {
            $nuidAsignatura = $_POST["addAsig"];
            $nunomAsignatura = $_POST["addNombre"];
            $uhorasSemana = $_POST["addHoras"];
            $nuidProfesor = $_POST["addProfesor"];

            $sql = "INSERT INTO notas.asignaturas (idAsignatura, nomAsignatura, horasSemana, idProfesor) VALUES ('$nuidAsignatura', '$nunomAsignatura', '$uhorasSemana', '$nuidProfesor')";
            $conn->query($sql);
        }

        $uidAsig = $_POST["idAsig"];
        $uidAsignatura = $_POST["idAsignatura"];
        $unomAsignatura = $_POST["nomAsignatura"];
        $uhorasSemana = $_POST["horasSemana"];
        $uidProf = $_POST["idProfesor"];

        for($i=0; $i<count($_POST["idAsig"]); $i++) {

            updateInstrumentos ($uidAsig[$i], $uidAsignatura[$i], $unomAsignatura[$i], $uhorasSemana[$i], $uidProf[$i]);
        
        }

    }

    $_POST = array();

}

function updateInstrumentos ($uidInst, $uidProf) {

    global $conn;

	$sql = "UPDATE notas.asignaturas SET idAsignatura='$uidAsignatura', nomAsignatura='$unomAsignatura', horasSemana='$uhorasSemana', idProfesor='$uidProf'  WHERE idAsignatura='$uidAsig'";
	$conn->query( $sql );

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