CREATE TABLE `pedido_compra` (
  `id` int(11) DEFAULT NULL,
  `fecha` varchar(45) DEFAULT NULL,
  `proveedor_id` int(11) DEFAULT NULL,
  `sucursa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4


CREATE TABLE `detalle_pedido` (
  `id_pedido` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;


CREATE TABLE `sucursal` (
  `idsucursal` int(11) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idsucursal`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4


CREATE TABLE `apertura_cierre` (
  `id_caja` int(11) DEFAULT NULL,
  `fecha_apertura` datetime DEFAULT NULL,
  `monto_apertura` int(11) DEFAULT NULL,
  `fecha_cierre` datetime DEFAULT NULL,
  `monto_cierre` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_caja`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

CREATE TABLE `compra` (
  `id` int(11) DEFAULT NULL,
  `fecha` varchar(45) DEFAULT NULL,
  `proveedor_id` int(11) DEFAULT NULL,
  `sucursa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
   `estado` varchar(45) DEFAULT NULL,
   `pedido_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4


CREATE TABLE `detalle_compra` (
  `id_compra` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;



CREATE TABLE barrio (
                id INT AUTO_INCREMENT NOT NULL,
                barrio VARCHAR(150) NULL,
                estado VARCHAR(12) NULL,
                usuario_id INT NULL,
                ciudad VARCHAR(100) NULL,
                departamento VARCHAR(100) NULL,
                PRIMARY KEY (id)
);
CREATE TABLE `notacredito` (
  `id` int(11) DEFAULT NULL,
  `fecha` varchar(45) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `nofactura` int(11) DEFAULT NULL, 
  `estado` varchar(45) DEFAULT NULL,
   `motivo` varchar(80) DEFAULT NULL,
    `observacion` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4

CREATE TABLE `detalle_nota_credito` (
  `id_credito` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4
