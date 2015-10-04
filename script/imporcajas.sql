SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `imporcajas` ;
CREATE SCHEMA IF NOT EXISTS `imporcajas` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci ;
SHOW WARNINGS;
USE `imporcajas` ;

-- -----------------------------------------------------
-- Table `PerfilUsuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `PerfilUsuario` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `PerfilUsuario` (
  `perfil_id` INT NOT NULL AUTO_INCREMENT,
  `perfil_nombre` VARCHAR(45) NOT NULL,
  `perfil_descripcion` VARCHAR(100) NULL,
  PRIMARY KEY (`perfil_id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Usuario` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `Usuario` (
  `usuario_id` INT NOT NULL AUTO_INCREMENT,
  `perfil_id` INT NOT NULL,
  `usuario_nombre` VARCHAR(45) NOT NULL,
  `usuario_contraseña` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL,
  `usuario_ciudad` VARCHAR(45) NULL,
  `usuario_direccion` VARCHAR(100) NULL,
  `usuario_correo` VARCHAR(45) NULL,
  `usuario_movil` VARCHAR(45) NULL,
  PRIMARY KEY (`usuario_id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Modulo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Modulo` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `Modulo` (
  `modulo_id` INT NOT NULL AUTO_INCREMENT,
  `modulo_nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`modulo_id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Permiso`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Permiso` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `Permiso` (
  `usuario_id` INT NOT NULL,
  `modulo_id` INT NOT NULL)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `TelefonoUsuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `TelefonoUsuario` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `TelefonoUsuario` (
  `telefono_numero` VARCHAR(45) NOT NULL,
  `usuario_id` INT NOT NULL,
  PRIMARY KEY (`telefono_numero`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Regimen`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Regimen` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `Regimen` (
  `regimen_id` INT NOT NULL,
  `regimen_nombre` VARCHAR(100) NULL,
  `regimen_descripcion` VARCHAR(100) NULL,
  PRIMARY KEY (`regimen_id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Relacion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Relacion` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `Relacion` (
  `relacion_id` INT NOT NULL AUTO_INCREMENT,
  `regimen_id` INT NULL,
  `relacion_nombre` VARCHAR(45) NOT NULL,
  `relacion_nit` INT NOT NULL,
  `relacion_ciudad` VARCHAR(45) NOT NULL,
  `relacion_direccion` VARCHAR(45) NOT NULL,
  `relacion_correo` VARCHAR(45) NOT NULL,
  `relacion_movil` MEDIUMTEXT NOT NULL,
  `relacion_fax` INT NULL,
  `relacion_observacion` VARCHAR(100) NULL,
  PRIMARY KEY (`relacion_id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `PerfilRelacion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `PerfilRelacion` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `PerfilRelacion` (
  `perfilrelacion_id` INT NOT NULL,
  `perfilrelacion_nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`perfilrelacion_id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `TipoRelacion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `TipoRelacion` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `TipoRelacion` (
  `relacion_id` INT NOT NULL,
  `perfilrelacion_id` INT NOT NULL)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `TelefonoRelacion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `TelefonoRelacion` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `TelefonoRelacion` (
  `telefonor_numero` INT NOT NULL,
  `relacion_id` INT NOT NULL,
  PRIMARY KEY (`telefonor_numero`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Dimension`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Dimension` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `Dimension` (
  `dimension_id` INT NOT NULL,
  `dimension_alto` INT NOT NULL,
  `dimension_ancho` INT NOT NULL,
  `dimension_largo` INT NOT NULL,
  PRIMARY KEY (`dimension_id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Puc`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Puc` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `Puc` (
  `puc_id` INT NOT NULL,
  `puc_nombre` VARCHAR(45) NULL,
  `puc_descripcion` VARCHAR(100) NULL,
  PRIMARY KEY (`puc_id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Impuesto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Impuesto` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `Impuesto` (
  `impuesto_id` INT NOT NULL,
  `impuesto_nombre` VARCHAR(45) NULL,
  `impuesto_porcentaje` DOUBLE NULL,
  `impuesto_tipo` VARCHAR(45) NULL,
  `impuesto_descripcion` VARCHAR(100) NULL,
  PRIMARY KEY (`impuesto_id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Producto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Producto` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `Producto` (
  `producto_id` INT NOT NULL,
  `dimension_id` INT NULL,
  `puc_id` INT NULL,
  `impuesto_id` INT NOT NULL,
  `producto_nombre` VARCHAR(45) NOT NULL,
  `producto_costo` DOUBLE NOT NULL,
  `producto_precioventa` DOUBLE NOT NULL,
  `producto_cantidadinicial` INT NOT NULL,
  `producto_cantidadactual` INT NULL,
  `producto_descripcion` VARCHAR(100) NULL,
  PRIMARY KEY (`producto_id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `FacturaVenta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `FacturaVenta` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `FacturaVenta` (
  `facturav_id` INT NOT NULL,
  `relacion_id` INT NOT NULL,
  `usuario_id` INT NOT NULL,
  `facturav_fecha` DATE NOT NULL,
  `facturav_fechavencimiento` DATE NULL,
  `facturav_observacion` VARCHAR(100) NULL,
  `facturav_descripcion` VARCHAR(100) NULL,
  `facturav_estado` TINYINT(1) NULL,
  PRIMARY KEY (`facturav_id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Pedido`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Pedido` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `Pedido` (
  `pedido_id` INT NOT NULL,
  `relacion_id` INT NOT NULL,
  `facturav_id` INT NULL,
  `pedido_fecha` INT NOT NULL,
  `pedido_fechavencimiento` DATE NOT NULL,
  `pedido_observacion` VARCHAR(100) NULL,
  `pedido_descripcion` VARCHAR(100) NULL,
  PRIMARY KEY (`pedido_id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Cotizacion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Cotizacion` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `Cotizacion` (
  `cotizacion_id` INT NOT NULL,
  `relacion_id` INT NOT NULL,
  `cotizacion_fecha` DATE NOT NULL,
  `cotizacion_fechavencimiento` DATE NOT NULL,
  `cotizacion_observacion` VARCHAR(100) NULL,
  `cotizacion_descripcion` VARCHAR(100) NULL,
  PRIMARY KEY (`cotizacion_id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `FacturaCompra`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `FacturaCompra` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `FacturaCompra` (
  `facturacompra_id` INT NOT NULL,
  `relacion_id` INT NOT NULL,
  `usuario_id` INT NULL,
  `facturacompra_fecha` DATE NULL,
  `facturacompra_fechavencimiento` DATE NULL,
  `facturacompra_observacion` VARCHAR(100) NULL,
  PRIMARY KEY (`facturacompra_id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `DetalleProducto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `DetalleProducto` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `DetalleProducto` (
  `producto_id` INT NOT NULL,
  `facturav_id` INT NULL,
  `facturacompra_id` INT NULL,
  `pedido_id` INT NULL,
  `cotizacion_id` INT NULL,
  `detalleproducto_cantidad` INT NOT NULL,
  `detalleproducto_precio` DOUBLE NOT NULL,
  `detalleproducto_descuento` DOUBLE NULL,
  `detalleproducto_tamano` VARCHAR(45) NOT NULL,
  `impuesto_id` VARCHAR(45) NOT NULL)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `MetodoPago`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `MetodoPago` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `MetodoPago` (
  `metodopago_id` INT NOT NULL,
  `metodopago_nombre` VARCHAR(100) NOT NULL,
  `metodopago_descripcion` VARCHAR(100) NULL,
  PRIMARY KEY (`metodopago_id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `ReciboCaja`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ReciboCaja` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `ReciboCaja` (
  `recibocaja_id` INT NOT NULL,
  `relacion_id` INT NOT NULL,
  `facturav_id` INT NULL,
  `metodopago_id` INT NULL,
  `recibocaja_fecha` DATE NOT NULL,
  `recibocaja_observacion` VARCHAR(100) NULL,
  `recibocaja_valorecibido` DOUBLE NULL,
  `recibocaja_cantidad` INT NULL,
  PRIMARY KEY (`recibocaja_id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `ComprobanteEgreso`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ComprobanteEgreso` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `ComprobanteEgreso` (
  `comprobante_id` INT NOT NULL,
  `relacion_id` INT NOT NULL,
  `metodopago_id` INT NULL,
  `comprobante_fecha` DATE NULL,
  `comprobante_observacion` VARCHAR(100) NULL,
  `comprobante_valorecibido` DOUBLE NULL,
  `comprobante_cantidad` INT NULL,
  PRIMARY KEY (`comprobante_id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `RelacionSubcuenta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `RelacionSubcuenta` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `RelacionSubcuenta` (
  `puc_id` INT NOT NULL,
  `recibocaja_id` INT NULL,
  `facturacompra_id` INT NULL,
  `comprobante_id` INT NULL,
  `facturav_id` INT NULL)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `tipoRetencion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tipoRetencion` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `tipoRetencion` (
  `tiporetencion_id` INT NOT NULL,
  `tiporetencion_nombre` VARCHAR(100) NULL,
  `tiporetencion_descripcion` VARCHAR(100) NULL,
  PRIMARY KEY (`tiporetencion_id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Retencion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Retencion` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `Retencion` (
  `retencion_id` INT NOT NULL,
  `tiporetencion_id` INT NOT NULL,
  `retencion__nombre` VARCHAR(100) NULL,
  `retencion_porcentaje` DOUBLE NULL,
  `retencion_descripcion` VARCHAR(100) NULL,
  PRIMARY KEY (`retencion_id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `HistorialOperaciones`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `HistorialOperaciones` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `HistorialOperaciones` (
  `historial_id` INT NOT NULL,
  `usuario_id` INT NOT NULL,
  `historial_fecha` DATETIME NOT NULL,
  `historial_detalle` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`historial_id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `DetalleRetencion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `DetalleRetencion` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `DetalleRetencion` (
  `detalleretencion_id` INT NOT NULL,
  `retencion_id` INT NULL,
  `facturacompra_id` INT NULL,
  `facturaventa_id` INT NULL,
  `comprobante_id` INT NULL,
  `recibocaja_id` INT NULL,
  PRIMARY KEY (`detalleretencion_id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Data for table `Relacion`
-- -----------------------------------------------------
START TRANSACTION;
USE `imporcajas`;
INSERT INTO `Relacion` (`relacion_id`, `regimen_id`, `relacion_nombre`, `relacion_nit`, `relacion_ciudad`, `relacion_direccion`, `relacion_correo`, `relacion_movil`, `relacion_fax`, `relacion_observacion`) VALUES (22, 5, 'miguel', 123, 'medelln', 'carrera93', 'miguel@hotmail.com', '3102589634', 4567892, 'todo bn');

COMMIT;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
