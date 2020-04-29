
DROP SCHEMA IF EXISTS `mundo_balonmano` ;

-- -----------------------------------------------------
-- Schema mundo_balonmano
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mundo_balonmano` DEFAULT CHARACTER SET utf8 ;
USE `mundo_balonmano` ;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`continentes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`continentes` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`continentes` (
  `Id_Continente` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Id_Continente`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`paises`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`paises` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`paises` (
  `Id_Pais` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Codigo` VARCHAR(3) NOT NULL,
  `Nombre` VARCHAR(45) NOT NULL,
  `Nacionalidad` VARCHAR(64) NOT NULL,
  `Continente` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`Id_Pais`),
  UNIQUE INDEX `Codigo_UNIQUE` (`Codigo` ASC),
  INDEX `fk3_Continentes` (`Continente`),
  CONSTRAINT `fk3_Continentes`
  FOREIGN KEY (`Continente`)
  REFERENCES `mundo_balonmano`.`continentes` (`Id_Continente`)
  ON DELETE RESTRICT
  ON UPDATE CASCADE )
  
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`autonomias` (
  `Id_Autonomia` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(45) NOT NULL,
  `Pais` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`Id_Autonomia`),
  INDEX `fk6_Paises` (`Pais`),
  CONSTRAINT `fk6_Paises`
  FOREIGN KEY (`Pais`)
  REFERENCES `mundo_balonmano`.`paises` (`Id_Pais`)
  ON DELETE RESTRICT
  ON UPDATE CASCADE )
  
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`clubs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`clubs` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`clubs` (
  `Id_Club` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Nombre_Completo` VARCHAR(60) NOT NULL,
  `Nombre_Corto` VARCHAR(45) NULL,
  `Pais` INT UNSIGNED NOT NULL,
  `Fundacion` VARCHAR(4) NOT NULL,
  PRIMARY KEY (`Id_Club`),
  INDEX `fk2_Paises` (`Pais` ASC),
  CONSTRAINT `fk2_Paises`
    FOREIGN KEY (`Pais`)
    REFERENCES `mundo_balonmano`.`paises` (`Id_Pais`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS tipos_competicion (
Id_Tipo_Competicion INT UNSIGNED NOT NULL AUTO_INCREMENT,
Tipo_Competicion VARCHAR(45) NOT NULL,
Descripcion VARCHAR(128) NULL,
PRIMARY KEY(Id_Tipo_Competicion)
);
-- -----------------------------------------------------
-- Table `mundo_balonmano`.`competiciones`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`competiciones` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`competiciones` (
  `Id_Competicion` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(45) NOT NULL,
  `Nivel` INT NOT NULL,
  `Pais` INT UNSIGNED NULL,
  `Reputacion` INT NOT NULL,
  `Autonomia` INT UNSIGNED NULL,
  `Continente` INT UNSIGNED NULL,
  `Tipo_Competicion` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`Id_Competicion`),
  INDEX `fk1_Paises` (`Pais` ASC),
  INDEX `fk1_Continentes` (`Continente` ASC),
  INDEX `fk1_Tipo_Competicion`(`Tipo_Competicion`),
  INDEX `fk1_Autonomias` (`Autonomia`),
  CONSTRAINT `fk1_Autonomias`
    FOREIGN KEY (`Autonomia`)
    REFERENCES `mundo_balonmano`.`autonomias` (`Id_Autonomia`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk1_Paises`
    FOREIGN KEY (`Pais`)
    REFERENCES `mundo_balonmano`.`paises` (`Id_Pais`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk1_Continentes`
    FOREIGN KEY (`Continente`)
    REFERENCES `mundo_balonmano`.`continentes` (`Id_Continente`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
    CONSTRAINT `fk1_Tipo_Competicion`
    FOREIGN KEY (`Tipo_Competicion`)
    REFERENCES `mundo_balonmano`.`tipos_competicion` (`Id_Tipo_Competicion`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`puestos_cuerpo_tecnico`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`puestos_cuerpo_tecnico` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`puestos_cuerpo_tecnico` (
  `Id_Puesto_Cuerpo_Tecnico` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Puesto` VARCHAR(45) NOT NULL,
  `Descripcion` VARCHAR(128) NULL DEFAULT NULL,
  PRIMARY KEY (`Id_Puesto_Cuerpo_Tecnico`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`tipos_contrato`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`tipos_contrato` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`tipos_contrato` (
  `Id_Tipo_Contrato` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Tipo_Contrato` VARCHAR(45) NOT NULL,
  `Descripcion` VARCHAR(128) NULL DEFAULT NULL,
  PRIMARY KEY (`Id_Tipo_Contrato`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`Tipos_Equipo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`Tipos_Equipo` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`Tipos_Equipo` (
  `Id_Tipo_Equipo` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Tipo` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Id_Tipo_Equipo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`equipos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`equipos` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`equipos` (
  `Id_Equipo` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Club` INT UNSIGNED NOT NULL,
  `Tipo_Equipo` INT UNSIGNED NOT NULL,
  `Competicion` INT UNSIGNED NOT NULL,
  `Genero` ENUM('M','F') NOT NULL,
  `Reputacion` INT NOT NULL,
  `Fecha_Sin_Entrenador` DATETIME NOT NULL DEFAULT NOW(),
  PRIMARY KEY (`Id_Equipo`),
  INDEX `fk1_clubs` (`Club` ASC) ,
  INDEX `fk1_Tipos_Equipo` (`Tipo_Equipo` ASC) ,
  INDEX `fk4_Competiciones` (`Competicion` ASC) ,
  CONSTRAINT `fk1_clubs`
    FOREIGN KEY (`Club`)
    REFERENCES `mundo_balonmano`.`clubs` (`Id_Club`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk1_Tipos_Equipo`
    FOREIGN KEY (`Tipo_Equipo`)
    REFERENCES `mundo_balonmano`.`Tipos_Equipo` (`Id_Tipo_Equipo`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk4_Competiciones`
    FOREIGN KEY (`Competicion`)
    REFERENCES `mundo_balonmano`.`competiciones` (`Id_Competicion`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`cuerpo_tecnico`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`cuerpo_tecnico` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`cuerpo_tecnico` (
  `Id_Cuerpo_Tecnico` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(45) NOT NULL,
  `Apellido1` VARCHAR(45) NOT NULL,
  `Apellido2` VARCHAR(45) NULL,
  `Apodo` VARCHAR(45) NULL,
  `Fecha_Nacimiento` DATE NOT NULL,
  `Genero` ENUM('M','F') NOT NULL,
  `Ultimo_Cambio_Equipo` DATETIME DEFAULT NOW(),
  `Twitter` VARCHAR(128) NULL,
  `Facebook` VARCHAR(128) NULL,
  `Instagram` VARCHAR(128) NULL,
  `Pais` INT UNSIGNED NOT NULL,
  `Reputacion` INT NOT NULL,
  `Puesto` INT UNSIGNED NOT NULL,
  `Tipo_Contrato` INT UNSIGNED NOT NULL,
  `Equipo_Actual` INT UNSIGNED NULL,
  PRIMARY KEY (`Id_Cuerpo_Tecnico`),
  INDEX `fk3_Paises` (`Pais` ASC) ,
  INDEX `fk1_Puestos` (`Puesto` ASC) ,
  INDEX `fk1_Tipos_Contrato` (`Tipo_Contrato` ASC) ,
  INDEX `fk2_Equipos` (`Equipo_Actual` ASC) ,
  CONSTRAINT `fk1_Puestos`
    FOREIGN KEY (`Puesto`)
    REFERENCES `mundo_balonmano`.`puestos_cuerpo_tecnico` (`Id_Puesto_Cuerpo_Tecnico`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk1_Tipos_Contrato`
    FOREIGN KEY (`Tipo_Contrato`)
    REFERENCES `mundo_balonmano`.`tipos_contrato` (`Id_Tipo_Contrato`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk3_Paises`
    FOREIGN KEY (`Pais`)
    REFERENCES `mundo_balonmano`.`paises` (`Id_Pais`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk2_Equipos`
    FOREIGN KEY (`Equipo_Actual`)
    REFERENCES `mundo_balonmano`.`equipos` (`Id_Equipo`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`temporadas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`temporadas` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`temporadas` (
  `Id_Temporada` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Temporada` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Id_Temporada`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`jugadores`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`jugadores` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`jugadores` (
  `Id_Jugador` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(45) NOT NULL,
  `Apellido1` VARCHAR(45) NOT NULL,
  `Apellido2` VARCHAR(45) NULL,
  `Apodo` VARCHAR(45) NULL,
  `Fecha_Nacimiento` DATE NOT NULL,
	`Genero` ENUM('M','F') NOT NULL,
	`Reputacion` INT NOT NULL,
  `Inicio_Contrato` DATE NULL DEFAULT NULL,
  `Fin_Contrato` DATE NULL DEFAULT NULL,
  `Ultimo_Cambio_Equipo` DATETIME DEFAULT NOW(),
  `Twitter` VARCHAR(128) NULL,
  `Facebook` VARCHAR(128) NULL,
  `Instagram` VARCHAR(128) NULL,
  `Pais` INT UNSIGNED NOT NULL,
  `Tipo_Contrato` INT UNSIGNED NOT NULL,
  `Equipo_Actual` INT UNSIGNED NULL,
  PRIMARY KEY (`Id_Jugador`),
  INDEX `fk4_Paises` (`Pais` ASC) ,
  INDEX `fk2_Tipos_Contrato` (`Tipo_Contrato` ASC) ,
  INDEX `fk3_Equipos` (`Equipo_Actual` ASC) ,
  CONSTRAINT `fk2_Tipos_Contrato`
    FOREIGN KEY (`Tipo_Contrato`)
    REFERENCES `mundo_balonmano`.`tipos_contrato` (`Id_Tipo_Contrato`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk4_Paises`
    FOREIGN KEY (`Pais`)
    REFERENCES `mundo_balonmano`.`paises` (`Id_Pais`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk3_Equipos`
    FOREIGN KEY (`Equipo_Actual`)
    REFERENCES `mundo_balonmano`.`equipos` (`Id_Equipo`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`estadisticas_jugadores`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`estadisticas_jugadores` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`estadisticas_jugadores` (
  `Id_Estadistica_Jugador` INT NOT NULL AUTO_INCREMENT,
  `Goles` INT NOT NULL,
  `Perdidas` INT NOT NULL,
  `Recuperaciones` INT NOT NULL,
  `Temporada` INT UNSIGNED NOT NULL,
  `Jugador` INT UNSIGNED NOT NULL,
  `Competicion` INT UNSIGNED NOT NULL,
  `Equipo` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`Id_Estadistica_Jugador`),
  INDEX `fk4_Temporadas` (`Temporada` ASC) ,
  INDEX `fk5_Jugadores` (`Jugador` ASC) ,
  INDEX `fk5_Competiciones` (`Competicion` ASC) ,
  INDEX `fk11_Equipos` (`Equipo` ASC) ,
  CONSTRAINT `fk11_Equipos`
    FOREIGN KEY (`Equipo`)
    REFERENCES `mundo_balonmano`.`equipos` (`Id_Equipo`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk4_Temporadas`
    FOREIGN KEY (`Temporada`)
    REFERENCES `mundo_balonmano`.`temporadas` (`Id_Temporada`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk5_Jugadores`
    FOREIGN KEY (`Jugador`)
    REFERENCES `mundo_balonmano`.`jugadores` (`Id_Jugador`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk5_Competiciones`
    FOREIGN KEY (`Competicion`)
    REFERENCES `mundo_balonmano`.`competiciones` (`Id_Competicion`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`historico_clubs_competicion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`historico_equipos_competiciones` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`historico_equipos_competiciones` (
  `Id_Equipo_Competicion` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Competicion` INT UNSIGNED NOT NULL,
  `Temporada` INT UNSIGNED NOT NULL,
  `Equipo` INT UNSIGNED NOT NULL,
  `Puesto_Final` VARCHAR(4) NULL,
  `Ganados` INT NOT NULL DEFAULT 0,
  `Empatados` INT NOT NULL DEFAULT 0,
  `Perdidos` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id_Equipo_Competicion`),
  INDEX `fk3_Competiciones` (`Competicion` ASC) ,
  INDEX `fk3_Temporadas` (`Temporada` ASC) ,
  INDEX `fk4_Equipos` (`Equipo` ASC) ,
  CONSTRAINT `fk3_Competiciones`
    FOREIGN KEY (`Competicion`)
    REFERENCES `mundo_balonmano`.`competiciones` (`Id_Competicion`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk3_Temporadas`
    FOREIGN KEY (`Temporada`)
    REFERENCES `mundo_balonmano`.`temporadas` (`Id_Temporada`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk4_Equipos`
    FOREIGN KEY (`Equipo`)
    REFERENCES `mundo_balonmano`.`equipos` (`Id_Equipo`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`historico_clubs_cuerpo_tecnico`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`historico_equipos_cuerpo_tecnico` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`historico_equipos_cuerpo_tecnico` (
  `Id_Equipo_Cuerpo_Tecnico` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Equipo` INT UNSIGNED NOT NULL,
  `Temporada` INT UNSIGNED NOT NULL,
  `Cuerpo_Tecnico` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`Id_Equipo_Cuerpo_Tecnico`),
  INDEX `fk10_Equipos` (`Equipo` ASC) ,
  INDEX `fk2_Temporadas` (`Temporada` ASC) ,
  INDEX `fk1_Cuerpo_Tecnico` (`Cuerpo_Tecnico` ASC) ,
  CONSTRAINT `fk1_Cuerpo_Tecnico`
    FOREIGN KEY (`Cuerpo_Tecnico`)
    REFERENCES `mundo_balonmano`.`cuerpo_tecnico` (`Id_Cuerpo_Tecnico`)
    ON DELETE CASCADE
    ON UPDATE RESTRICT,
  CONSTRAINT `fk2_Temporadas`
    FOREIGN KEY (`Temporada`)
    REFERENCES `mundo_balonmano`.`temporadas` (`Id_Temporada`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk10_Equipos`
    FOREIGN KEY (`Equipo`)
    REFERENCES `mundo_balonmano`.`equipos` (`Id_Equipo`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`historico_clubs_jugadores`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`historico_equipos_jugadores` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`historico_equipos_jugadores` (
  `Id_Equipo_Jugador` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Jugador` INT UNSIGNED NOT NULL,
  `Temporada` INT UNSIGNED NOT NULL,
  `Equipo` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`Id_Equipo_Jugador`),
  INDEX `fk1_Jugadores` (`Jugador` ASC) ,
  INDEX `fk1_Temporadas` (`Temporada` ASC) ,
  INDEX `fk5_Equipos` (`Equipo` ASC) ,
  CONSTRAINT `fk1_Jugadores`
    FOREIGN KEY (`Jugador`)
    REFERENCES `mundo_balonmano`.`jugadores` (`Id_Jugador`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk1_Temporadas`
    FOREIGN KEY (`Temporada`)
    REFERENCES `mundo_balonmano`.`temporadas` (`Id_Temporada`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk5_Equipos`
    FOREIGN KEY (`Equipo`)
    REFERENCES `mundo_balonmano`.`equipos` (`Id_Equipo`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`historico_fichajes_cuerpo_tecnico`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`historico_fichajes_cuerpo_tecnico` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`historico_fichajes_cuerpo_tecnico` (
  `Id_Fichaje_Cuerpo_Tecnico` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Fecha_Inicio` DATE NOT NULL,
  `Fecha_Fin` DATE NULL DEFAULT NULL,
  `Cuerpo_Tecnico` INT UNSIGNED NOT NULL,
  `Equipo_Emisor` INT UNSIGNED NOT NULL,
  `Equipo_Receptor` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`Id_Fichaje_Cuerpo_Tecnico`),
  INDEX `fk2_Cuerpo_Tecnico` (`Cuerpo_Tecnico` ASC) ,
  INDEX `fk6_Equipos` (`Equipo_Emisor` ASC) ,
  INDEX `fk7_Equipos` (`Equipo_Receptor` ASC) ,
  CONSTRAINT `fk2_Cuerpo_Tecnico`
    FOREIGN KEY (`Cuerpo_Tecnico`)
    REFERENCES `mundo_balonmano`.`cuerpo_tecnico` (`Id_Cuerpo_Tecnico`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk6_Equipos`
    FOREIGN KEY (`Equipo_Emisor`)
    REFERENCES `mundo_balonmano`.`equipos` (`Id_Equipo`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk7_Equipos`
    FOREIGN KEY (`Equipo_Receptor`)
    REFERENCES `mundo_balonmano`.`equipos` (`Id_Equipo`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`historico_fichajes_jugadores`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`historico_fichajes_jugadores` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`historico_fichajes_jugadores` (
  `Id_Fichaje_Jugador` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Fecha_Inicio` DATE NOT NULL,
  `Fecha_Fin` DATE NULL DEFAULT NULL,
  `Jugador` INT UNSIGNED NOT NULL,
  `Equipo_Emisor` INT UNSIGNED NOT NULL,
  `Equipo_Receptor` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`Id_Fichaje_Jugador`),
  INDEX `fk2_Jugadores` (`Jugador` ASC) ,
  INDEX `fk8_Equipos` (`Equipo_Emisor` ASC) ,
  INDEX `fk9_Equipos` (`Equipo_Receptor` ASC) ,
  CONSTRAINT `fk2_Jugadores`
    FOREIGN KEY (`Jugador`)
    REFERENCES `mundo_balonmano`.`jugadores` (`Id_Jugador`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk8_Equipos`
    FOREIGN KEY (`Equipo_Emisor`)
    REFERENCES `mundo_balonmano`.`equipos` (`Id_Equipo`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk9_Equipos`
    FOREIGN KEY (`Equipo_Receptor`)
    REFERENCES `mundo_balonmano`.`equipos` (`Id_Equipo`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`puestos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`puestos` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`puestos` (
  `Id_Puesto_Jugador` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Puesto` VARCHAR(45) NOT NULL,
  `Puesto_Corto` VARCHAR(4) NOT NULL,
  `Descripcion` VARCHAR(128) NULL DEFAULT NULL,
  PRIMARY KEY (`Id_Puesto_Jugador`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`jugadores_puestos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`jugadores_puestos` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`jugadores_puestos` (
  `Jugador` INT UNSIGNED NOT NULL,
  `Puesto` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`Jugador`, `Puesto`),
  INDEX `fk2_Puestos` (`Puesto` ASC) ,
  INDEX `fk4_Jugadores` (`Jugador` ASC) ,
  CONSTRAINT `fk2_Puestos`
    FOREIGN KEY (`Puesto`)
    REFERENCES `mundo_balonmano`.`puestos` (`Id_Puesto_Jugador`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk4_Jugadores`
    FOREIGN KEY (`Jugador`)
    REFERENCES `mundo_balonmano`.`jugadores` (`Id_Jugador`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


CREATE TABLE IF NOT EXISTS `tipos_usuario` (
`Id_Tipo_Usuario` INT UNSIGNED NOT NULL AUTO_INCREMENT,
`Tipo_Usuario` VARCHAR(45) NOT NULL,
`Descripcion` VARCHAR(255) NULL,
PRIMARY KEY (Id_Tipo_Usuario)

);

CREATE TABLE IF NOT EXISTS `usuarios` (
`Id_Usuario` INT UNSIGNED NOT NULL AUTO_INCREMENT,
`Nombre` VARCHAR(64) NOT NULL,
`Apellido1` VARCHAR(64) NOT NULL,
`Apellido2` VARCHAR(64) NOT NULL,
`Email` VARCHAR(255) NOT NULL,
`Contraseña` VARCHAR(255) NOT NULL,
`Confirmacion` VARCHAR(255) NOT NULL,
`Caducidad_Suscripcion` DATE NULL,
`Estado` ENUM('NC','C','D') NOT NULL DEFAULT 'NC',
`Tipo_Usuario` INT UNSIGNED NOT NULL,
PRIMARY KEY (`Id_Usuario`),
INDEX `fk1_Tipo_Usuario` (`Tipo_Usuario`),
CONSTRAINT `fk1_Tipo_Usuario`
FOREIGN KEY (`Tipo_Usuario`)
REFERENCES `tipos_usuario` (`Id_Tipo_Usuario`)
ON UPDATE CASCADE
ON DELETE RESTRICT

);

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`noticias` (
`Id_Noticia` INT UNSIGNED NOT NULL AUTO_INCREMENT,
`Titular` VARCHAR(128) NOT NULL,
`Noticia` VARCHAR(1028) NOT NULL,
`DescripcionImagen` VARCHAR(128) NULL,
`Fecha` DATE NOT NULL DEFAULT DATE(NOW()),
`Competicion` INT UNSIGNED NOT NULL,
`Autor` INT UNSIGNED NOT NULL,
PRIMARY KEY(`Id_Noticia`),
INDEX `fk10_Competicion` (`Competicion`),
INDEX fk3_Usuario (Autor),
CONSTRAINT `fk10_Competicion`
FOREIGN KEY (`Competicion`)
REFERENCES `mundo_balonmano`.`competiciones` (`Id_Competicion`)
ON DELETE CASCADE
ON UPDATE CASCADE,
CONSTRAINT `fk3_Usuario`
FOREIGN KEY (`Autor`)
REFERENCES `mundo_balonmano`.`usuarios` (`Id_Usuario`)
ON DELETE RESTRICT
ON UPDATE CASCADE

)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;





CREATE TABLE IF NOT EXISTS favoritos_jugadores (
`Usuario` INT UNSIGNED NOT NULL,
`Jugador` INT UNSIGNED NOT NULL,
PRIMARY KEY (Usuario,Jugador),
INDEX fk1_Usuario (Usuario),
INDEX fk3_Jugador (Jugador),
CONSTRAINT fk1_Usuario
FOREIGN KEY (Usuario)
REFERENCES usuarios (Id_Usuario)
ON UPDATE CASCADE
ON DELETE CASCADE,
CONSTRAINT fk3_Jugador
FOREIGN KEY (Jugador)
REFERENCES jugadores (Id_Jugador)
ON UPDATE CASCADE
ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS favoritos_equipos (
`Usuario` INT UNSIGNED NOT NULL,
`Equipo` INT UNSIGNED NOT NULL,
PRIMARY KEY (Usuario,Equipo),
INDEX fk2_Usuario (Usuario),
INDEX fk13_Equipos (Equipo),
CONSTRAINT fk2_Usuario
FOREIGN KEY (Usuario)
REFERENCES usuarios (Id_Usuario)
ON UPDATE CASCADE
ON DELETE CASCADE,
CONSTRAINT fk13_Equipos
FOREIGN KEY (Equipo)
REFERENCES equipos (Id_Equipo)
ON UPDATE CASCADE
ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS favoritos_cuerpo_tecnico (
`Usuario` INT UNSIGNED NOT NULL,
`Cuerpo_Tecnico` INT UNSIGNED NOT NULL,
PRIMARY KEY (Usuario,Cuerpo_Tecnico),
INDEX fk4_Usuario (Usuario),
INDEX fk5_Cuerpo_Tecnico (Cuerpo_Tecnico),
CONSTRAINT fk4_Usuario
FOREIGN KEY (Usuario)
REFERENCES usuarios (Id_Usuario)
ON UPDATE CASCADE
ON DELETE CASCADE,
CONSTRAINT fk5_Cuerpo_Tecnico
FOREIGN KEY (Cuerpo_Tecnico)
REFERENCES cuerpo_tecnico (Id_Cuerpo_Tecnico)
ON UPDATE CASCADE
ON DELETE CASCADE
);






