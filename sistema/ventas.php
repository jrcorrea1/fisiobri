<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><strong>Ventas Realizadas</strong></h1>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="table">
					<thead class="thead-dark">
						<tr>
							<th>Nro Factura</th>
							<th>Fecha</th>
							<th>Cliente</th>
							<th>Monto de Venta</th>
							<th>Acciones</th>

						</tr>
					</thead>
					<tbody>
						<?php
						require "../conexion.php";
						$query = mysqli_query($conexion, "SELECT f.nofactura, f.fecha, CONCAT(c.nombre, c.apellido) AS nombre, f.totalfactura, f.estado FROM factura as f inner join cliente as c ON f.codcliente = c.idcliente ORDER BY f.nofactura DESC");
						mysqli_close($conexion);
						$cli = mysqli_num_rows($query);
						var_dump($cli);

						if ($cli > 0) {
							while ($dato = mysqli_fetch_array($query)) {
						?>
								<tr>
									<td><?php echo $dato['nofactura']; ?></td>
									<td><?php echo $dato['fecha']; ?></td>
									<td><?php echo $dato['nombre']; ?></td>
									<td><?php echo $dato['totalfactura']; ?></td>

									<td>
										<button type="button" class="btn btn-primary view_factura" cl="<?php echo $dato['codcliente'];  ?>" f="<?php echo $dato['nofactura']; ?>">Ver</button>
									</td>
								</tr>
						<?php }
						} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<?php include_once "includes/footer.php"; ?>
