CREATE TABLE `pedido_compra` (
  `id` int(11) DEFAULT NULL,
  `fecha` varchar(45) DEFAULT NULL,
  `proveedor_id` int(11) DEFAULT NULL,
  `sucursa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
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
  `estado` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_caja`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;