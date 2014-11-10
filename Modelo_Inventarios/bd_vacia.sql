SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `inventarios` ;
CREATE SCHEMA IF NOT EXISTS `inventarios` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `inventarios` ;

-- -----------------------------------------------------
-- Table `inventarios`.`Usuarios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `inventarios`.`Usuarios` ;

CREATE TABLE IF NOT EXISTS `inventarios`.`Usuarios` (
  `id_usuario` INT NOT NULL AUTO_INCREMENT,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  `nombres` VARCHAR(150) NOT NULL,
  `apellidos` VARCHAR(150) NOT NULL,
  `usuario` VARCHAR(45) NOT NULL,
  `contrasena` VARCHAR(45) NOT NULL,
  `perfil` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id_usuario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inventarios`.`Clasificacion_Productos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `inventarios`.`Clasificacion_Productos` ;

CREATE TABLE IF NOT EXISTS `inventarios`.`Clasificacion_Productos` (
  `id_clasificacion` INT NOT NULL AUTO_INCREMENT,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  `nombre_clasificacion` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_clasificacion`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inventarios`.`Proveedores`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `inventarios`.`Proveedores` ;

CREATE TABLE IF NOT EXISTS `inventarios`.`Proveedores` (
  `id_proveedor` INT NOT NULL AUTO_INCREMENT,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  `rfc` VARCHAR(45) NOT NULL,
  `razon_social` VARCHAR(300) NOT NULL,
  `direccion` TEXT NOT NULL,
  `codigo_postal` INT NOT NULL,
  `correo` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_proveedor`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inventarios`.`Estados_Productos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `inventarios`.`Estados_Productos` ;

CREATE TABLE IF NOT EXISTS `inventarios`.`Estados_Productos` (
  `id_estado` INT NOT NULL AUTO_INCREMENT,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  `nombre_estado` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_estado`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inventarios`.`Personal`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `inventarios`.`Personal` ;

CREATE TABLE IF NOT EXISTS `inventarios`.`Personal` (
  `id_personal` INT NOT NULL AUTO_INCREMENT,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  `clave_elector` VARCHAR(100) NOT NULL,
  `clave_partido` VARCHAR(100) NOT NULL,
  `nombres` VARCHAR(250) NOT NULL,
  `apellidos` VARCHAR(250) NOT NULL,
  `correo` VARCHAR(100) NOT NULL,
  `telefono` VARCHAR(45) NOT NULL,
  `foto` VARCHAR(150) NOT NULL,
  PRIMARY KEY (`id_personal`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inventarios`.`Departamentos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `inventarios`.`Departamentos` ;

CREATE TABLE IF NOT EXISTS `inventarios`.`Departamentos` (
  `id_departamento` INT NOT NULL AUTO_INCREMENT,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  `nombre_departamento` VARCHAR(45) NOT NULL,
  `id_responsable` INT NOT NULL,
  PRIMARY KEY (`id_departamento`),
  INDEX `fk_Departamentos_Personal1_idx` (`id_responsable` ASC),
  CONSTRAINT `fk_Departamentos_Personal1`
    FOREIGN KEY (`id_responsable`)
    REFERENCES `inventarios`.`Personal` (`id_personal`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inventarios`.`Materiales`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `inventarios`.`Materiales` ;

CREATE TABLE IF NOT EXISTS `inventarios`.`Materiales` (
  `id_producto` INT NOT NULL AUTO_INCREMENT,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  `codigo_producto` VARCHAR(45) NOT NULL,
  `nombre_producto` VARCHAR(45) NOT NULL,
  `descripcion_producto` VARCHAR(45) NOT NULL,
  `fecha_adquisicion` DATETIME NOT NULL,
  `monto_original` FLOAT(20,2) NOT NULL,
  `porcentaje_depreciacion` INT NOT NULL,
  `clave_factura` VARCHAR(150) NOT NULL,
  `factura_pdf` VARCHAR(100) NOT NULL,
  `factura_xml` TEXT NOT NULL,
  `id_clasificacion` INT NOT NULL,
  `id_proveedor` INT NOT NULL,
  `id_estado` INT NOT NULL,
  `id_responsable_departament` INT NOT NULL,
  `id_responsable_activo` INT NOT NULL,
  `ubicacion_id_departamento` INT NOT NULL,
  PRIMARY KEY (`id_producto`),
  INDEX `fk_Materiales_Clasificacion_Productos1_idx` (`id_clasificacion` ASC),
  INDEX `fk_Materiales_Proveedores1_idx` (`id_proveedor` ASC),
  INDEX `fk_Materiales_Estados_Productos1_idx` (`id_estado` ASC),
  INDEX `fk_Materiales_Personal1_idx` (`id_responsable_departament` ASC),
  INDEX `fk_Materiales_Personal2_idx` (`id_responsable_activo` ASC),
  INDEX `fk_Materiales_Departamentos1_idx` (`ubicacion_id_departamento` ASC),
  CONSTRAINT `fk_Materiales_Clasificacion_Productos1`
    FOREIGN KEY (`id_clasificacion`)
    REFERENCES `inventarios`.`Clasificacion_Productos` (`id_clasificacion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Materiales_Proveedores1`
    FOREIGN KEY (`id_proveedor`)
    REFERENCES `inventarios`.`Proveedores` (`id_proveedor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Materiales_Estados_Productos1`
    FOREIGN KEY (`id_estado`)
    REFERENCES `inventarios`.`Estados_Productos` (`id_estado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Materiales_Personal1`
    FOREIGN KEY (`id_responsable_departament`)
    REFERENCES `inventarios`.`Personal` (`id_personal`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Materiales_Personal2`
    FOREIGN KEY (`id_responsable_activo`)
    REFERENCES `inventarios`.`Personal` (`id_personal`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Materiales_Departamentos1`
    FOREIGN KEY (`ubicacion_id_departamento`)
    REFERENCES `inventarios`.`Departamentos` (`id_departamento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inventarios`.`Puestos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `inventarios`.`Puestos` ;

CREATE TABLE IF NOT EXISTS `inventarios`.`Puestos` (
  `id_puesto` INT NOT NULL AUTO_INCREMENT,
  `activo` TINYINT(1) NOT NULL,
  `nombre_puesto` VARCHAR(200) NOT NULL,
  `id_responsable` INT NOT NULL,
  `id_departament` INT NOT NULL,
  PRIMARY KEY (`id_puesto`),
  INDEX `fk_Puestos_Personal1_idx` (`id_responsable` ASC),
  INDEX `fk_Puestos_Departamentos1_idx` (`id_departament` ASC),
  CONSTRAINT `fk_Puestos_Personal1`
    FOREIGN KEY (`id_responsable`)
    REFERENCES `inventarios`.`Personal` (`id_personal`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Puestos_Departamentos1`
    FOREIGN KEY (`id_departament`)
    REFERENCES `inventarios`.`Departamentos` (`id_departamento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inventarios`.`Imagenes_Materiales`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `inventarios`.`Imagenes_Materiales` ;

CREATE TABLE IF NOT EXISTS `inventarios`.`Imagenes_Materiales` (
  `id_material` INT NOT NULL AUTO_INCREMENT,
  `activo` TINYINT(1) NOT NULL,
  `ruta` VARCHAR(250) NOT NULL,
  `id_producto` INT NOT NULL,
  PRIMARY KEY (`id_material`),
  INDEX `fk_Imagenes_Materiales_Materiales1_idx` (`id_producto` ASC),
  CONSTRAINT `fk_Imagenes_Materiales_Materiales1`
    FOREIGN KEY (`id_producto`)
    REFERENCES `inventarios`.`Materiales` (`id_producto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
