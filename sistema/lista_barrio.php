<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="card" style="left: 20px;right: -30;right: 20px;margin-right: 42px;margin-bottom: 20px">
	<div class="card-header text-white" style="background-color: rgb(43, 167, 228);">
		Mantenimiento de Barrios
	</div>
	<div class="card">
		<div class="card-body">

			<!-- Page Heading -->
			<div class="col-sm-2">
				<div class="card" style="width: 18rem;left: 10px;">
					<img src="img/map.png" class="card-img-top" alt="..." style="
    width: 150px;margin-left: 55px;margin-top: 20px;">
					<div class="card-body">
						<h5 class="card-title"><strong>Barrio</strong></h5>
						<p class="card-text">Una vez registrado ciudades, se procede a agregar el barrio</p>
						<a href="registro_barrio.php" class="btn btn-primary">Nuevo</a>
						<a href="informes/infobarrio.php" class="btn btn-danger"><i class="far fa-file-pdf"></i>Informe</a>
					</div>
				</div>
			</div>
			<div class="card" style="width: 68rem;left: 320px;bottom: 290px;">

				<div class="card-body">
					<div class="form-group row mb-3">
						<div class="col-sm-8">
							<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Buscar Barrio">
						</div>
						<div class="col-sm-4">
							<button id="filtrar" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
						</div>
						<div id="loading" class="col-sm-12 text-center hide" style="display: none;">
							<i class="fa fa-spinner fa-spin"></i> Procesando consulta
						</div>

					</div>
					<div class="col-lg-12">
						<div class="table-responsive">

							<table id="listado" class="table table-striped table-bordered">
								<thead class="thead-dark">
									<tr>
										<th>ID</th>
										<th>BARRIO</th>
										<th>DEPARTAMENTO</th>
										<th>CIUDAD</th>
										<th>ESTADO</th>
										<?php if ($_SESSION['rol'] == 1) { ?>
											<th>ACCIONES</th>
										<?php } ?>
									</tr>
								</thead>
								<tfoot class="thead-dark">
									<tr>
										<th>ID</th>
										<th>BARRIO</th>
										<th>DEPARTAMENTO</th>
										<th>CIUDAD</th>
										<th>ESTADO</th>
										<?php if ($_SESSION['rol'] == 1) { ?>
											<th>ACCIONES</th>
										<?php } ?>
									</tr>
								</tfoot>
							</table>
						</div>

					</div>
				</div>


			</div>
			<!-- /.container-fluid -->

		</div>
		<!-- End of Main Content -->
		<div class="modal fade" id="myModal">
			<div class="modal-dialog">
				<form id="form_datos" class="user">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Editar Barrio</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Barrio</label>
										<input type="text" class="form-control" id="barrio" name="barrio" readonly>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer justify-content-between">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
							<input type="hidden" name="accion" value="apertura">
							<button id="guardar" type="submit" class="btn btn-primary">Guardar</button>

						</div>
						<div id="error" style="display: none"><br>
							<div class='alert alert-danger' role='alert'>
								<strong>Error!</strong> <span id="error_message"></span>
							</div>
						</div>
						<div id="success" style="display: none"><br>
							<div class='alert alert-success' role='alert'>
								<strong>Éxito!</strong> <span id="success_message"></span>
							</div>
						</div>
					</div>
				</form>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>

		<!-- End of Main Content -->


		<?php include_once "includes/footer.php"; ?>
		<script type="text/javascript">
			$(document).ready(function() {

				modificar = function(id, barrio) {
					//location.href = './editar_barrio.php?id=' + id;
					$('#barrio').val(barrio);					
					$('#myModal').modal('show');
				}
				eliminar = function(id) {
					Swal.fire({
						title: "Esta seguro de Anular?",
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'SI, Anular!'
					}).then((result) => {
						if (result.isConfirmed) {
							location.href = './eliminar_barrio.php?id=' + id;
						}
					})
				}

				function handleAjaxError(xhr, textStatus, error) {
					console.log('Error: ' + xhr);
					if (textStatus === 'timeout') {
						Swal.fire({
							title: 'Advertencia',
							text: "Ocurrio un error intentado resolver la solicitud. Por favor contacte con el administrador dela red",
							icon: 'warning',
							confirmButtonText: 'Ok'
						});
						document.getElementById('listado_processing').style.display = 'none';
					} else {
						Swal.fire({
							title: 'Advertencia',
							text: "Ocurrio un error intentado resolver la solicitud. Por favor contacte con el administrador del sistema",
							icon: 'warning',
							confirmButtonText: 'Ok'
						});
						document.getElementById('listado_processing').style.display = 'none';
					}
				}



				var table = $('#listado').DataTable({
					"processing": true,
					"serverSide": true,
					"ordering": false,
					"searching": false,

					"ajax": {
						"url": "./backend/listados/barrios.php",
						timeout: 50000,
						error: handleAjaxError,
						"data": function(data) {
							data.nombre = $('#nombre').val()
						}
					},
					"columns": [{
							"data": "id"
						}, // first column of table
						{
							"data": "barrio"
						},
						{
							"data": "departamento"
						},
						{
							"data": "ciudad"
						},
						{
							"data": "estado"
						} // last
						<?php if ($_SESSION['rol'] == 1) { ?>
							// last column of table
						],
					"columnDefs": [{
							"render": function(number_row, type, row) {
								return '<button onclick="modificar(' + row.id + ',\'' + row.barrio + '\');" class="btn btn-success"><i class="fas fa-edit"></i> Editar</button> ' +
									'<button onclick="eliminar(' + row.id +' );" class="btn btn-danger"><i class="fas fa-trash-alt"></i> </button>';
							},
							"orderable": false,
							"targets": 5 // columna modificar usuario
						}
					<?php } ?>
					],
					"language": {
						"decimal": "",
						"emptyTable": "No hay registros en la tabla",
						"info": "Se muestran _START_ a _END_ de _TOTAL_ registros",
						"infoEmpty": "Se muestran 0 a 0 de 0 registros",
						"infoFiltered": "(filtrado de _MAX_ registros totales)",
						"infoPostFix": "",
						"thousands": ",",
						"lengthMenu": "Mostrar _MENU_ registros",
						"loadingRecords": "Cargando...",
						"processing": "Procesando...",
						"search": "Filtar por (Número | Fecha | Cédula | Depto | Distrito):",
						"zeroRecords": "No se encontraron registros que coincidan",
						"paginate": {
							"first": "Primero",
							"last": "Último",
							"next": "Siguiente",
							"previous": "Anterior"
						},
						"aria": {
							"sortAscending": ": activar para ordenar la columna ascendente",
							"sortDescending": ": activar para ordenar la columna descendente"
						}
					}
				});
				$('#filtrar').click(function(e) {
					e.preventDefault();
					$('#filtrar').attr("disabled", "disabled");
					$("#loading").show();
					table.ajax.reload();
				});

				table.on('draw', function() {
					$('#filtrar').removeAttr("disabled");
					$("#loading").hide();
				});

			});
		</script>