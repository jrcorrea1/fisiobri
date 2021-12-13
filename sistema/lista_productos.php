<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="card"style="left: 20px;right: -30;right: 20px;margin-right: 42px;margin-bottom: 20px">
  <div class="card-header text-white" style="background-color: rgb(43, 167, 228);">
    Mantenimiento de Productos
  </div>
      <div class="card">
        <div class="card-body">
		<a href="registro_producto.php" class="btn btn-primary">Nuevo</a>
	</div>

	<div class="row">
		<div class="col-lg-12" style="margin-right: 0px;right: 10px;left: 10px;padding-right: 30px;">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="table">
					<thead class="thead-dark">
						<tr>
							<th>ID</th>
							<th>PRODUCTO</th>
							<th>MARCA</th>
							<th>CATEGORIA</th>
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
									<td><?php echo $data['marca']; ?></td>
									<td><?php echo $data['categoria']; ?></td>
									<td><?php echo $data['precio']; ?></td>
									<td><?php echo $data['existencia']; ?></td>
										<?php if ($_SESSION['rol'] == 1) { ?>
									<td>


										<a href="editar_producto.php?id=<?php echo $data['codproducto']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>
<a href="agregar_producto.php?id=<?php echo $data['codproducto']; ?>" class="btn btn-success"><i class="fas fa-shapes"></i></a>
										<form action="eliminar_producto.php?id=<?php echo $data['codproducto']; ?>" method="post" class="confirmar d-inline">
											<button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
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
