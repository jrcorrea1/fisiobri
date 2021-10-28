<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="card" style="left: auto;right: -30;right: auto;margin-right: 0px;margin-bottom: 20px;">
	  <div class="card-body">
	    <div align="center"><h4>Mantenimiento de Clientes</h4></div>
		<a href="registro_cliente.php" class="btn btn-primary">Nuevo</a>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="col-lg-12">
				<div class="table-responsive">
					<table class="table table-striped table-bordered" id="table">
						<thead class="thead-dark">
							<tr>
							<th>ACCIONES</th>
							<th>ID</th>
							<th>DNI</th>
							<th>NOMBRE</th>
							<th>APELLIDO</th>
							<th>FECHA NACIMIENTO</th>
							<th>GENERO</th>
							<th>DEPARTAMENTO</th>
							<th>CIUDAD</th>
							<th>BARRIO</th>
							<th>DIRECCION</th>
							<th>TELEFONO</th>
							<th>EMAIL</th>
							<?php if ($_SESSION['rol'] == 1) { ?>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php
						include "../conexion.php";

						$query = mysqli_query($conexion, "SELECT * FROM cliente");
						$result = mysqli_num_rows($query);
						if ($result > 0) {
							while ($data = mysqli_fetch_assoc($query)) { ?>
								<tr>
										<td>
											<a href="editar_cliente.php?id=<?php echo $data['idcliente']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>
											<form action="eliminar_cliente.php?id=<?php echo $data['idcliente']; ?>" method="post" class="confirmar d-inline">
												<button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
											</form>
										</td>
									<td><?php echo $data['idcliente']; ?></td>
									<td><?php echo $data['dni']; ?></td>
									<td><?php echo $data['nombre']; ?></td>
									<td><?php echo $data['apellido']; ?></td>
									<td><?php echo $data['fecha']; ?></td>
									<td><?php echo $data['genero']; ?></td>
									<td><?php echo $data['departamento']; ?></td>
									<td><?php echo $data['ciudad']; ?></td>
									<td><?php echo $data['barrio']; ?></td>
									<td><?php echo $data['direccion']; ?></td>
									<td><?php echo $data['telefono']; ?></td>
									<td><?php echo $data['email']; ?></td>
									<?php if ($_SESSION['rol'] == 1) { ?>

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
