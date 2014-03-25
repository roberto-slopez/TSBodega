
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
) ENGINE=MyISAM;

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
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- fos_user_group
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `fos_user_group`;

CREATE TABLE `fos_user_group`
(
    `fos_user_id` INTEGER NOT NULL,
    `fos_group_id` INTEGER NOT NULL,
    PRIMARY KEY (`fos_user_id`,`fos_group_id`),
    INDEX `fos_user_group_FI_2` (`fos_group_id`)
) ENGINE=MyISAM;

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
    INDEX `producto_FI_1` (`categoria_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- categoria
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `categoria`;

CREATE TABLE `categoria`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(100),
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- usuarios
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(100),
    `password` VARCHAR(100),
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

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
) ENGINE=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
