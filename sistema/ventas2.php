<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><strong>Ventas Realizadas</strong></h1>
	</div>
	<div class="row">
		<div class="card-header py-3" style="padding-bottom: 0.5rem !important;">
			<div class="row">



				<div class="col-sm-5">
					<div class="form-group">
						<label for="fecha" class="font-size-14">Fecha desde</label><br>
						<div class='input-group date' id='datetimepicker1'>
							<input type='text' id="desde" name="desde" placeholder="Vacío para buscar todos.." class="form-control font-size-14" autocomplete="off" />
							<span class="input-group-addon ml-2">
								<i class="far fa-calendar-alt" style="font-size: 2rem;"></i>
							</span>
						</div>
					</div>
				</div>
				<div class="col-sm-5">
					<div class="form-group">
						<label for="fecha" class="font-size-14">Fecha hasta</label><br>
						<div class='input-group date' id='datetimepicker2'>
							<input type='text' id="hasta" name="hasta" placeholder="Vacío para buscar todos.." class="form-control font-size-14" autocomplete="off" />
							<span class="input-group-addon ml-2">
								<i class="far fa-calendar-alt" style="font-size: 2rem;"></i>
							</span>
						</div>
					</div>
				</div>


				<div class="col-sm-2">
					<div class="form-group">
						<button id="filtrar" class="btn btn-primary">Filtrar &nbsp;<i class="fa fa-search"></i></button>
					</div>
				</div>





				<div id="loading" class="col-sm-12 text-center hide" style="display: none;">
					<i class="fa fa-spinner fa-spin"></i> Procesando consulta
				</div>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="listado">
					<thead class="thead-dark">
						<tr>
							<th>Nro Factura</th>
							<th>Fecha</th>
							<th>Cliente</th>
							<th>Monto de Venta</th>
							<th>Acciones</th>
						</tr>
					</thead>

				</table>
			</div>
		</div>
	</div>



</div>
<!-- /.container-fluid -->



<?php include_once "includes/footer.php"; ?>
<script type="text/javascript">
	$(document).ready(function() {


		

		factura = function(cl, f) {
			parameters = "?cl=" + cl + "&f=" + f;
			window.open("./factura/generaFactura.php" + parameters, "_blank");
		}

		function handleAjaxError(xhr, textStatus, error) {
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
			"searching": false,
			"ajax": {
				url: "./backend/listados/ventas.php",
				timeout: 10000,
				error: handleAjaxError,
				"data": function(data) {
					data.desde = $('#desde').val(),
					data.hasta = $('#hasta').val()
				}
			},
			"columns": [{
					"data": "nofactura"
				}, // first column of table
				{
					"data": "fecha"
				},
				{
					"data": "cliente"
				},
				{
					"data": "totalfactura"
				},
				{
					"data": "id"
				} // last column of table
			],
			"columnDefs": [{
				"render": function(number_row, type, row) {


					return '<button class="btn btn-primary view_factura" onclick="factura(' + row.codcliente + ',' + row.nofactura + ');">Ver</button>';

				},
				"orderable": false,
				"targets": 4 // columna modificar usuario
			}],
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
				"search": "Filtar por (Nombre | Email | Rol):",
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
		$('#datetimepicker1').datetimepicker({
            format: 'DD/MM/YYYY',
            allowInputToggle: true,
            useCurrent: false,
            icons: {
                date: 'fa fa-calendar',
                time: 'fa fa-clock-o',
                up: 'fas fa-arrow-up',
                down: 'fas fa-arrow-down',
                previous: 'fas fa-arrow-left',
                next: 'fas fa-arrow-right'
            }
        });

		$('#datetimepicker2').datetimepicker({
            format: 'DD/MM/YYYY',
            allowInputToggle: true,
            useCurrent: false,
            icons: {
                date: 'fa fa-calendar',
                time: 'fa fa-clock-o',
                up: 'fas fa-arrow-up',
                down: 'fas fa-arrow-down',
                previous: 'fas fa-arrow-left',
                next: 'fas fa-arrow-right'
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