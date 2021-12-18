<?php include_once "includes/header.php";
include "../conexion.php";
include('core/config.php');
$dbconn = getConnection();
$stmt = $dbconn->query('SELECT * FROM banco ORDER BY id ASC');
// execute the statement
$bancos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="row" style="margin-bottom: 50px;">
    <div class="col-lg-6 m-auto">
      <?php echo isset($alert) ? $alert : ''; ?>
      <form id="cobros">
        <div class="card">
          <div class="card-header bg-primary text-white">
            Registro de Cobros
          </div>
          <div class="form-group col-md-5" style="margin-left: 0px;margin-right: 0px;padding-left: 35px;margin-top: 20px;">
            <label for="dni">N° de factura</label>
            <input type="number" placeholder="Ingrese numero de factura" name="factura" id="factura" class="form-control">
          </div>
          <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
            <div class="form-group col-md-5">
              <label for="fecha">Fecha</label>
              <input type="text" placeholder="" name="fecha" id="fecha" class="form-control">
            </div>
            <div class="form-group col-md-5">
              <label for="apellido">Id cliente</label>
              <input type="text" placeholder="" name="cliente" id="cliente" class="form-control">
            </div>
          </div>
          <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
            <div class="form-group col-md-5">
              <label for="monto">Importe a cobrar</label>
              <input type="text" placeholder="" name="monto" id="monto" class="form-control">
            </div>
            <div class="form-group col-md-5" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
              <label for="formacobro">Forma de Cobro</label>
              <select name="formacobro" class="form-control">
                <option value="">--- Seleccionar ---</option>
                <option value="Efectivo">Efectivo</option>
                <option value="Tarjeta">Tarjeta</option>
                <option value="Cheque">Cheque</option>
              </select>
            </div>
          </div>
          <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
            <div class="form-group col-md-5">
              <label for="cheque">N° de cheque</label>
              <input type="number" placeholder="" name="cheque" id="cheque" class="form-control">
            </div>
            <div class="form-group col-md-5" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
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
              <button type="submit" class="btn btn-primary">Confirmar</button>
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
        <?php if ($_SESSION['rol'] == 1) { ?>
          ,  {
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









  });
</script>