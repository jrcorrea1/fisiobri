<?php include_once "includes/header.php"; ?>

<div class="card"style="left: 20px;right: -30;right: 20px;margin-right: 42px;margin-bottom: 20px">
  <div class="card-header text-white" style="background-color: rgb(43, 167, 228);">
    Mantenimiento de Pais / Nacionalidad
  </div>
      <div class="card"style="height: 900px;">
        <div class="card-body">
	<!-- Page Heading -->
	<div class="col-sm-2">
    <div class="card" style="width: 18rem;left: 10px;">
    <img src="img/map.png" class="card-img-top" alt="..." style="width: 150px;margin-left: 50px;margin-top: 20px;">
          <div class="card-body">
        <h5 class="card-title"><strong>Pais / Nacionalidad</strong></h5>
        <p class="card-text">Se procede a registrar paises</p>
        <a href="registro_pais.php" class="btn btn-primary"data-toggle="tooltip" data-placement="top" title="Nuevo registro">Nuevo</a>
				<a href="informes/infopais.php" class="btn btn-danger"><i class="far fa-file-pdf"></i>Informes</a>
      </div>
    </div>
  </div>
	<div class="d-sm-flex align-items-center justify-content-between mb-4">

	</div>
	<div class="card" style="width: 50rem;left: 320px;bottom: 290px;">
	  <div class="card-body">
			<div class="col-lg-12">
				<div class="table-responsive">
					<table class="table table-striped table-bordered" id="table">
						<thead class="thead-dark">
							<tr>
							<th>ID</th>
							<th>PAIS</th>
							<th>ESTADO</th>
							<?php if ($_SESSION['rol'] == 1) { ?>
							<th>ACCIONES</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php
						include "../conexion.php";

						$query = mysqli_query($conexion, "SELECT * FROM paises");
						$result = mysqli_num_rows($query);
						if ($result > 0) {
							while ($data = mysqli_fetch_assoc($query)) { ?>
								<tr>
									<td><?php echo $data['id']; ?></td>
									<td><?php echo $data['pais']; ?></td>
									<td><?php echo $data['estado']; ?></td>
									<?php if ($_SESSION['rol'] == 1) { ?>
									<td>
										<a href="editar_pais.php?id=<?php echo $data['id']; ?>" class="btn btn-success"data-toggle="tooltip" data-placement="top" title="Editar"><i class='fas fa-edit'></i></a>
										<form action="eliminar_pais.php?id=<?php echo $data['id']; ?>" method="post" class="confirmar d-inline">
											<button class="btn btn-danger" type="submit" data-toggle="tooltip" data-placement="top" title="Anular"><i class='fas fa-trash-alt'></i> </button>
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

<?php include_once "includes/footer.php"; ?>
