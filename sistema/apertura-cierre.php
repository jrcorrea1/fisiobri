<?php include_once "includes/header.php";
include "../conexion.php";
include('core/config.php');
$dbconn = getConnection();




// preguntamos si hay caja abierta
$stmt = $dbconn->query("SELECT * FROM apertura_cierre WHERE usuario_id=" . $_SESSION['idUser'] . " AND estado = 1 ORDER BY id_caja DESC LIMIT 1");
$caja = $stmt->fetch(PDO::FETCH_OBJ);


$id_caja = $caja ? $caja->id_caja : 0;
$monto_inicial = $caja ? $caja->monto_apertura : 0;
// sumamos todos los movimientos de caja
$stmt = $dbconn->query("SELECT SUM(monto) AS total FROM cobros WHERE id_apertura = $id_caja");
$cobros = $stmt->fetch(PDO::FETCH_OBJ);
$total_cobros = $caja ? $cobros->total : 0;

// sumamos todos los movimientos de caja efectivo
$stmt = $dbconn->query("SELECT SUM(monto) AS total FROM cobros WHERE formacobro='Efectivo' AND id_apertura = $id_caja");
$cobrose = $stmt->fetch(PDO::FETCH_OBJ);
if ($cobrose->total>0) {
    $total_efectivo = $cobrose->total;
} else {
    $total_efectivo = 0;
}
// sumamos todos los movimientos de caja tarjeta
$stmt = $dbconn->query("SELECT SUM(monto) AS total FROM cobros WHERE formacobro='Tarjeta' AND id_apertura = $id_caja");
$cobrost = $stmt->fetch(PDO::FETCH_OBJ);
if ($cobrost->total>0) {
    $total_tarjeta = $cobrost->total;
} else {
  $total_tarjeta = 0;
}

// sumamos todos los movimientos de caja cheque
$stmt = $dbconn->query("SELECT SUM(monto) AS total FROM cobros WHERE formacobro='Cheque' AND id_apertura = $id_caja");
$cobrosc = $stmt->fetch(PDO::FETCH_OBJ);
if ($cobrosc->total>0) {
    $total_cheque = $cobrosc->total;
} else {
    $total_cheque = 0;
}
$total = $caja ? $monto_inicial + $total_cobros : 0;

?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><strong>Apertura y Cierre de Caja</strong></h1>
  </div>
  <div class="card">
    <div class="card-header py-3">
      <div class="float-left">
        <h6 class="m-0 font-weight-bold text-primary"></h6>
      </div>
      <div class="float-right">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-datos">
          Abrir Caja
        </button> 
        <?php if ($id_caja>0) { ?>      
          <button type="button" onclick="cierre(<?= $id_caja; ?>);" class="btn btn-danger">
            Cerrar Caja
          </button>
        <?php } ?>       
      </div>
    </div>
    <div class="card-header ui-sortable-handle" style="cursor: move;">
      <div class="card-tools">
        <ul class="nav nav-pills ml-auto">
          <li class="nav-item">
            <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Movimientos de Caja</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#sales-chart" data-toggle="tab">Historial</a>
          </li>
        </ul>
      </div>
    </div><!-- /.card-header -->
    <div class="card-body">
      <div class="tab-content p-0">
        <!-- Morris chart - Sales -->
        <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 450;">
          <div class="chartjs-size-monitor">
            <div class="chartjs-size-monitor-expand">
              <div class="table-responsive">
                <table class="table table-xxs">
                  <tbody>
                    <tr>
                      <td><i class="icon-square" style="color:#37474F;" aria-hidden="true"></i></td>
                      <td class="text-grey-800">
                        <left>MONTO INICIAL</left> <a data-toggle="modal" data-target=".bs-example-modal-sm" style="color:#5b5d5f"></a>
                      </td>
                      <td></td>
                      <td id="inicial" class="text-right"> Gs. <?php echo $monto_inicial; ?> </td>
                    </tr>
                    <tr>
                      <td><i class="icon-square" style="color:#5cb85c;" aria-hidden="true"></i></td>
                      <td class="text-teal">
                        <left>INGRESOS EFECTIVO</left> <a data-toggle="modal" data-target=".bs-example-modal-sm" style="color:#5b5d5f"> </a>
                      </td>
                      <td></td>
                      <td id="ingresos" class="text-right">Gs. <?php echo $total_efectivo; ?></td>
                    </tr>
                    <tr>
                      <td><i class="icon-square" style="color:#5cb85c;" aria-hidden="true"></i></td>
                      <td class="text-teal">
                        <left>INGRESOS TARJETA</left> <a data-toggle="modal" data-target=".bs-example-modal-sm" style="color:#5b5d5f"> </a>
                      </td>
                      <td></td>
                      <td id="ingresos" class="text-right">Gs. <?php echo $total_tarjeta; ?></td>
                    </tr>
                    <tr>
                      <td><i class="icon-square" style="color:#5cb85c;" aria-hidden="true"></i></td>
                      <td class="text-teal">
                        <left>INGRESOS CHEQUE</left> <a data-toggle="modal" data-target=".bs-example-modal-sm" style="color:#5b5d5f"> </a>
                      </td>
                      <td></td>
                      <td id="ingresos" class="text-right">Gs. <?php echo $total_cheque; ?></td>
                    </tr>
                    <tr>
                      <td><i class="icon-square" style="color:#e9573f;" aria-hidden="true"></i></td>
                      <td>
                        <left>DEVOLUCIONES</left>
                      </td>
                      <td></td>
                      <td id="devoluciones" class="text-right">Gs. 0</td>
                    </tr>


                    <tr class="">
                      <th class=""></th>
                      <th class="text-success ">
                        <h5>
                          <left><strong>INGRESOS TOTALES</strong></left>
                        </h5>
                      </th>
                      <th class=""></th>
                      <th class="text-right text-success">
                        <h5><strong id="Ingresos">Gs. <?php echo $total_cobros; ?></strong></h5>
                      </th>
                    </tr>

                    <tr class="">
                      <td class=""></td>
                      <td class="">
                        <h5>
                          <left><strong>SALDO</strong></left>
                        </h5>
                      </td>
                      <th class=""></th>
                      <th class="text-right">
                        <h5><strong id="Saldo">Gs. 0</strong></h5>
                      </th>
                    </tr>
                    <tr class="">
                      <td class=""></td>
                      <td class="text-info">
                        <h5>
                          <left><strong>MONTO INICIAL + SALDO </strong></left>
                        </h5>
                      </td>
                      <th class=""></th>
                      <th class="text-right text-info">
                        <h5><strong id="Diferencia">Gs. <?php echo $total; ?></strong></h5>
                      </th>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="chartjs-size-monitor-shrink">
              <div class=""></div>
            </div>
          </div>

        </div>
        <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 450;">

          <div class="table-responsive">
            <table id="listado" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
              <thead class="thead-dark">
                <tr>
                  <th>ID</th>
                  <th>Fecha Apertura</th>
                  <th>Monto Apertura</th>
                  <th>Fecha Cierre</th>
                  <th>Monto Cierre</th>
                  <th>Monto Efectivo</th>
                  <th>Monto Tarjeta</th>
                  <th>Monto Cheque</th>
                  <th>Estado</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tfoot class="thead-dark">
                <tr>
                  <th>ID</th>
                  <th>Fecha Apertura</th>
                  <th>Monto Apertura</th>
                  <th>Fecha Cierre</th>
                  <th>Monto Cierre</th>
                  <th>Monto Efectivo</th>
                  <th>Monto Tarjeta</th>
                  <th>Monto Cheque</th>
                  <th>Estado</th>
                  <th>Acciones</th>
                </tr>
              </tfoot>
            </table>

          </div>

        </div>
      </div>
    </div><!-- /.card-body -->
  </div>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">



  </div>






  <!-- End of Main Content -->
  <div class="modal fade" id="modal-datos">
    <div class="modal-dialog">
      <form id="form_datos" class="user">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Abrir Caja</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Monto de Apertura</label>
                  <input type="text" class="form-control" id="monto_apertura" name="monto_apertura" placeholder="Monto de Apertura">
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


  <?php include_once "includes/footer.php"; ?>

  <script type="text/javascript">
    $(document).ready(function() {

      cierre = function(caja) {
        event.preventDefault();
        // resto de tu codigo
        datos = {
          accion: "cierre",
          caja: caja,
          monto_efectivo: <?= $total_efectivo; ?>,
          monto_tarjeta: <?= $total_tarjeta; ?>,
          monto_cheque: <?= $total_cheque; ?>,
          monto_cierre: <?= $total; ?>,
        }
        $.ajax({
          url: './backend/apertura.php',
          method: 'POST',
          data: datos,
          success: function(data) {
            try {
              response = JSON.parse(data);
              if (response.status == "success") {
                setTimeout(function() {
                  Swal.fire({
                    title: 'Exito',
                    text: "Cierre de Caja Exitosa",
                    icon: 'success',
                    confirmButtonText: 'OK',

                  }).then((result) => {
                    location.reload();
                  });
                }, 2000);
              } else {
                Swal.fire({
                  title: 'Advertencia',
                  text: "Ocurrio un error intentado resolver la solicitud. Por favor contacte con el administrador del sistema",
                  icon: 'warning',
                  confirmButtonText: 'Ok'
                });
              }
            } catch (error) {
              Swal.fire({
                title: 'Advertencia',
                text: "Ocurrio un error intentado resolver la solicitud. Por favor contacte con el administrador del sistema",
                icon: 'warning',
                confirmButtonText: 'Ok'
              });
            }
          },
          error: function(data) {
            Swal.fire({
              title: 'Advertencia',
              text: "Ocurrio un error intentado resolver la solicitud. Por favor contacte con el administrador dela red",
              icon: 'warning',
              confirmButtonText: 'Ok'
            });
          }
        });
      }

      imprimir = function(caja) {
        parameters = "?caja=" + caja;
        window.open("./factura/movimientocaja.php" + parameters, "_blank");
      }

      $('#form_datos').submit(function(e) {
        e.preventDefault();
        $('#success').hide();
        $('#error').hide();
        $('#warning').hide();
        if ($('#monto_apertura').val() == "") {

          Swal.fire({
            title: 'Advertencia',
            text: "Favor cargar el monto de apertura",
            icon: 'warning',
            confirmButtonText: 'OK',
          });
        } else {
          $('#guardar').attr("disabled", "disabled");
          $.ajax({
            url: './backend/apertura.php',
            method: 'POST',
            data: $('#form_datos').serialize(),
            success: function(data) {
              try {
                response = JSON.parse(data);
                if (response.status == "success") {

                  setTimeout(function() {
                    Swal.fire({
                      title: 'Exito',
                      text: "Apertura de Caja Exitosa",
                      icon: 'success',
                      confirmButtonText: 'OK',

                    }).then((result) => {
                      location.reload();
                    });
                  }, 2000);


                } else if (response.status == "error") {

                  setTimeout(function() {
                    Swal.fire({
                      title: 'Alerta',
                      text: response.message,
                      icon: 'warning',
                      confirmButtonText: 'OK',

                    }).then((result) => {
                      location.reload();
                    });
                  }, 2000);
                }
              } catch (error) {
                Swal.fire({
                  title: 'Advertencia',
                  text: "Ocurrio un error intentado resolver la solicitud. Por favor contacte con el administrador del sistema",
                  icon: 'warning',
                  confirmButtonText: 'Ok'
                });
                console.log(error);

              }
            },
            error: function(error) {
              Swal.fire({
                title: 'Advertencia',
                text: "Ocurrio un error intentado resolver la solicitud. Por favor contacte con el administrador dela red",
                icon: 'warning',
                confirmButtonText: 'Ok'
              });
              console.log(error);
            }
          });
        }
      });

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
            "data": "monto_efectivo"
          },
          {
            "data": "monto_tarjeta"
          },
          {
            "data": "monto_cheque"
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
              'onclick="imprimir(' + row.id + ');">Imprimir</button>';
          },
          "orderable": false,
          "targets": 9 // columna modificar usuario
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