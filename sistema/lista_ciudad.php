<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
	<div class="container-fluid">
<div class="card" style="    left: 20px;
    right: -30;
    right: 20px;
    margin-right: 42px;
    margin-bottom: 20px">
  <div class="card-body">
    <div align="center"><h4>Mantenimiento de Ciudad</h4></div>
  </div>
</div>

	<!-- Page Heading -->
	<div class="col-sm-2">
    <div class="card" style="width: 18rem;left: 10px;">
    <img src="img/map.png" class="card-img-top" alt="..." style="
    width: 150px;margin-left: 55px;margin-top: 20px;">
          <div class="card-body">
        <h5 class="card-title"><strong>Ciudad</strong></h5>
        <p class="card-text">Una vez registrado departamento, se procede a agregar Ciudad</p>
        <a href="registro_ciudad.php" class="btn btn-primary">Nuevo</a>
				<a href="informes/infociudad.php" class="btn btn-danger"><i class="far fa-file-pdf"></i>Informe</a>
      </div>
    </div>
  </div>
<div class="card" style="width: 55rem;left: 320px;bottom: 290px;">
  <div class="card-body">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="table">
					<thead class="thead-dark">
						<tr>
							<th>ID</th>
							<th>CIUDAD</th>
							<th>ESTADO</th>
							<?php if ($_SESSION['rol'] == 1) { ?>
							<th>ACCIONES</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php
						include "../conexion.php";

						$query = mysqli_query($conexion, "SELECT * FROM ciudad");
						$result = mysqli_num_rows($query);
						if ($result > 0) {
							while ($data = mysqli_fetch_assoc($query)) { ?>
								<tr>
									<td><?php echo $data['id']; ?></td>
									<td><?php echo $data['ciudad']; ?></td>
									<td><?php echo $data['estado']; ?></td>
									<?php if ($_SESSION['rol'] == 1) { ?>
									<td>
										<a href="editar_ciudad.php?id=<?php echo $data['id']; ?>" class="btn btn-success"><i class='fas fa-edit'></i> Editar</a>
										<form action="eliminar_ciudad.php?id=<?php echo $data['id']; ?>" method="post" class="confirmar d-inline">
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
