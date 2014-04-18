
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- fos_user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `fos_user`;

CREATE TABLE `fos_user`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(255),
    `username_canonical` VARCHAR(255),
    `email` VARCHAR(255),
    `email_canonical` VARCHAR(255),
    `enabled` TINYINT(1) DEFAULT 0,
    `salt` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `last_login` DATETIME,
    `locked` TINYINT(1) DEFAULT 0,
    `expired` TINYINT(1) DEFAULT 0,
    `expires_at` DATETIME,
    `confirmation_token` VARCHAR(255),
    `password_requested_at` DATETIME,
    `credentials_expired` TINYINT(1) DEFAULT 0,
    `credentials_expire_at` DATETIME,
    `roles` TEXT,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `fos_user_U_1` (`username_canonical`),
    UNIQUE INDEX `fos_user_U_2` (`email_canonical`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- fos_group
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `fos_group`;

CREATE TABLE `fos_group`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `roles` TEXT,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- fos_user_group
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `fos_user_group`;

CREATE TABLE `fos_user_group`
(
    `fos_user_id` INTEGER NOT NULL,
    `fos_group_id` INTEGER NOT NULL,
    PRIMARY KEY (`fos_user_id`,`fos_group_id`),
    INDEX `fos_user_group_FI_2` (`fos_group_id`),
    CONSTRAINT `fos_user_group_FK_1`
        FOREIGN KEY (`fos_user_id`)
        REFERENCES `fos_user` (`id`),
    CONSTRAINT `fos_user_group_FK_2`
        FOREIGN KEY (`fos_group_id`)
        REFERENCES `fos_group` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- producto
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `producto`;

CREATE TABLE `producto`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(100),
    `precio` DECIMAL,
    `descripcion` TEXT,
    `categoria_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `producto_FI_1` (`categoria_id`),
    CONSTRAINT `producto_FK_1`
        FOREIGN KEY (`categoria_id`)
        REFERENCES `categoria` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- categoria
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `categoria`;

CREATE TABLE `categoria`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(100),
    `descripcion` VARCHAR(100),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- clientes
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `clientes`;

CREATE TABLE `clientes`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `nombres` VARCHAR(100),
    `apellidos` VARCHAR(100),
    `nombre_completo` VARCHAR(100),
    `dpi` VARCHAR(100),
    `nit` VARCHAR(100),
    `telefono` VARCHAR(100),
    `direccion` VARCHAR(100),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- compras
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `compras`;

CREATE TABLE `compras`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `proveedor_id` INTEGER,
    `inventario_id` INTEGER,
    `factura_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `compras_FI_1` (`proveedor_id`),
    INDEX `compras_FI_2` (`factura_id`),
    INDEX `compras_FI_3` (`inventario_id`),
    CONSTRAINT `compras_FK_1`
        FOREIGN KEY (`proveedor_id`)
        REFERENCES `proveedor` (`id`),
    CONSTRAINT `compras_FK_2`
        FOREIGN KEY (`factura_id`)
        REFERENCES `factura` (`id`),
    CONSTRAINT `compras_FK_3`
        FOREIGN KEY (`inventario_id`)
        REFERENCES `inventario` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- ventas
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ventas`;

CREATE TABLE `ventas`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `inventario_id` INTEGER,
    `factura_id` INTEGER,
    `clientes_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `ventas_FI_1` (`clientes_id`),
    INDEX `ventas_FI_2` (`factura_id`),
    INDEX `ventas_FI_3` (`inventario_id`),
    CONSTRAINT `ventas_FK_1`
        FOREIGN KEY (`clientes_id`)
        REFERENCES `clientes` (`id`),
    CONSTRAINT `ventas_FK_2`
        FOREIGN KEY (`factura_id`)
        REFERENCES `factura` (`id`),
    CONSTRAINT `ventas_FK_3`
        FOREIGN KEY (`inventario_id`)
        REFERENCES `inventario` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- proveedor
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `proveedor`;

CREATE TABLE `proveedor`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(100),
    `encargado` VARCHAR(100),
    `nit` VARCHAR(80),
    `dpi` VARCHAR(80),
    `direccion` VARCHAR(150),
    `telefono` VARCHAR(80),
    `movil` VARCHAR(80),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- factura
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `factura`;

CREATE TABLE `factura`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `tipo` VARCHAR(80),
    `clientes_id` INTEGER,
    `subtotal` DECIMAL,
    `impuesto` DECIMAL,
    `descuento` DECIMAL,
    `total` DECIMAL,
    PRIMARY KEY (`id`),
    INDEX `factura_FI_1` (`clientes_id`),
    CONSTRAINT `factura_FK_1`
        FOREIGN KEY (`clientes_id`)
        REFERENCES `clientes` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- factura_detalle
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `factura_detalle`;

CREATE TABLE `factura_detalle`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `factura_id` INTEGER,
    `cantidad` INTEGER,
    `producto_id` INTEGER,
    `precio_unitario` DECIMAL,
    `subtotal` DECIMAL,
    PRIMARY KEY (`id`),
    INDEX `factura_detalle_FI_1` (`producto_id`),
    INDEX `factura_detalle_FI_2` (`factura_id`),
    CONSTRAINT `factura_detalle_FK_1`
        FOREIGN KEY (`producto_id`)
        REFERENCES `producto` (`id`),
    CONSTRAINT `factura_detalle_FK_2`
        FOREIGN KEY (`factura_id`)
        REFERENCES `factura` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- inventario
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `inventario`;

CREATE TABLE `inventario`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `producto_id` INTEGER,
    `proveedor_id` INTEGER,
    `fecha` DATE,
    `stock` INTEGER,
    `neto` DECIMAL,
    `precio_unitario` DECIMAL,
    PRIMARY KEY (`id`),
    INDEX `inventario_FI_1` (`producto_id`),
    INDEX `inventario_FI_2` (`proveedor_id`),
    CONSTRAINT `inventario_FK_1`
        FOREIGN KEY (`producto_id`)
        REFERENCES `producto` (`id`),
    CONSTRAINT `inventario_FK_2`
        FOREIGN KEY (`proveedor_id`)
        REFERENCES `proveedor` (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
