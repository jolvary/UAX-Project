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
    rolUsuario VARCHAR(45) NOT NULL,
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
    idAsignatura INT NOT NULL AUTO_INCREMENT,
    nomAsignatura VARCHAR(45) NOT NULL,
    horasSemana INT NOT NULL,
    idProfesor INT NOT NULL,
    PRIMARY KEY (idAsignatura),
    FOREIGN KEY (idProfesor) REFERENCES profesores(idProfesor)
);

CREATE TABLE unidades (
    idUnidad INT NOT NULL AUTO_INCREMENT,
    nomUnidad VARCHAR(45) NOT NULL,
    idAsignatura INT NOT NULL,
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

-- Usuarios
INSERT INTO usuarios (nomUsuario, passUsuario, tlfUsuario, rolUsuario) VALUES
('admin1', 'adminpass', '+123456789', 'admin'),
('profesor1', 'profepass', '+234567890', 'profesor'),
('alumno1', 'alumnopass', '+345678901', 'alumno'),
('alumno2', 'alumnopass', '+456789012', 'alumno'),
('jolvary', 'hola', '+34661076008', 'admin');

-- Profesores
INSERT INTO profesores (nomProfesor, tlfProfesor) VALUES
('Juan Pérez', '+987654321'),
('Ana López', '+876543210');

-- Asignaturas
INSERT INTO asignaturas (nomAsignatura, horasSemana, idProfesor) VALUES
('Implantación de Sistemas Operativos', 5, 1),
('Planificación y Administración de Redes', 4, 2),
('Fundamentos de Hardware', 3, 1);

-- Unidades
INSERT INTO unidades (nomUnidad, idAsignatura) VALUES
('RA1: Instalación de Sistemas Operativos', 1),
('RA2: Configuración del Software de Base', 1),
('RA3: Aseguramiento del Sistema', 1),
('RA1: Reconocimiento de la estructura de redes', 2),
('RA2: Integración de ordenadores en redes', 2),
('RA1: Configuración de equipos microinformáticos', 3);

-- Instrumentos de evaluación
INSERT INTO instrumentos (nomInstrumento, idUnidad, pesoInstrumento) VALUES
('Prueba teórica RA1', 1, 25),
('Práctica de instalación RA1', 1, 25),
('Rúbrica RA1', 1, 50),
('Prueba teórica RA2', 2, 50),
('Práctica de configuración RA2', 2, 50),
('Prueba teórica RA3', 3, 40),
('Práctica de backup RA3', 3, 60),
('Prueba teórica redes RA1', 4, 70),
('Práctica redes RA1', 4, 30);

-- Calificaciones
INSERT INTO calificaciones (idInstrumento, idUsuario, calificacion) VALUES
(1, 3, 7.5),
(2, 3, 8.0),
(3, 3, 9.0),
(4, 4, 6.5),
(5, 4, 7.0),
(6, 3, 8.5),
(7, 3, 8.0),
(8, 4, 7.5),
(9, 4, 8.0);
