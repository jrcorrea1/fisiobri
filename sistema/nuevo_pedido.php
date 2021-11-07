<?php include_once "includes/header.php";
include('core/config.php');
$dbconn = getConnection();
// usuario
$stmt = $dbconn->query('SELECT IFNULL(MAX(id_pedido), 0)+1 AS numero FROM pedido_compra');
$pedido = $stmt->fetch(PDO::FETCH_ASSOC); 

// dia_semana
$stmt3 = $dbconn->query('SELECT codproveedor, proveedor FROM proveedor');
$proveedor = $stmt3->fetchAll(PDO::FETCH_ASSOC);?>

<!-- Begin Page Content -->
<div class="container">
  <div class="card o-hidden border-0 shadow-lg my-6">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">

        <div class="col-lg-12">
          <div class="p-5">

            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-3">Nuevo Pedido</h1>
            </div>
            <form id="form" class="user">
              <br>
              <h1 class="h4 text-gray-900 mb-4">Datos del Pedido</h1>
              <div class="form-group row mb-3">
                <div class="col-sm-4">
                  <label>Nro. Pedido</label>
                  <input type="text" class="form-control form-control-user" value="<?= $pedido['numero']; ?>" readonly>
                </div>
                <div class="col-sm-4">
                  <label>Usuario</label>
                  <input type="text" class="form-control form-control-user" readonly>
                </div>
                <div class="col-sm-4">
                  <label>Fecha</label>
                  <div class="input-group date datepicker">
                    <input type="text" class="form-control" required name="vped_fecha" disabled="" />
                    <span class="input-group-addon btn btn-primary">
                      <i class="fa fa-calendar"></i>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-group row mb-3">
                <div class="col-sm-4">
                  <label>Proveedor</label>
                  <select class="form-control select2bs4" style="width: 100%;" id="codproveedor" name="codproveedor">
                                    <option value="">--- Seleccionar dia ---</option>
                                    <?php foreach ($proveedor as $provedor) {
                                        // $selected = ($departamento['coddpto'] == $paciente['coddpto']) ? "selected" : null;
                                        echo '<option value="' . $provedor['codproveedor'] . '" ' . $selected . '>' . $provedor['proveedor'] . '</option>';
                                    } ?>
                                </select>       </div>
                <div class="col-sm-4">
                  <label>Metodo de Pago</label>
                  <input type="text" class="form-control form-control-user" readonly>
                </div>
                <div class="col-sm-4">
                  <label>Sucursal</label>
                  <div class="input-group date datepicker">
                    <input type="text" class="form-control" required name="vped_fecha" disabled="" />
                    <span class="input-group-addon btn btn-primary">
                      <i class="fa fa-calendar"></i>
                    </span>
                  </div>
                </div>
              </div>


              <div class="col-md-12">
                <div class="pull-right">
                  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">
                    <span class="glyphicon glyphicon-plus"></span> Agregar productos
                  </button>
                  <button type="submit" class="btn btn-default">
                    <span class="glyphicon glyphicon-print"></span> Imprimir
                  </button>
                </div>
              </div>
              Modificar
              </button>
            </form>
            <div class="form-group row mb-6">
              <div class="card shadow mb-6">
                <div class="card-header py-3">
                  <div class="float-left">
                    <h6 class="m-0 font-weight-bold text-primary">Horarios</h6>
                  </div>
                  <div class="float-right">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modal-datos">Agregar Horario</button>
                  </div>
                </div>
                <div class="card-body" style="font-size: 13px">
                  <div class="table-responsive">
                    <table id="listado" class="table table-bordered" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Dia</th>
                          <th>Turno</th>
                          <th>Horario - Inicio</th>
                          <th>Horario - Fin</th>
                          <th>Cupos</th>
                          <th>Tiempo</th>
                          <th>Capacidad</th>
                          <?php if (isset($_SESSION['permiso_test']) and $_SESSION['permiso_test'] == "SI") { ?>
                            <th>Accion</th>
                          <?php } ?>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>Dia</th>
                          <th>Turno</th>
                          <th>Horario - Inicio</th>
                          <th>Horario - Fin</th>
                          <th>Cupos</th>
                          <th>Tiempo</th>
                          <th>Capacidad</th>
                          <?php if (isset($_SESSION['permiso_test']) and $_SESSION['permiso_test'] == "SI") { ?>
                            <th>Accion</th>
                          <?php } ?>
                        </tr>
                      </tfoot>
                    </table>
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




<!-- End of Main Content -->


<?php include_once "includes/footer.php"; ?>

<script type="text/javascript">
  $(document).ready(function() {

    modificar = function(usuario) {
      location.href = './modificarUsuario.php?usuario=' + usuario;
    }

    function handleAjaxError(xhr, textStatus, error) {
      if (textStatus === 'timeout') {
        swal("Advertencia", "Ocurrio un error intentado comunicarse con el servidor. Por favor contacte con el administrador de la red", "warning");
        document.getElementById('listado_processing').style.display = 'none';
      } else {
        swal("Advertencia", "Ocurrio un error intentado resolver la solicitud. Por favor contacte con el administrador del sistema", "warning");
        document.getElementById('listado_processing').style.display = 'none';
      }
    }

    $('#listado').DataTable({
      "processing": true,
      "serverSide": true,
      "searching": false,
      "ajax": {
        url: "./backend/listados/apertura.php",
        timeout: 10000,
        error: handleAjaxError
      },
      "columns": [{
          "data": "id"
        }, // first column of table
        {
          "data": "fecha_apertura"
        },
        {
          "data": "monto_apertura"
        },
        {
          "data": "fecha_cierre"
        },
        {
          "data": "monto_cierre"
        },
        {
          "data": "estado"
        },
        {
          "data": "id"
        } // last column of table
      ],
      "columnDefs": [{
        "render": function(number_row, type, row) {
          return '<button class="btn btn-warning btn-user btn-block" ' +
            'onclick="modificar(' + row.id + ');">Modificar</button>';
        },
        "orderable": false,
        "targets": 6 // columna modificar usuario
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

  });
</script>