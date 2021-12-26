<?php include_once "includes/header.php";
include('core/config.php');
$dbconn = getConnection();
// llamamos al ultimo id de la tabla pedido
$stmt = $dbconn->query('SELECT IFNULL(MAX(id), 0)+1 AS numero FROM notacredito');
$pedido = $stmt->fetch(PDO::FETCH_ASSOC);

//generamos la fecha y hora actual
$fechaingreso = date('Y-m-d H:i:s');
$fecha = date("d/m/Y", strtotime($fechaingreso))

;
?>
<!-- Begin Page Content -->
<div class="container">
  <div class="card o-hidden border-0 shadow-lg my-6">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">

        <div class="col-lg-12">
          <div class="p-5">

            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-3">Nota de Credito</h1>
            </div>
            <form id="form_credito" class="user">
              <div class="card-header py-3">
                <div class="float-left">


                </div>
                <div class="float-right">

                  <button class="btn btn-primary" id="cancelar" type="button">Cancelar</button>
                  <input type="hidden" name="accion" value="insertacredito">
                  <button class="btn btn-primary" id="guardar" type="submit">Guardar</button>
                </div>
              </div>
              <br>

              <br>
              <h1 class="h4 text-gray-900 mb-4">Datos de la Nota</h1>
              <div class="form-group row mb-3">
                <div class="col-sm-4">
                  <label>Codigo</label>
                  <input type="text" id="credito" class="form-control" value="<?= $pedido['numero']; ?>" readonly>
                </div>
                <div class="col-sm-4">
                  <label>Usuario</label>
                  <input type="text" class="form-control" value="<?= $_SESSION['nombre']; ?>" readonly>
                </div>
                <div class="col-sm-4">
                  <label>Fecha</label>
                  <div class="input-group date datepicker">
                    <input type="text" class="form-control" value="<?= $fecha; ?>" required name="vped_fecha" readonly>
                    <span class="input-group-addon btn btn-primary">
                      <i class="fa fa-calendar"></i>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-group row mb-3">
                <div class="col-sm-2">
                  <label>Factura Nº</label>
                  <input type="text" class="form-control" id="factura" name="factura" required>
                </div>
                <div class="col-sm-6">
                  <label>Cliente</label>
                  <input type="text" class="form-control" name="cliente" id="cliente" required>
                </div>
                <div class="col-sm-2">
                  <label>Fecha Factura</label>
                  <div class="input-group date datepicker">
                    <input type="text" class="form-control" name="fechafactura" id="fechafactura" required>
                  </div>
                </div>
                <div class="col-sm-2">
                  <label></label>
                  <div class="input-group date datepicker">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">
                      <i class="fa fa-search"></i> Buscar
                    </button>
                  </div>
                </div>
              </div>            
              <div class="form-group row mb-3">
                <div class="col-sm-4">
                  <label>Motivo</label>
                  <select class="form-control seleccion" name="motivo" id="motivo" required>
                    <option value="">Seleccione</option>
                    <option value="anular">Anular Factura</option>
                    <option value="devolucion">Devolucion</option>               
                  </select>
                </div>
                <div class="col-sm-8">
                  <label>Observacion</label>
                  <textarea type="text" id="observacion" name="observacion" class="form-control"> </textarea>
                </div>
                
              </div>
            </form>



            <div class="card shadow mb-12">             
              <div class="card-body" style="font-size: 13px">
                <div class="table-responsive">
                  <table id="listado" class="table table-striped table-bordered" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                      <tr>
                        <th>Codigo</th>
                        <th style=" white-space: nowrap;">Descripcion</th>
                        <th>Marca</th>
                        <th>Cantidad</th>
                        <th><span class="pull-right">PRECIO UNIT.</span></th>
                        <th><span class="pull-right">PRECIO TOTAL</span></th>                       
                      </tr>
                    </thead>
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

<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <form id="form" class="user">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Buscar Facturas</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group row mb-3">
            <div class="col-sm-8">
              <input type="text" class="form-control" id="des" name="des" placeholder="Buscar">
            </div>
            <div class="col-sm-4">
              <button id="filtrar" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
            </div>
            <div id="loading" class="col-sm-12 text-center hide" style="display: none;">
              <i class="fa fa-spinner fa-spin"></i> Procesando consulta
            </div>

          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table id="listafactura" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
                <thead class="thead-dark">
                  <tr>
                    <th>Nº Factura</th>
                    <th style=" white-space: nowrap;">Cliente</th>
                    <th>Fecha</th>
                    <th>Monto</th>
                    <th><span class="pull-right">Accion</span></th>
                  </tr>
                </thead>

              </table>
            </div>
          </div>

          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
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
    $('.seleccion').select2();



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



    var table = $('#listafactura').DataTable({
      "processing": true,
      "serverSide": true,
      "ordering": false,
      "searching": false,

      "ajax": {
        "url": "./backend/listados/buscarfactura.php",
        timeout: 15000,
        error: handleAjaxError,
        "data": function(data) {
          data.des = $('#des').val()
        }
      },
      "columns": [{
          "data": "id"
        },
        {
          "data": "cliente"
        },
        {
          "data": "fecha"
        },
        {
          "data": "monto"
        },
        {
          "data": "id"
        }

        // last column of table
      ],
      "columnDefs": [{
         
          "render": function(number_row, type, row) {
            return '<button class="btn btn-success btn-user" ' +
              'onclick="insertafactura(' + row.id + ',\'' + row.fecha + '\',\'' + row.cliente + '\');"><i class="fa fa-plus"></i></button>';
          },
          "orderable": false,
          "targets": 4 // columna modificar usuario
        }
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

    insertafactura = function(id, fecha, cliente) {
      event.preventDefault();
      $('#factura').val(id);
      $('#fechafactura').val(fecha);
      $('#cliente').val(cliente);
      $('#myModal').modal('hide');
      table1.ajax.reload();

    
    };

    var table1 = $('#listado').DataTable({
      "processing": true,
      "serverSide": true,
      "ordering": false,
      "searching": false,
      "ajax": {
        "url": "./backend/listados/detallecredito.php",
        timeout: 15000,
        error: handleAjaxError,
        "data": function(data) {
          data.factura = $('#factura').val()
        }
      },
      "columns": [{
          "data": "codigo"
        }, // first column of table
        {
          "data": "descripcion"
        },
        {
          "data": "marca"
        },
        {
          "data": "cantidad"
        },
        {
          "data": "precio"
        },
        {
          "data": "total"
        } // last column of table
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




    $('#form_credito').submit(function(e) {
      e.preventDefault();
      $('#success').hide();
      $('#error').hide();
      $('#warning').hide();
      if ($('#codproveedor').val() == "") {

        Swal.fire({
          title: 'Advertencia',
          icon: 'warning',
          text: 'Favor cargar el proveedor'
        });
      } else if ($('#sucursal_id').val() == "") {
        Swal.fire({
          title: 'Advertencia',
          icon: 'warning',
          text: 'Favor cargar la sucursal'
        });
      } else {
        $('#guardar').attr("disabled", "disabled");
        const valor = $('#form_credito').val();
        console.log($('#form_credito').val());
        $.ajax({
          url: './backend/credito.php',
          method: 'POST',
          data: $('#form_credito').serialize(),
          success: function(data) {
            try {
              response = JSON.parse(data);
              if (response.status == "success") {

                setTimeout(function() {
                  Swal.fire({
                    title: 'Exito',
                    text: "Nota de Credito guardado con exito",
                    icon: 'success',
                    confirmButtonText: 'Ok'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      location.href = './credito.php';
                    }
                  });
                }, 2000);


              } else if (response.status == "error" && response.message == "No autorizado") {
                Swal.fire({
                  title: 'Sesión ha expirado',
                  text: "Su sesión ha expirado, favor vuelva a iniciar sesión en el sistema.",
                  icon: 'warning',
                  confirmButtonText: 'Ok'
                });
              } else {
                $('#error_message').html(response.message);
                $('#error').show();
                $('#guardar').removeAttr("disabled");
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
              text: "Ocurrio un error intentado resolver la solicitud. Por favor contacte con el administrador de la red",
              icon: 'warning',
              confirmButtonText: 'Ok'
            });

            console.log(error);
          }
        });
      }
    });

    $("#cancelar").on("click", function(event) {
      event.preventDefault();
      // resto de tu codigo
      $.ajax({
        url: './backend/pedido.php',
        method: 'POST',
        data: "accion=cancelarpedido&credito=" + $('#pedido').val(),
        success: function(data) {
          try {
            response = JSON.parse(data);
            if (response.status == "success") {
              setTimeout(function() {
                Swal.fire({
                  title: 'Éxito',
                  text: 'Se cancelado el pedido.',
                  icon: 'success',
                  confirmButtonText: 'Ok'
                }).then((result) => {
                  location.href = './pedido_compra.php';
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
    });



  });
</script>