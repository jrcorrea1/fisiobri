<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
<div class="card" style="    left: 20px;
    right: -30;
    right: 20px;
    margin-right: 42px;
    margin-bottom: 20px">
  <div class="card-body">
    <div align="center"><h4>PANEL DE ADMINSTRACION</h4></div>
  </div>
</div>

	<!-- Content Row -->
	<div class="row">

		<!-- Earnings (Monthly) Card Example -->
		<a class="col-xl-3 col-md-6 mb-4" href="lista_usuarios.php">
			<div class="card border-left-primary shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Usuarios</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $data['usuarios']; ?></div>
						</div>
						<div class="col-auto">
							<i class="fas fa-user fa-2x text-gray-700"></i>
						</div>
					</div>
				</div>
			</div>
		</a>

		<!-- Earnings (Monthly) Card Example -->
		<a class="col-xl-3 col-md-6 mb-4" href="lista_cliente.php">
			<div class="card border-left-success shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Clientes</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $data['clientes']; ?></div>
						</div>
						<div class="col-auto">
							<i class="fas fa-users fa-2x text-gray-700"></i>
						</div>
					</div>
				</div>
			</div>
		</a>

		<!-- Earnings (Monthly) Card Example -->
		<a class="col-xl-3 col-md-6 mb-4" href="lista_productos.php">
			<div class="card border-left-info shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Productos</div>
							<div class="row no-gutters align-items-center">
								<div class="col-auto">
									<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $data['productos']; ?></div>
								</div>
								<div class="col">
									<div class="progress progress-sm mr-2">
										<div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-auto">
							<i class="fas fa-clipboard-list fa-2x text-gray-700"></i>
						</div>
					</div>
				</div>
			</div>
		</a>

		<!-- Pending Requests Card Example -->
		<a class="col-xl-3 col-md-6 mb-4" href="registrocobro2.php">
			<div class="card border-left-warning shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Cobros</div>
				<!-- <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $data['ventas']; ?></div> -->
						</div>
						<div class="col-auto">
							<i class="fas fa-dollar-sign fa-2x text-gray-700"></i>
						</div>
					</div>
				</div>
			</div>
		</a>
	</div>
	<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Acessos Directos</h1>
		</div>
	<div class="row">
                            <div class="col-xl-3 col-md-6" style="
    padding-left: 50px;
    padding-right: 50px;
">
                                <div class="card bg-primary text-white mb-4">
                                  <img class="card-img-top" src="IMG/boxes.png">
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a href="lista_productos.php" class="btn btn-primary stretched-link">Productos</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6" style="
    padding-left: 50px;
    padding-right: 50px;
">
                                <div class="card bg-warning text-white mb-4">
                                  <img class="card-img-top" src="IMG/personal.png">
                                  <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a href="lista_personal.php" class="btn btn-primary stretched-link">Personal</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6" style="
    padding-left: 50px;
    padding-right: 50px;
">
                                <div class="card bg-success text-white mb-4">
                                  <img class="card-img-top" src="IMG/cliente.png">
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                      <a href="lista_cliente.php" class="btn btn-primary stretched-link">Clientes</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6" style="
    padding-left: 50px;
    padding-right: 50px;
">
                                <div class="card bg-danger text-white mb-4">
                                  <img class="card-img-top" src="IMG/fisio.png">
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                      <a href="#" class="btn btn-primary stretched-link">Citas Medicas</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>



						</div>
					</div>
				</div>
			</div>


	</div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>
