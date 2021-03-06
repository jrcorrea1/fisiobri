<?php include_once "includes/header.php";
include('core/config.php');
$dbconn = getConnection();
// usuario
$idpedido = trim($_GET['pedido']);
$stmt = $dbconn->prepare('SELECT * FROM pedido_compra WHERE id = :id');
$stmt->bindValue(":id", $idpedido);
$stmt->execute();
$pedido = $stmt->fetch(PDO::FETCH_ASSOC);

// dia_semana
$stmt3 = $dbconn->query('SELECT codproveedor, proveedor FROM proveedor');
$proveedor = $stmt3->fetchAll(PDO::FETCH_ASSOC);
$stmt4 = $dbconn->query('SELECT idsucursal, nombre FROM sucursal');
$sucursales = $stmt4->fetchAll(PDO::FETCH_ASSOC);
$fechaingreso = date('Y-m-d H:i:s');
$fecha = date("d/m/Y", strtotime($pedido['fecha']));
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
              <h1 class="h4 text-gray-900 mb-3">Editar Pedido</h1>
            </div>
            <form id="form_pedido" class="user">
              <div class="card-header py-3">
                <div class="float-left">


                </div>
                <div class="float-right">

                  <button class="btn btn-primary" id="cancelar" type="button">Cancelar</button>
                  <input type="hidden" name="accion" value="modificapedido">
                  <button class="btn btn-primary" id="guardar" type="submit">Guardar</button>
                </div>
              </div>
              <br>

              <br>
              <h1 class="h4 text-gray-900 mb-4">Datos del Pedido</h1>
              <div class="form-group row mb-3">
                <div class="col-sm-4">
                  <label>Nro. Pedido</label>
                  <input type="text" id="pedido" name="pedido" class="form-control" value="<?= $pedido['id']; ?>" readonly>
                </div>
                <div class="col-sm-4">
                  <label>Usuario</label>
                  <input type="text" class="form-control" value="<?= $_SESSION['nombre']; ?>" readonly>
                </div>
                <div class="col-sm-4">
                  <label>Fecha</label>
                  <div class="input-group date datepicker">
                    <input type="text" class="form-control" value="<?= $fecha; ?>" required disabled="" />
                    <span class="input-group-addon btn btn-primary">
                      <i class="fa fa-calendar"></i>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-group row mb-3">
                <div class="col-sm-4">
                  <label>Proveedor</label>
                  <select class="form-control seleccion" style="width: 100%;" id="codproveedor" name="codproveedor">
                    <option value="">--- Seleccionar ---</option>
                    <?php foreach ($proveedor as $provedor) {
                      $selected = ($provedor['codproveedor'] == $pedido['proveedor_id']) ? "selected" : null;
                      echo '<option value="' . $provedor['codproveedor'] . '" ' . $selected . '>' . $provedor['proveedor'] . '</option>';
                    } ?>
                  </select>
                </div>
                <div class="col-sm-4">
                  <label>Sucursal</label>
                  <select class="form-control seleccion" style="width: 100%;" id="sucursal_id" name="sucursal_id">
                    <option value="">--- Seleccionar ---</option>
                    <?php foreach ($sucursales as $sucursal) {
                      $selected = ($sucursal['idsucursal'] == $pedido['sucursa_id']) ? "selected" : null;
                      echo '<option value="' . $sucursal['idsucursal'] . '" ' . $selected . '>' . $sucursal['nombre'] . '</option>';
                    } ?>

                  </select>
                </div>

              </div>


            </form>



            <div class="card shadow mb-12">
              <div class="card-header py-3">
                <div class="float-left">
                  <h6 class="m-0 font-weight-bold text-primary"></h6>
                </div>
                <div class="float-right">
                  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">
                    <span class="glyphicon glyphicon-plus"></span> Agregar productos
                  </button>
                </div>
              </div>
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
                        <th>Accion</th>
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
          <h4 class="modal-title" id="myModalLabel">Buscar productos</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group row mb-3">
            <div class="col-sm-8">
              <input type="text" class="form-control" id="des" name="des" placeholder="Buscar productos">
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
              <table id="listaproducto" class="table table-bordered" width="100%" cellspacing="0">
                <thead class="thead-dark">
                  <tr>
                    <th>ID</th>
                    <th style=" white-space: nowrap;">Nombre</th>
                    <th>Precio</th>
                    <th>Marca</th>
                    <th>Categoria</th>
                    <th>Cantidad</th>
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



    var table = $('#listaproducto').DataTable({
      "processing": true,
      "serverSide": true,
      "ordering": false,
      "searching": false,

      "ajax": {
        "url": "./backend/listados/producto.php",
        timeout: 15000,
        error: handleAjaxError,
        "data": function(data) {
          data.des = $('#des').val()
        }
      },
      "columns": [{
          "data": "codproducto"
        },
        {
          "data": "descripcion"
        },
        {
          "data": "precio"
        },
        {
          "data": "marca"
        },
        {
          "data": "categoria"
        },
        {
          "data": "codproducto"
        }

        // last column of table
      ],
      "columnDefs": [{
          "render": function(number_row, type, row) {
            return "<input id='cantidad_" + row.codproducto + "'  class='form-control' type='number'/>";
          },
          "orderable": false,
          "targets": 5 // columna HORARIO - INICIO
        },
        {
          "render": function(number_row, type, row) {
            return '<button class="btn btn-success btn-user" ' +
              'onclick="insertadetalle(' + row.codproducto + ');"><i class="fa fa-shopping-cart"></i></button>';
          },
          "orderable": false,
          "targets": 6 // columna modificar usuario
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
        "search": "Filtar por (N??mero | Fecha | C??dula | Depto | Distrito):",
        "zeroRecords": "No se encontraron registros que coincidan",
        "paginate": {
          "first": "Primero",
          "last": "??ltimo",
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

    insertadetalle = function(codproducto) {
      event.preventDefault();


      datos = {
        "accion": "insertadetalle",
        "pedido": $('#pedido').val(),
        "producto": codproducto,
        "cantidad": $('#cantidad_' + codproducto).val()
      };
      console.log(datos);

      $.ajax({
        url: './backend/pedido.php',
        method: 'POST',
        data: datos,
        success: function(data) {
          try {
            response = JSON.parse(data);

            if (response.status == "success") {
              $('#myModal').modal('hide');
              table.ajax.reload();
              table1.ajax.reload();

            } else {
              swal("Advertencia", "Ocurrio un error intentado resolver la solicitud. Por favor contacte con el administrador del sistema", "warning");
            }
          } catch (error) {
            swal("Advertencia", "Ocurrio un error intentado resolver la solicitud. Por favor contacte con el administrador del sistema", "warning");
          }
        },
        error: function(data) {
          swal("Advertencia", "Ocurrio un error intentado comunicarse con el servidor. Por favor contacte con el administrador de la red", "warning");
        }
      });
    };

    var table1 = $('#listado').DataTable({
      "processing": true,
      "serverSide": true,
      "ordering": false,
      "searching": false,
      "ajax": {
        "url": "./backend/listados/detallepedido.php",
        timeout: 15000,
        error: handleAjaxError,
        "data": function(data) {
          data.pedido = $('#pedido').val()
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
        },
        {
          "data": "id"
        } // last column of table
      ],
      "columnDefs": [{
        "render": function(number_row, type, row) {
          return '<button class="btn btn-warning btn-user btn-block" ' +
            'onclick="eliminar(' + row.id_pedido + ',' + row.codigo + ');">Quitar</button>';
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
          "last": "??ltimo",
          "next": "Siguiente",
          "previous": "Anterior"
        },
        "aria": {
          "sortAscending": ": activar para ordenar la columna ascendente",
          "sortDescending": ": activar para ordenar la columna descendente"
        }
      }
    });

    eliminar = function(pedido, codigo) {
      event.preventDefault();
      datos = {
        "accion": "eliminadetalle",
        "pedido": pedido,
        "producto": codigo
      };
      console.log(datos);

      $.ajax({
        url: './backend/pedido.php',
        method: 'POST',
        data: datos,
        success: function(data) {
          try {
            response = JSON.parse(data);

            if (response.status == "success") {

              table1.ajax.reload();

            } else {
              Swal.fire({
                title: 'Advertencia!',
                text: 'Ocurrio un error intentado comunicarse con el servidor. Por favor contacte con el administrador del sistema',
                icon: 'warning',
                confirmButtonText: 'OK'
              });
            }
          } catch (error) {
            Swal.fire({
              title: 'Advertencia!',
              text: 'Ocurrio un error intentado comunicarse con el servidor. Por favor contacte con el administrador del sistema',
              icon: 'warning',
              confirmButtonText: 'OK'
            });
          }
        },
        error: function(data) {
          Swal.fire({
            title: 'Advertencia!',
            text: 'Ocurrio un error intentado comunicarse con el servidor. Por favor contacte con el administrador de la red',
            icon: 'warning',
            confirmButtonText: 'OK'
          });
        }
      });
    };



    $('#form_pedido').submit(function(e) {
      e.preventDefault();
      $('#success').hide();
      $('#error').hide();
      $('#warning').hide();
      if ($('#codproveedor').val() == "") {
        swal({
          title: "Advertencia",
          text: "Favor cargar el proveedor",
          type: "warning",
          confirmButtonText: "Ok",
          closeOnConfirm: false
        });
      } else {
        $('#guardar').attr("disabled", "disabled");
        const valor = $('#form_pedido').val();
        console.log($('#form_pedido').val());
        $.ajax({
          url: './backend/pedido.php',
          method: 'POST',
          data: $('#form_pedido').serialize(),
          success: function(data) {
            try {
              response = JSON.parse(data);
              if (response.status == "success") {

                setTimeout(function() {
                  Swal.fire({
                    title: '??xito',
                    text: 'Pedido modificado con exito.',
                    icon: 'success',
                    confirmButtonText: 'OK',

                  }).then((result) => {
                    location.href = './pedido_compra.php';
                  });
                }, 2000);


              } else if (response.status == "error" && response.message == "No autorizado") {
                Swal.fire({
                  title: "Sesi??n ha expirado",
                  text: "Su sesi??n ha expirado, favor vuelva a iniciar sesi??n en el sistema.",
                  type: "warning",
                  confirmButtonText: "Ok",
                  closeOnConfirm: false
                });


              } else {
                $('#error_message').html(response.message);
                $('#error').show();
                $('#guardar').removeAttr("disabled");
              }
            } catch (error) {
              Swal.fire({
                title: "Error",
                text: "Ocurrio un error intentado comunicarse con el servidor. Por favor contacte con el administrador del sistema",
                type: "warning",
                confirmButtonText: "Ok",
                closeOnConfirm: false
              });
              console.log(error);

            }
          },
          error: function(error) {
            Swal.fire({
              title: 'Advertencia!',
              text: 'Ocurrio un error intentado comunicarse con el servidor. Por favor contacte con el administrador de la red',
              icon: 'warning',
              confirmButtonText: 'OK'
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
        data: "accion=cancelarpedido&pedido=" + $('#pedido').val(),
        success: function(data) {
          try {
            response = JSON.parse(data);
            if (response.status == "success") {
              setTimeout(function() {
                Swal.fire({
                  title: '??xito',
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
            text: "Ocurrio un error intentado comunicarse con el servidor. Por favor contacte con el administrador de la red",
            icon: 'warning',
            confirmButtonText: 'Ok'
          });
        }
      });
    });



  });
</script>