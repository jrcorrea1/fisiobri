<?php include_once "includes/header.php";
include "../conexion.php";
include('core/config.php');
$dbconn = getConnection();
$stmt = $dbconn->query('SELECT * FROM banco ORDER BY id ASC');
// execute the statement
$bancos = $stmt->fetchAll(PDO::FETCH_ASSOC);
// usuario
$stmt = $dbconn->query("SELECT id_caja,estado FROM apertura_cierre WHERE usuario_id=" . $_SESSION['idUser'] . " ORDER BY id_caja DESC LIMIT 1");
$apertura = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="row" style="margin-bottom: 50px;">
    <div class="col-lg-6 m-auto">
      <?php echo isset($alert) ? $alert : ''; ?>
      <form id="form">
        <div class="card">
          <div class="card-header bg-primary text-white">
            Registro de Cobros
          </div>
          <div class="form-group col-md-6" style="margin-left: 0px;margin-right: 0px;padding-left: 35px;margin-top: 20px;">
            <label for="dni">N° de factura</label>
            <input type="hidden" class="form-control" id="apertura" name="apertura" value="<?= $apertura['estado'] == 1 ? $apertura['id_caja'] : 0; ?>">
            <input type="number" placeholder="Ingrese numero de factura" name="factura" id="factura" class="form-control">
          </div>
          <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
            <div class="form-group col-md-6">
              <label for="fecha">Fecha</label>
              <input type="text" placeholder="" name="fecha" id="fecha" class="form-control" readonly>
            </div>
            <div class="form-group col-md-6">
              <label for="apellido">Cliente</label>
              <input type="text" placeholder="" name="cliente" id="cliente" class="form-control" readonly>
            </div>
          </div>
          <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
            <div class="form-group col-md-6">
              <label for="monto">Importe a cobrar</label>
              <input type="text" placeholder="" name="monto" id="monto" class="form-control">
            </div>
            <div class="form-group col-md-6" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
              <label for="formacobro">Forma de Cobro</label>
              <select id="formacobro" name="formacobro" class="form-control">
                <option value="">--- Seleccionar ---</option>
                <option value="Efectivo">Efectivo</option>
                <option value="Tarjeta">Tarjeta</option>
                <option value="Cheque">Cheque</option>
              </select>
            </div>
          </div>
          <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px; display: none;" id="bloque">
            <div class="form-group col-md-6">
              <label for="cheque">N° de cheque</label>
              <input type="number" placeholder="" name="cheque" id="cheque" class="form-control">
            </div>
            <div class="form-group col-md-6" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
              <label for="banco">Banco</label>
              <select class="form-control seleccion" style="width: 100%;" id="banco" name="banco">
                <option value="">--- Seleccionar ---</option>
                <?php
                foreach ($bancos as $banco) {
                  echo '<option value="' . $banco['id'] . '">' . $banco['banco'] . '</option>';
                } ?>
              </select>
            </div>
          </div>
          <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
            <div class="form-group col-md-5">
              <input type="hidden" name="accion" value="cobrar">
              <button type="submit" id="guardar" class="btn btn-primary">Confirmar</button>
              <button type="button" onclick="validar();" class="btn btn-danger">Limpiar</button>
            </div>
          </div>


        </div>
      </form>
    </div>
  </div>




  <!-- /.container-fluid -->
  <div class="table-responsive">
    <table class="table table-hover" id="listado">
      <thead class="thead-dark">
        <tr>
          <th width="100px">ID</th>
          <th>FACTURA N°</th>
          <th>FECHA</th>
          <th width="100px">CLIENTE</th>
          <th class="textright">MONTO</th>
          <th class="textright">FORMA DE COBRO</th>
          <?php if ($_SESSION['rol'] == 1) { ?>
            <th>ACCIONES</th>
          <?php } ?>
        </tr>
      </thead>

    </table>
  </div>

</div>

<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>
<script type="text/javascript">
  $(document).ready(function() {
    $('.seleccion').select2();
    $('#factura').keyup(function() {
      if ($(this).val() != "") {
        $.ajax({
          url: './backend/listar.php',
          method: 'POST',
          data: {
            'factura': $('#factura').val(),
            'accion': 'searchfactura'
          },
          success: function(data) {
            response = JSON.parse(data);
            if (response.status == "success") {

              $('#factura').val(response.factura.nofactura);
              $('#cliente').val(response.factura.nombre + ' ' + response.factura.apellido);
              $('#fecha').val(response.factura.fecha);
              $('#monto').val(response.factura.monto);

            } else if (response.status == "error") {



            }
          }
        });
      }
    });

    $('#formacobro').change(function() {
      if ($(this).val() == 'Cheque') {
        $('#bloque').show();
      } else {
        $('#bloque').hide();

      }
    });

    const estado = $('#apertura').val();
    if (estado == 0) {

      setTimeout(function() {
        Swal.fire({
          title: 'Alerta',
          text: 'Debe abrir una caja antes de realizar operaciones',
          icon: 'warning',
          confirmButtonText: 'Ok'
        }).then((result) => {
          location.href = './apertura-cierre.php';
        });
      }, 1000);
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






    var table1 = $('#listado').DataTable({
      "processing": true,
      "serverSide": true,
      "ordering": false,
      "searching": false,
      "ajax": {
        "url": "./backend/listados/cobros.php",
        timeout: 15000,
        error: handleAjaxError
      },
      "columns": [{
          "data": "id"
        }, // first column of table
        {
          "data": "factura"
        },
        {
          "data": "fecha"
        },
        {
          "data": "cliente"
        },
        {
          "data": "monto"
        },
        {
          "data": "formacobro"
        }
        <?php if ($_SESSION['rol'] == 1) { ?>, {
            "data": "id"
          } // last column of table
        ],
      "columnDefs": [{
          "render": function(number_row, type, row) {
            return '<button class="btn btn-danger"' +
              'onclick="anular(' + row.id + ');"><i class="fas fa-trash-alt"></i></button>';
          },
          "orderable": false,
          "targets": 6 // columna modificar usuario
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






    function enviarFormulario() {
      $('#guardar').attr("disabled", "disabled");
      $.ajax({
        url: './backend/cobros.php',
        method: 'POST',
        data: $('#form').serialize(),
        success: function(data) {
          try {
            response = JSON.parse(data);
            if (response.status == "success") {
              setTimeout(function() {
                Swal.fire({
                  title: 'Exito',
                  text: response.message,
                  icon: 'success',
                  confirmButtonText: 'Ok'
                }).then((result) => {
                  location.reload();
                });
              }, 1000);
            } else if (response.status == "error") {
              setTimeout(function() {
                Swal.fire({
                  title: 'Advertencia',
                  text: response.message,
                  icon: 'warning',
                  confirmButtonText: 'Ok'
                }).then((result) => {
                  location.reload();
                });
              }, 1000);
              $('#guardar').removeAttr("disabled");
            }
          } catch (error) {
            Swal.fire({
              title: 'Advertencia',
              text: "Ocurrio un error intentado comunicarse con el servidor. Por favor intentelo de nuevo mas tarde",
              icon: 'warning',
              confirmButtonText: 'Ok'
            });
            console.log(error);
          }
        },
        error: function(error) {
          Swal.fire({
            title: 'Advertencia',
            text: "Ocurrio un error intentado comunicarse con el servidor. Por favor intentelo de nuevo mas tarde",
            icon: 'warning',
            confirmButtonText: 'Ok'
          });
          console.log(error);
        }
      });
    }

    $('#form').submit(function(e) {
      e.preventDefault();
      $('#success').hide();
      $('#error').hide();
      $('#warning').hide();
      if ($('#factura').val() == "") {
        Swal.fire({
          title: 'Advertencia',
          text: "Debe cargar el numero de la factura",
          icon: 'warning',
          confirmButtonText: 'Ok'
        });
      } else if ($('#fecha').val() == "") {
        Swal.fire({
          title: 'Advertencia',
          text: "Debe cargar la fecha de la factura",
          icon: 'warning',
          confirmButtonText: 'Ok'
        });
      } else if ($('#cliente').val() == "") {
        Swal.fire({
          title: 'Advertencia',
          text: "Debe cargar el codigo del cliente",
          icon: 'warning',
          confirmButtonText: 'Ok'
        });
      } else if ($('#monto').val() == "") {
        Swal.fire({
          title: 'Advertencia',
          text: "Debe cargar el monto a cobrar del cliente",
          icon: 'warning',
          confirmButtonText: 'Ok'
        });
      } else if ($('#formacobro').val() == "") {
        Swal.fire({
          title: 'Advertencia',
          text: "Debe cargar la forma de cobro",
          icon: 'warning',
          confirmButtonText: 'Ok'
        });
      } else if ($('#formacobro').val() == "Cheque" && ($('#cheque').val() == "" || $('#banco').val() == "")) {
        Swal.fire({
          title: 'Advertencia',
          text: "Debe cargar el numero del cheque y el banco",
          icon: 'warning',
          confirmButtonText: 'Ok'
        });
      } else {
        enviarFormulario();
      }

    });


  });
</script>