<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><strong>Apertura y Cierre de Caja</strong></h1>
  </div>


  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="float-left">
        <h6 class="m-0 font-weight-bold text-primary">Tabla</h6>
      </div>
      <div class="float-right">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-datos">
          Abrir Caja
        </button>
      </div>
    </div>
    <div class="card-body" style="font-size: 13px">
      <div class="table-responsive">
        <table id="listado" class="table table-striped table-bordered">
          <thead class="thead-dark">
            <tr>
              <th>ID</th>
              <th>Fecha Apertura</th>
              <th>Monto Apertura</th>
              <th>Fecha Cierre</th>
              <th>Monto Cierre</th>
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
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
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
        $.ajax({
          url: './backend/apertura.php',
          method: 'POST',
          data: "accion=cierre&id_caja=" + caja,
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
            "data": "estado"
          },
          {
            "data": "id"
          } // last column of table
        ],
        "columnDefs": [{
          "render": function(number_row, type, row) {
            return '<button class="btn btn-warning btn-user btn-block" ' +
              'onclick="cierre(' + row.id + ');">Cerrar</button>';
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