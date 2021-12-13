<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800"></h1>
          <a href="index.php" class="btn btn-primary">Regresar</a>
      </div>
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Ajuste de Inventario</h1>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="table">
					<thead class="thead-dark">
						<tr>
							<th>ID</th>
							<th>PRODUCTO</th>
							<th>PRECIO</th>
							<th>STOCK</th>
							<?php if ($_SESSION['rol'] == 1) { ?>
							<th>ACCIONES</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php
						include "../conexion.php";

						$query = mysqli_query($conexion, "SELECT * FROM producto");
						$result = mysqli_num_rows($query);
						if ($result > 0) {
							while ($data = mysqli_fetch_assoc($query)) { ?>
								<tr>
									<td><?php echo $data['codproducto']; ?></td>
									<td><?php echo $data['descripcion']; ?></td>
									<td><?php echo $data['precio']; ?></td>
									<td><?php echo $data['existencia']; ?></td>
										<?php if ($_SESSION['rol'] == 1) { ?>
									<td>
										<a href="agregar_producto.php?id=<?php echo $data['codproducto']; ?>" class="btn btn-primary"><i class='fas fa-audio-description'></i></a>
										</form>
									</td>
										<?php } ?>
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
