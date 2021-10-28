<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="card" style="    left: 20px;
    right: -30;
    right: 20px;
    margin-right: 42px;
    margin-bottom: 20px">
  <div class="card-body">
    <div align="center"><h4>Mantenimiento del Personal</h4></div>
  </div>
</div>
<div class="container-fluid">
	<h1 class="h3 mb-0 text-gray-800" style="padding-left: 20px;">
		</h1>
<div class="row">
	<!-- Page Heading -->
	<div class="col-sm-2">
    <div class="card" style="width: 15rem;left: 10px;">
    <img src="img/employ.png" class="card-img-top" alt="..." style="
    width: 150px;margin-left: 55px;margin-top: 20px;">
          <div class="card-body">
        <a href="registro_personal.php" class="btn btn-primary">Nuevo</a>
      </div>
    </div>
  </div>
  <div class="col-sm-2">
    <div class="card" style="width: 15rem;left: 10px; margin-left: 40px">
    <img src="img/pdf.png" class="card-img-top" alt="..." style="
    width: 150px;margin-left: 55px;margin-top: 20px;left: 80px;">
          <div class="card-body">
        <a href="informes/infopersonal.php" class="btn btn-danger">Emitir reporte</a>
      </div>
    </div>
  </div>
  </div>
<br>
	<div class="d-sm-flex align-items-center justify-content-between mb-4">

	</div>

  <div class="card" style="bottom: 30px;">
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
              <th>CARGO</th>
              <th>NACIONALIDAD</th>
							<th>DPTO</th>
							<th>CIUDAD</th>
							<th>BARRIO</th>
							<th>DIRECCION</th>
							<th>TELEF</th>
							<th>EMAIL</th>
							<?php if ($_SESSION['rol'] == 1) { ?>

							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php
						include "../conexion.php";

						$query = mysqli_query($conexion, "SELECT * FROM personal");
						$result = mysqli_num_rows($query);
						if ($result > 0) {
							while ($data = mysqli_fetch_assoc($query)) { ?>
								<tr>
									<td>
										<a href="editar_personal.php?id=<?php echo $data['idpersonal']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>
										<form action="eliminar_personal.php?id=<?php echo $data['idpersonal']; ?>" method="post" class="confirmar d-inline">
											<button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
										</form>
									</td>
									<td><?php echo $data['idpersonal']; ?></td>
									<td><?php echo $data['dni']; ?></td>
									<td><?php echo $data['nombre']; ?></td>
									<td><?php echo $data['apellido']; ?></td>
									<td><?php echo $data['fecha']; ?></td>
									<td><?php echo $data['genero']; ?></td>
                  <td><?php echo $data['cargo']; ?></td>
                  <td><?php echo $data['pais']; ?></td>
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
