
drop database if exists `mundo_balonmano`;
CREATE DATABASE IF NOT EXISTS `mundo_balonmano` DEFAULT CHARACTER SET utf8 ;
USE `mundo_balonmano` ;

-- -----------------------------------------------------
-- Table `mundo_balonmano`.`Paises`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`Paises` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`Paises` (
  `Id_Pais` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Codigo` VARCHAR(3) NOT NULL,
  `Nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Id_Pais`),
  UNIQUE INDEX `Codigo_UNIQUE` (`Codigo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`Competiciones`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`Competiciones` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`Continentes`(
`Id_Continente` INT UNSIGNED NOT NULL AUTO_INCREMENT,
`Nombre` VARCHAR(45) NOT NULL,
PRIMARY KEY(`Id_Continente`)
);

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`Competiciones` (
  `Id_Competicion` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(45) NOT NULL,
  `Nivel` INT NOT NULL,
  `Pais` INT UNSIGNED NULL,
  `Continente` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`Id_Competicion`),
  INDEX `fk1_Paises` (`Pais`),
  INDEX `fk1_Continentes` (`Continente`),
  CONSTRAINT `fk1_Paises`
    FOREIGN KEY (`Pais`)
    REFERENCES `mundo_balonmano`.`Paises` (`Id_Pais`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
	CONSTRAINT `fk1_Continentes`
    FOREIGN KEY (`Continente`)
    REFERENCES `mundo_balonmano`.`Continentes` (`Id_Continente`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
    )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`Clubs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`Clubs` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`Clubs` (
  `Id_Club` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(45) NOT NULL,
  `Competicion` INT UNSIGNED NOT NULL,
  `Pais` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`Id_Club`),
  INDEX `fk1_Competiciones` (`Competicion`),
  INDEX `fk2_Paises` (`Pais`),
  CONSTRAINT `fk1_Competiciones`
    FOREIGN KEY (`Competicion`)
    REFERENCES `mundo_balonmano`.`Competiciones` (`Id_Competicion`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk2_Paises`
    FOREIGN KEY (`Pais`)
    REFERENCES `mundo_balonmano`.`Paises` (`Id_Pais`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`Puestos_Cuerpo_Tecnico`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`Puestos_Cuerpo_Tecnico` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`Puestos_Cuerpo_Tecnico` (
  `Id_Puesto_Cuerpo_Tecnico` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Puesto` VARCHAR(45) NOT NULL,
  `Descripcion` VARCHAR(128) NULL,
  PRIMARY KEY (`Id_Puesto_Cuerpo_Tecnico`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`Tipos_Contrato`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`Tipos_Contrato` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`Tipos_Contrato` (
  `Id_Tipo_Contrato` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Tipo_Contrato` VARCHAR(45) NOT NULL,
  `Descripcion` VARCHAR(128) NULL,
  PRIMARY KEY (`Id_Tipo_Contrato`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`Cuerpo_Tecnico`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`Cuerpo_Tecnico` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`Cuerpo_Tecnico` (
  `Id_Cuerpo_Tecnico` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(45) NOT NULL,
  `Apellidos` VARCHAR(45) NOT NULL,
  `Fecha_Nacimiento` DATE NOT NULL,
  `Pais` INT UNSIGNED NOT NULL,
  `Club_Actual` INT UNSIGNED NOT NULL,
  `Puesto` INT UNSIGNED NOT NULL,
  `Tipo_Contrato` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`Id_Cuerpo_Tecnico`),
  INDEX `fk3_Paises` (`Pais`),
  INDEX `fk1_Clubs` (`Club_Actual`),
  INDEX `fk1_Puestos` (`Puesto`),
  INDEX `fk1_Tipos_Contrato` (`Tipo_Contrato`),
  CONSTRAINT `fk3_Paises`
    FOREIGN KEY (`Pais`)
    REFERENCES `mundo_balonmano`.`Paises` (`Id_Pais`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk1_Clubs`
    FOREIGN KEY (`Club_Actual`)
    REFERENCES `mundo_balonmano`.`Clubs` (`Id_Club`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk1_Puestos`
    FOREIGN KEY (`Puesto`)
    REFERENCES `mundo_balonmano`.`Puestos_Cuerpo_Tecnico` (`Id_Puesto_Cuerpo_Tecnico`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk1_Tipos_Contrato`
    FOREIGN KEY (`Tipo_Contrato`)
    REFERENCES `mundo_balonmano`.`Tipos_Contrato` (`Id_Tipo_Contrato`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`Puestos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`Puestos` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`Puestos` (
  `Id_Puesto_Jugador` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Puesto` VARCHAR(45) NOT NULL,
  `Descripcion` VARCHAR(128) NULL,
  PRIMARY KEY (`Id_Puesto_Jugador`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`Jugadores`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`Jugadores` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`Jugadores` (
  `Id_Jugador` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(45) NOT NULL,
  `Apellidos` VARCHAR(60) NOT NULL,
  `Fecha_Nacimiento` DATE NOT NULL,
  `Inicio_Contrato` DATE NULL,
  `Fin_Contrato` DATE NULL,
  `Pais` INT UNSIGNED NOT NULL,
  `Club_Actual` INT UNSIGNED NOT NULL,
  `Tipo_Contrato` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`Id_Jugador`),
  INDEX `fk4_Paises` (`Pais`),
  INDEX `fk2_Clubs` (`Club_Actual`),
  INDEX `fk2_Tipos_Contrato` (`Tipo_Contrato`),
  CONSTRAINT `fk4_Paises`
    FOREIGN KEY (`Pais`)
    REFERENCES `mundo_balonmano`.`Paises` (`Id_Pais`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk2_Clubs`
    FOREIGN KEY (`Club_Actual`)
    REFERENCES `mundo_balonmano`.`Clubs` (`Id_Club`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk2_Tipos_Contrato`
    FOREIGN KEY (`Tipo_Contrato`)
    REFERENCES `mundo_balonmano`.`Tipos_Contrato` (`Id_Tipo_Contrato`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`Temporadas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`Temporadas` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`Temporadas` (
  `Id_Temporada` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Temporada` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Id_Temporada`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`Historico_Clubs_Jugadores`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`Historico_Clubs_Jugadores` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`Historico_Clubs_Jugadores` (
  `Id_Club_Jugador` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Jugador` INT UNSIGNED NOT NULL,
  `Club` INT UNSIGNED NOT NULL,
  `Temporada` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`Id_Club_Jugador`),
  INDEX `fk1_Jugadores` (`Jugador`),
  INDEX `fk3_Clubs` (`Club`),
  INDEX `fk1_Temporadas` (`Temporada`),
  CONSTRAINT `fk1_Jugadores`
    FOREIGN KEY (`Jugador`)
    REFERENCES `mundo_balonmano`.`Jugadores` (`Id_Jugador`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk3_Clubs`
    FOREIGN KEY (`Club`)
    REFERENCES `mundo_balonmano`.`Clubs` (`Id_Club`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk1_Temporadas`
    FOREIGN KEY (`Temporada`)
    REFERENCES `mundo_balonmano`.`Temporadas` (`Id_Temporada`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`Historico_Clubs_Cuerpo_Tecnico`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`Historico_Clubs_Cuerpo_Tecnico` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`Historico_Clubs_Cuerpo_Tecnico` (
  `Id_Club_Cuerpo_Tecnico` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Club` INT UNSIGNED NOT NULL,
  `Temporada` INT UNSIGNED NOT NULL,
  `Cuerpo_Tecnico` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`Id_Club_Cuerpo_Tecnico`),
  INDEX `fk4_Clubs` (`Club`),
  INDEX `fk2_Temporadas` (`Temporada`),
  INDEX `fk1_Cuerpo_Tecnico` (`Cuerpo_Tecnico`),
  CONSTRAINT `fk4_Clubs`
    FOREIGN KEY (`Club`)
    REFERENCES `mundo_balonmano`.`Clubs` (`Id_Club`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk2_Temporadas`
    FOREIGN KEY (`Temporada`)
    REFERENCES `mundo_balonmano`.`Temporadas` (`Id_Temporada`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk1_Cuerpo_Tecnico`
    FOREIGN KEY (`Cuerpo_Tecnico`)
    REFERENCES `mundo_balonmano`.`Cuerpo_Tecnico` (`Id_Cuerpo_Tecnico`)
    ON DELETE CASCADE
    ON UPDATE RESTRICT)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`Historico_Club_Competicion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`Historico_Clubs_Competicion` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`Historico_Clubs_Competicion` (
  `Id_Club_Competicion` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Club` INT UNSIGNED NOT NULL,
  `Competicion` INT UNSIGNED NOT NULL,
  `Temporada` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`Id_Club_Competicion`),
  INDEX `fk5_Clubs` (`Club`),
  INDEX `fk3_Competiciones` (`Competicion`),
  INDEX `fk3_Temporadas` (`Temporada`),
  CONSTRAINT `fk5_Clubs`
    FOREIGN KEY (`Club`)
    REFERENCES `mundo_balonmano`.`Clubs` (`Id_Club`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk3_Competiciones`
    FOREIGN KEY (`Competicion`)
    REFERENCES `mundo_balonmano`.`Competiciones` (`Id_Competicion`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk3_Temporadas`
    FOREIGN KEY (`Temporada`)
    REFERENCES `mundo_balonmano`.`Temporadas` (`Id_Temporada`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`Historico_Fichajes_Jugadores`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`Historico_Fichajes_Jugadores` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`Historico_Fichajes_Jugadores` (
  `Id_Fichaje_Jugador` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Fecha_Inicio` DATE NOT NULL,
  `Fecha_Fin` DATE NULL,
  `Club_Emisor` INT UNSIGNED NOT NULL,
  `Club_Receptor` INT UNSIGNED NOT NULL,
  `Jugador` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`Id_Fichaje_Jugador`),
  INDEX `fk6_Clubs` (`Club_Emisor`),
  INDEX `fk7_Clubs` (`Club_Receptor`),
  INDEX `fk2_Jugadores` (`Jugador`),
  CONSTRAINT `fk6_Clubs`
    FOREIGN KEY (`Club_Emisor`)
    REFERENCES `mundo_balonmano`.`Clubs` (`Id_Club`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk7_Clubs`
    FOREIGN KEY (`Club_Receptor`)
    REFERENCES `mundo_balonmano`.`Clubs` (`Id_Club`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk2_Jugadores`
    FOREIGN KEY (`Jugador`)
    REFERENCES `mundo_balonmano`.`Jugadores` (`Id_Jugador`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`Historico_Fichajes_Cuerpo_Tecnico`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`Historico_Fichajes_Cuerpo_Tecnico` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`Historico_Fichajes_Cuerpo_Tecnico` (
  `Id_Fichaje_Cuerpo_Tecnico` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Fecha_Inicio` DATE NOT NULL,
  `Fecha_Fin` DATE NULL,
  `Club_Emisor` INT UNSIGNED NOT NULL,
  `Club_Receptor` INT UNSIGNED NOT NULL,
  `Cuerpo_Tecnico` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`Id_Fichaje_Cuerpo_Tecnico`),
  INDEX `fk8_Clubs` (`Club_Emisor`),
  INDEX `fk9_Clubs` (`Club_Receptor`),
  INDEX `fk2_Cuerpo_Tecnico` (`Cuerpo_Tecnico`),
  CONSTRAINT `fk8_Clubs`
    FOREIGN KEY (`Club_Emisor`)
    REFERENCES `mundo_balonmano`.`Clubs` (`Id_Club`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk9_Clubs`
    FOREIGN KEY (`Club_Receptor`)
    REFERENCES `mundo_balonmano`.`Clubs` (`Id_Club`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk2_Cuerpo_Tecnico`
    FOREIGN KEY (`Cuerpo_Tecnico`)
    REFERENCES `mundo_balonmano`.`Cuerpo_Tecnico` (`Id_Cuerpo_Tecnico`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`Jugadores_Puestos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`Jugadores_Puestos` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`Jugadores_Puestos` (
  `Jugador` INT UNSIGNED NOT NULL,
  `Puesto` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`Jugador`, `Puesto`),
  INDEX `fk2_Puestos` (`Puesto`),
  INDEX `fk4_Jugadores` (`Jugador`),
  CONSTRAINT `fk4_Jugadores`
    FOREIGN KEY (`Jugador`)
    REFERENCES `mundo_balonmano`.`Jugadores` (`Id_Jugador`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk2_Puestos`
    FOREIGN KEY (`Puesto`)
    REFERENCES `mundo_balonmano`.`Puestos` (`Id_Puesto_Jugador`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundo_balonmano`.`Estadisticas_Jugadores`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mundo_balonmano`.`Estadisticas_Jugadores` ;

CREATE TABLE IF NOT EXISTS `mundo_balonmano`.`Estadisticas_Jugadores` (
  `Id_Estadistica_Jugador` INT NOT NULL,
  `Goles` INT NOT NULL,
  `Perdidas` INT NOT NULL,
  `Recuperaciones` INT NOT NULL,
  `Temporada` INT UNSIGNED NOT NULL,
  `Jugador` INT UNSIGNED NOT NULL,
  `Competicion` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`Id_Estadistica_Jugador`),
  INDEX `fk4_Temporadas` (`Temporada`),
  INDEX `fk5_Jugadores` (`Jugador`),
  INDEX `fk3_Competicion` (`Competicion`),
  CONSTRAINT `fk4_Temporadas`
    FOREIGN KEY (`Temporada`)
    REFERENCES `mundo_balonmano`.`Temporadas` (`Id_Temporada`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk5_Jugadores`
    FOREIGN KEY (`Jugador`)
    REFERENCES `mundo_balonmano`.`Jugadores` (`Id_Jugador`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
    CONSTRAINT `fk3_Competicion`
    FOREIGN KEY (`Competicion`)
    REFERENCES `mundo_balonmano`.`Competiciones` (`Id_Competicion`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


