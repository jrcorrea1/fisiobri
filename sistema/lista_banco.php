<?php include_once "includes/header.php"; ?>

<div class="card"style="left: 20px;right: -30;right: 20px;margin-right: 42px;margin-bottom: 20px">
  <div class="card-header text-white" style="background-color: rgb(43, 167, 228);">
    Mantenimiento de Bancos
  </div>
      <div class="card">
        <div class="card-body">
	<!-- Page Heading -->
	<div class="col-sm-2">
    <div class="card" style="width: 18rem;left: 10px;">
    <img src="img/banco.png" class="card-img-top" alt="..." style="width: 150px;margin-left: 50px;margin-top: 20px;">
          <div class="card-body">
        <h5 class="card-title"><strong>Entidad Bancaria</strong></h5>
        <p class="card-text">Se procede a registrar paises</p>
        <a href="registro_banco.php" class="btn btn-primary"data-toggle="tooltip" data-placement="top" title="Nuevo registro">Nuevo</a>
				<a href="#" class="btn btn-danger"><i class="far fa-file-pdf"></i>Informes</a>
      </div>
    </div>
  </div>
	<div class="d-sm-flex align-items-center justify-content-between mb-4">

	</div>
	<div class="card" style="width: 50rem;left: 320px;bottom: 350px;">
	  <div class="card-body">
			<div class="col-lg-12">
				<div class="table-responsive">
					<table class="table table-striped table-bordered" id="table">
						<thead class="thead-dark">
							<tr>
							<th>ID</th>
              <th>RUC</th>
							<th>BANCO</th>
              <th>CIUDAD</th>
              <th>DIRECCION</th>
              <th>TELEFONO</th>
							<th>ESTADO</th>
							<?php if ($_SESSION['rol'] == 1) { ?>
							<th>ACCIONES</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php
						include "../conexion.php";

						$query = mysqli_query($conexion, "SELECT * FROM banco");
						$result = mysqli_num_rows($query);
						if ($result > 0) {
							while ($data = mysqli_fetch_assoc($query)) { ?>
								<tr>
									<td><?php echo $data['idbanco']; ?></td>
                  <td><?php echo $data['ruc']; ?></td>
									<td><?php echo $data['banco']; ?></td>
                  <td><?php echo $data['ciudad']; ?></td>
                  <td><?php echo $data['direccion']; ?></td>
                  <td><?php echo $data['telefono']; ?></td>
									<td><?php echo $data['estado']; ?></td>
									<?php if ($_SESSION['rol'] == 1) { ?>
									<td>
										<a href="editar_banco.php?idbanco=<?php echo $data['idbanco']; ?>" class="btn btn-success"data-toggle="tooltip" data-placement="top" title="Editar"><i class='fas fa-edit'></i></a>
										<form action="eliminar_banco.php?idbanco=<?php echo $data['idbanco']; ?>" method="post" class="confirmar d-inline">
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
