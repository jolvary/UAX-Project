drop database if exists notas;
create database notas;
use notas;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE usuarios (
    idUsuario INT NOT NULL AUTO_INCREMENT,
    nomUsuario VARCHAR(45) NOT NULL,
    passUsuario VARCHAR(45) NOT NULL,
    tlfUsuario VARCHAR(12) NOT NULL,
    rolUsuario VARCHAR(45) DEFAULT 'alumno',
    PRIMARY KEY (idUsuario),
    UNIQUE KEY nomUsuario_UNIQUE (tlfUsuario),
    CONSTRAINT CHK_Rol CHECK (rolUsuario IN ('admin', 'profesor', 'alumno'))
);

CREATE TABLE profesores (
    idProfesor INT NOT NULL AUTO_INCREMENT,
    nomProfesor VARCHAR(45) NOT NULL,
    tlfProfesor VARCHAR(12) NOT NULL,
    PRIMARY KEY (idProfesor),
    UNIQUE KEY nomProfesor_UNIQUE (tlfProfesor)
);

CREATE TABLE asignaturas (
    idAsignatura INT NOT NULL,
    nomAsignatura VARCHAR(45) NOT NULL,
    horasSemana INT NOT NULL,
    idProfesor INT NOT NULL,
    PRIMARY KEY (idAsignatura),
    FOREIGN KEY (idProfesor) REFERENCES profesores(idProfesor)
);

CREATE TABLE unidades (
    idUnidad INT NOT NULL,
    nomUnidad VARCHAR(45) NOT NULL,
    idAsignatura INT NOT NULL,
    numUnidad INT NOT NULL,
    pesoUnidad INT NOT NULL,
    PRIMARY KEY (idUnidad),
    FOREIGN KEY (idAsignatura) REFERENCES asignaturas(idAsignatura)
);

CREATE TABLE instrumentos (
    idInstrumento INT NOT NULL AUTO_INCREMENT,
    nomInstrumento VARCHAR(45) NOT NULL,
    idUnidad INT NOT NULL,
    pesoInstrumento INT NOT NULL,
    PRIMARY KEY (idInstrumento),
    FOREIGN KEY (idUnidad) REFERENCES unidades(idUnidad)
);

CREATE TABLE calificaciones (
    idCalificacion INT NOT NULL AUTO_INCREMENT,
    idInstrumento INT NOT NULL,
    idUsuario INT NOT NULL,
    calificacion DECIMAL(5,2) NOT NULL,
    PRIMARY KEY (idCalificacion),
    FOREIGN KEY (idInstrumento) REFERENCES instrumentos(idInstrumento),
    FOREIGN KEY (idUsuario) REFERENCES usuarios(idUsuario)
);

CREATE PROCEDURE sp_sync_profesor(IN p_nomUsuario VARCHAR(45), IN p_tlfUsuario VARCHAR(12))
BEGIN
    DECLARE v_profesor_id INT;

    -- Check if a profesor with this phone already exists
    SELECT idProfesor INTO v_profesor_id
    FROM profesores
    WHERE tlfProfesor = p_tlfUsuario
    LIMIT 1;

    IF v_profesor_id IS NULL THEN
        -- Insert new profesor
        INSERT INTO profesores (nomProfesor, tlfProfesor)
        VALUES (p_nomUsuario, p_tlfUsuario);
    ELSE
        -- Update existing profesor
        UPDATE profesores
        SET nomProfesor = p_nomUsuario
        WHERE idProfesor = v_profesor_id;
    END IF;
END;

CREATE TRIGGER after_insert_usuario_profesor
AFTER INSERT ON usuarios
FOR EACH ROW
BEGIN
    IF NEW.rolUsuario = 'profesor' THEN
        CALL sp_sync_profesor(NEW.nomUsuario, NEW.tlfUsuario);
    END IF;
END;

CREATE TRIGGER after_update_usuario_profesor
AFTER UPDATE ON usuarios
FOR EACH ROW
BEGIN
    IF NEW.rolUsuario = 'profesor' THEN
        CALL sp_sync_profesor(NEW.nomUsuario, NEW.tlfUsuario);
    END IF;
END;

USE notas;

-- Insert 31 alumnos
INSERT INTO usuarios (nomUsuario, passUsuario, tlfUsuario, rolUsuario) VALUES
('Alumno1', 'password123', '+600000001', 'alumno'),
('Alumno2', 'password123', '+600000002', 'alumno'),
('Alumno3', 'password123', '+600000003', 'alumno'),
('Alumno4', 'password123', '+600000004', 'alumno'),
('Alumno5', 'password123', '+600000005', 'alumno'),
('Alumno6', 'password123', '+600000006', 'alumno'),
('Alumno7', 'password123', '+600000007', 'alumno'),
('Alumno8', 'password123', '+600000008', 'alumno'),
('Alumno9', 'password123', '+600000009', 'alumno'),
('Alumno10', 'password123', '+600000010', 'alumno'),
('Alumno11', 'password123', '+600000011', 'alumno'),
('Alumno12', 'password123', '+600000012', 'alumno'),
('Alumno13', 'password123', '+600000013', 'alumno'),
('Alumno14', 'password123', '+600000014', 'alumno'),
('Alumno15', 'password123', '+600000015', 'alumno'),
('Alumno16', 'password123', '+600000016', 'alumno'),
('Alumno17', 'password123', '+600000017', 'alumno'),
('Alumno18', 'password123', '+600000018', 'alumno'),
('Alumno19', 'password123', '+600000019', 'alumno'),
('Alumno20', 'password123', '+600000020', 'alumno'),
('Alumno21', 'password123', '+600000021', 'alumno'),
('Alumno22', 'password123', '+600000022', 'alumno'),
('Alumno23', 'password123', '+600000023', 'alumno'),
('Alumno24', 'password123', '+600000024', 'alumno'),
('Alumno25', 'password123', '+600000025', 'alumno'),
('Alumno26', 'password123', '+600000026', 'alumno'),
('Alumno27', 'password123', '+600000027', 'alumno'),
('Alumno28', 'password123', '+600000028', 'alumno'),
('Alumno29', 'password123', '+600000029', 'alumno'),
('Alumno30', 'password123', '+600000030', 'alumno'),
('Alumno31', 'password123', '+600000031', 'alumno');

-- Insert 5 profesores
INSERT INTO usuarios (nomUsuario, passUsuario, tlfUsuario, rolUsuario) VALUES
('Profesor1', 'password123', '+700000001', 'profesor'),
('Profesor2', 'password123', '+700000002', 'profesor'),
('Profesor3', 'password123', '+700000003', 'profesor'),
('Profesor4', 'password123', '+700000004', 'profesor'),
('Profesor5', 'password123', '+700000005', 'profesor');

-- Insert 1 admin named 'jolvary'
INSERT INTO usuarios (nomUsuario, passUsuario, tlfUsuario, rolUsuario) VALUES
('jolvary', 'password123', '+800000001', 'admin');

INSERT INTO asignaturas (idAsignatura, nomAsignatura, horasSemana, idProfesor) VALUES
(0369, 'IMPLANTACIÓN DE SISTEMAS OPERATIVOS', 12, 1),
(0370, 'PLANIFICACIÓN Y ADMINISTRACIÓN DE REDES', 8, 2),
(0371, 'FUNDAMENTOS DE HARDWARE', 6, 3),
(0372, 'GESTIÓN DE BASES DE DATOS', 8, 4),
(0373, 'LENGUAJES DE MARCAS Y SISTEMAS DE GESTIÓN DE INFORMACIÓN', 8, 4),
(0374, 'ADMINISTRACIÓN DE SISTEMAS OPERATIVOS', 12, 1),
(0375, 'SERVICIOS DE RED E INTERNET', 8, 2),
(0376, 'IMPLANTACIÓN DE APLICACIONES WEB', 8, 4),
(0377, 'ADMINSTRACIÓN DE SISTEMAS GESTORES DE BASES DE DATOS', 8, 4),
(0378, 'SEGURIDAD Y ALTA DISPONIBILIDAD', 6, 3);

INSERT INTO unidades (idUnidad, numUnidad, pesoUnidad, nomUnidad, idAsignatura) VALUES
(1, 1, 20, 'Instalación de sistemas operativos', 0369),
(2, 2, 10,'Configuración del software de base', 0369),
(3, 3, 10,'Copias de seguridad y sistemas tolerantes a fallos', 0369),
(4, 4, 5,'Centralización de la información en servidores', 0369),
(5, 5, 5, 'Administración de acceso a dominios', 0369),
(6, 6, 10, 'Detección problemas de rendimiento', 0369),
(7, 7, 10, 'Auditoría de la utilización y acceso a los recursos', 0369),
(8, 8, 10, 'Implantación de software específico', 0369),

(9, 1, 14.29, 'Planificación de redes', 0370),
(10, 2, 14.29, 'Instalación de redes', 0370),
(11, 3, 14.29, 'Configuración de redes', 0370),
(12, 4, 14.29, 'Mantenimiento de redes', 0370),
(13, 5, 14.29, 'Gestión de la seguridad en redes', 0370),
(14, 6, 14.29, 'Gestión de la calidad en redes', 0370),
(15, 7, 14.29, 'Gestión de la documentación técnica', 0370),

(16, 1, 16.67, 'Instalación y configuración de equipos microinformáticos', 0371),
(17, 2, 16.67, 'Mantenimiento de equipos microinformáticos', 0371),
(18, 3, 16.67, 'Instalación y configuración de sistemas operativos en clientes', 0371),
(19, 4, 16.67, 'Mantenimiento de sistemas operativos en clientes', 0371),
(20, 5, 16.67, 'Instalación y configuración de aplicaciones informáticas', 0371),
(21, 6, 16.67, 'Mantenimiento de aplicaciones informáticas', 0371),

(22, 1, 20, 'Instalación y configuración de sistemas gestores de bases de datos', 0372),
(23, 2, 20, 'Mantenimiento de sistemas gestores de bases de datos', 0372),
(24, 3, 20, 'Gestión de la seguridad en bases de datos', 0372),
(25, 4, 20, 'Gestión de la calidad en bases de datos', 0372),
(26, 5, 20, 'Gestión de la documentación técnica en bases de datos', 0372),

(27, 1, 20, 'Creación y gestión de páginas web estáticas', 0373),
(28, 2, 20, 'Creación y gestión de páginas web dinámicas', 0373),
(29, 3, 20, 'Creación y gestión de aplicaciones web', 0373),
(30, 4, 20, 'Gestión del servidor web', 0373),
(31, 5, 20, 'Gestión del servidor de aplicaciones', 0373),

(32, 1, 25, 'Instalación y configuración de sistemas gestores de bases de datos orientados a objetos', 0377),
(33, 2, 25, 'Mantenimiento de sistemas gestores de bases de datos orientados a objetos', 0377),
(34, 3, 25, 'Gestión del rendimiento en sistemas gestores de bases de datos orientados a objetos', 0377),
(35, 4, 25, 'Gestión del servidor web para sistemas gestores de bases de datos orientados a objetos', 0377),

(36, 1, 20, 'Planificación y gestión del sistema informático', 0378),
(37, 2, 20, 'Implantación y mantenimiento del sistema informático', 0378),
(38, 3, 20, 'Gestión de la seguridad del sistema informático', 0378),
(39, 4, 20, 'Gestión de la calidad del sistema informático', 0378),
(40, 5, 20, 'Gestión de la documentación técnica del sistema informático', 0378);

INSERT INTO instrumentos (idInstrumento, nomInstrumento, idUnidad, pesoInstrumento) VALUES
(1, 'Se han identificado los elementos funcionales de un sistema informático.', 1, 1),
(2, 'Se han identificado las características, funciones y arquitectura de un sistema operativo.', 1, 1.5),
(3, 'Se han comparado diferentes sistemas operativos, sus versiones y licencias de uso, en función de sus requisitos, características y campos de aplicación.', 1, 2),
(4, 'Se han realizado instalaciones de diferentes sistemas operativos.', 1, 4),
(5, 'Se han previsto y aplicado técnicas de actualización y recuperación del sistema.', 1, 3.5),
(6, 'Se han solucionado incidencias del sistema y del proceso de inicio.', 1, 3.5),
(7, 'Se han utilizado herramientas para conocer el software instalado en el sistema y su origen.', 1, 2),
(8, 'Se ha elaborado documentación de soporte relativa a las instalaciones efectuadas y a las incidencias detectadas.', 1, 2.5),

(9, 'Se han planificado, creado y configurado cuentas de usuario, grupos, perfiles y políticas de contraseñas locales.', 2, 2),
(10, 'Se ha asegurado el acceso al sistema mediante el uso de directivas de cuenta y directivas de contraseñas.', 2, 2),
(11, 'Se ha actuado sobre los servicios y procesos en función de las necesidades del sistema.', 2, 0.5),
(12, 'Se han instalado, configurado y verificado protocolos de red.', 2, 1),
(13, 'Se han analizado y configurado los diferentes métodos de resolución de nombres.', 2, 1),
(14, 'Se ha optimizado el uso de los sistemas operativos para sistemas portátiles.', 2, 0.5),
(15, 'Se han utilizado máquinas virtuales para realizar tareas de configuración de sistemas operativos y analizar sus resultados.', 2, 1),
(16, 'Se han documentado las tareas de configuración del software de base.', 2, 1),

(17, 'Se han comparado diversos sistemas de archivos y analizado sus diferencias y ventajas de implementación.', 3, 1),
(18, 'Se ha descrito la estructura de directorios del sistema operativo.', 3, 1),
(19, 'Se han identificado los directorios contenedores de los archivos de configuración del sistema (binarios, órdenes y librerías).', 3, 1),
(20, 'Se han utilizado herramientas de administración de discos para crear particiones, unidades lógicas, volúmenes simples y volúmenes distribuidos.', 3, 2),
(21, 'Se han implantado sistemas de almacenamiento redundante (RAID).', 3, 1),
(22, 'Se han implementado y automatizado planes de copias de seguridad.', 3, 2),
(23, 'Se han administrado cuotas de disco.', 3, 1),
(24, 'Se han documentado las operaciones realizadas y los métodos a seguir para la recuperación ante desastres.', 3, 1),

(25, 'Se han implementado dominios.', 4, 1),
(26, 'Se han administrado cuentas de usuario y cuentas de equipo.', 4, 1),
(27, 'Se ha centralizado la información personal de los usuarios del dominio mediante el uso de perfiles móviles y carpetas personales.', 4, 0.5),
(28, 'Se han creado y administrado grupos de seguridad.', 4, 0.5),
(29, 'Se han creado plantillas que faciliten la administración de usuarios con características similares.', 4, 0.5),
(30, 'Se han organizado los objetos del dominio para facilitar su administración.', 4, 0.5),
(31, 'Se han utilizado máquinas virtuales para administrar dominios y verificar su funcionamiento.', 4, 0.5),
(32, 'Se ha documentado la estructura del dominio y las tareas realizadas.', 4, 0.5),

(33, 'Se han incorporado equipos al dominio.', 5, 1),
(34, 'Se han previsto bloqueos de accesos no autorizados al dominio.', 5, 0.5),
(35, 'Se ha administrado el acceso a recursos locales y recursos de red.', 5, 1),
(36, 'Se han tenido en cuenta los requerimientos de seguridad.', 5, 1),
(37, 'Se han implementado y verificado directivas de grupo.', 5, 0.5),
(38, 'Se han asignado directivas de grupo.', 5, 0.5),
(39, 'Se han documentado las tareas y las incidencias.', 5, 0.5),

(40, 'Se han identificado los objetos monitorizables en un sistema informático.', 6, 1),
(41, 'Se han identificado los tipos de sucesos.', 6, 1),
(42, 'Se han utilizado herramientas de monitorización en tiempo real.', 6, 2),
(43, 'Se ha monitorizado el rendimiento mediante registros de contador y de seguimiento del sistema.', 6, 2),
(44, 'Se han planificado y configurado alertas de rendimiento.', 6, 1),
(45, 'Se han interpretado los registros de rendimiento almacenados.', 6, 1),
(46, 'Se ha analizado el sistema mediante técnicas de simulación para optimizar el rendimiento.', 6, 1),
(47, 'Se ha elaborado documentación de soporte y de incidencias.', 6, 1),

(48, 'Se han administrado derechos de usuario y directivas de seguridad.', 7, 2),
(49, 'Se han identificado los objetos y sucesos auditables.', 7, 1),
(50, 'Se ha elaborado un plan de auditorías.', 7, 1),
(51, 'Se han identificado las repercusiones de las auditorías en el rendimiento del sistema.', 7, 1),
(52, 'Se han auditado sucesos correctos y erróneos.', 7, 1),
(53, 'Se han auditado los intentos de acceso y los accesos a recursos del sistema.', 7, 2),
(54, 'Se han gestionado los registros de auditoría.', 7, 2),
(55, 'Se ha documentado el proceso de auditoría y sus resultados.', 7, 2),

(56, 'Se han administrado derechos de usuario y directivas de seguridad.', 8, 2),
(57, 'Se han identificado los objetos y sucesos auditables.', 8, 1),
(58, 'Se ha elaborado un plan de auditorías.', 8, 1),
(59, 'Se han identificado las repercusiones de las auditorías en el rendimiento del sistema.', 8, 1),
(60, 'Se han auditado sucesos correctos y erróneos.', 8, 1),
(61, 'Se han auditado los intentos de acceso y los accesos a recursos del sistema.', 8, 2),
(62, 'Se han gestionado los registros de auditoría.', 8, 1),
(63, 'Se ha documentado el proceso de auditoría y sus resultados.', 8, 1);

INSERT INTO calificaciones (idInstrumento, idUsuario, calificacion) VALUES
(1, 1, 8.5),
(2, 1, 9.0),
(3, 1, 7.5),
(4, 1, 6.0),
(5, 1, 8.0),
(6, 1, 9.5),
(7, 1, 10.0),
(8, 1, 7.0),
(9, 1, 8.0),
(10, 1, 9.0),
(11, 1, 6.5),
(12, 1, 7.5),
(13, 1, 8.5),
(14, 1, 9.0),
(15, 1, 10.0),
(16, 1, 7.0),
(17, 1, 8.0),
(18, 1, 9.5),
(19, 1, 6.0),
(20, 1, 7.5),
(21, 1, 8.5),
(22, 1, 9.0),
(23, 1, 10.0),
(24, 1, 7.0),
(25, 1, 8.0),
(26, 1, 9.5),
(27, 1, 6.0),
(28, 1, 7.5),
(29, 1, 8.5),
(30, 1, 9.0),
(31, 1, 10.0),
(32, 1, 7.0),
(33, 1, 8.0),
(34, 1, 9.5),
(35, 1, 6.0),
(36, 1, 7.5),
(37, 1, 8.5),
(38, 1, 9.0),
(39, 1, 10.0),
(40, 1, 7.0),
(41, 1, 8.0),
(42, 1, 9.5),
(43, 1, 6.0),
(44, 1, 7.5),
(45, 1, 8.5),
(46, 1, 9.0),
(47, 1, 10.0),
(48, 1, 7.0),
(49, 1, 8.0),
(50, 1, 9.5),
(51, 1, 6.0),
(52, 1, 7.5),
(53, 1, 8.5),
(54, 1, 9.0),
(55, 1, 10.0),
(56, 1, 7.0),
(57, 1, 8.0),
(58, 1, 9.5),
(59, 1, 6.0),
(60, 1, 7.5),
(61, 1, 8.5),
(62, 1, 9.0),
(63, 1, 10.0),
(64, 2, 8.5),
(65, 2, 9.0),
(66, 2, 7.5),
(67, 2, 6.0),
(68, 2, 8.0),
(69, 2, 9.5),
(70, 2, 10.0),
(71, 2, 7.0),
(72, 2, 8.0),
(73, 2, 9.0),
(74, 2, 6.5),
(75, 2, 7.5),
(76, 2, 8.5),
(77, 2, 9.0),
(78, 2, 10.0),
(79, 2, 7.0),
(80, 2, 8.0),
(81, 2, 9.5),
(82, 2, 6.0),
(83, 2, 7.5),
(84, 2, 8.5),
(85, 2, 9.0),
(86, 2, 10.0),
(87, 2, 7.0),
(88, 2, 8.0),
(89, 2, 9.5),
(90, 2, 6.0),
(91, 2, 7.5),
(92, 2, 8.5),
(93, 2, 9.0),
(94, 2, 10.0),
(95, 2, 7.0),
(96, 2, 8.0),
(97, 2, 9.5),
(98, 2, 6.0),
(99, 2, 7.5),
(100, 2, 8.5),
(101, 2, 9.0),
(102, 2, 10.0),
(103, 2, 7.0),
(104, 2, 8.0),
(105, 2, 9.5),
(106, 2, 6.0),
(107, 2, 7.5),
(108, 2, 8.5),
(109, 2, 9.0),
(110, 2, 10.0),
(111, 2, 7.0),
(112, 2, 8.0),
(113, 2, 9.5),
(114, 2, 6.0),
(115, 2, 7.5),
(116, 2, 8.5),
(117, 2, 9.0),
(118, 2, 10.0),
(119, 2, 7.0),
(120, 2, 8.0),
(121, 2, 9.5),
(122, 2, 6.0),
(123, 2, 7.5),
(124, 2, 8.5),
(125, 2, 9.0),
(126, 2, 10.0),
(127, 3, 4.0),
(128, 3, 3.5),
(129, 3, 2.5),
(130, 3, 1.0),
(131, 3, 4.5),
(132, 3, 3.0),
(133, 3, 2.0),
(134, 3, 4.0),
(135, 3, 3.5),
(136, 3, 2.0),
(137, 3, 1.5),
(138, 3, 2.5),
(139, 3, 3.0),
(140, 3, 4.0),
(141, 3, 4.5),
(142, 3, 2.0),
(143, 3, 3.5),
(144, 3, 4.0),
(145, 3, 3.0),
(146, 3, 1.5),
(147, 3, 2.5),
(148, 3, 3.5),
(149, 3, 4.0),
(150, 3, 4.5),
(151, 3, 3.0),
(152, 3, 2.0),
(153, 3, 1.5),
(154, 3, 3.5),
(155, 3, 4.0),
(156, 3, 3.5),
(157, 3, 2.5),
(158, 3, 4.0),
(159, 3, 4.5),
(160, 3, 3.0),
(161, 3, 2.0),
(162, 3, 3.5),
(163, 3, 4.0),
(164, 3, 2.5),
(165, 3, 3.0),
(166, 3, 4.0),
(167, 3, 3.5),
(168, 3, 4.5),
(169, 3, 2.0),
(170, 3, 3.0),
(171, 3, 4.0),
(172, 3, 3.5),
(173, 3, 2.5),
(174, 3, 4.0),
(175, 3, 3.0),
(176, 3, 4.5),
(177, 3, 2.0),
(178, 3, 3.5),
(179, 3, 4.0),
(180, 3, 3.0),
(181, 3, 2.5),
(182, 3, 4.0),
(183, 3, 3.5),
(184, 3, 4.5),
(185, 3, 2.0),
(186, 3, 3.0),
(187, 3, 4.0),
(188, 3, 3.5),
(189, 3, 2.5);
