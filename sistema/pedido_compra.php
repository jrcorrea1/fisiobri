<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><strong>Pedido de Compras</strong></h1>
  </div>


  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="float-left">
        <h6 class="m-0 font-weight-bold text-primary">Tabla</h6>
      </div>
      <div class="float-right">
        <a href="./nuevo_pedido.php" class="btn btn-success">Nuevo Pedido</a>
      </div>
    </div>
    <div class="card-body" style="font-size: 13px">
      <div class="table-responsive">
        <table id="listado" class="table table-striped table-bordered">
          <thead class="thead-dark">
            <tr>
              <th>Codigo</th>
              <th>Fecha</th>
              <th>Proveedor</th>
              <th>Sucursal</th>
              <th>Usuario</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tfoot class="thead-dark">
            <tr>
              <th>Codigo</th>
              <th>Fecha</th>
              <th>Proveedor</th>
              <th>Sucursal</th>
              <th>Usuario</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>




<!-- End of Main Content -->


<?php include_once "includes/footer.php"; ?>

<script type="text/javascript">
  $(document).ready(function() {

    modificar = function(pedido) {
      location.href = './editar_pedido.php?pedido=' + pedido;
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

    $('#listado').DataTable({
      "processing": true,
      "serverSide": true,
      "searching": false,
      "ajax": {
        url: "./backend/listados/pedido.php",
        timeout: 10000,
        error: handleAjaxError
      },
      "columns": [{
          "data": "id"
        }, // first column of table
        {
          "data": "fecha"
        },
        {
          "data": "proveedor"
        },
        {
          "data": "sucursal"
        },
        {
          "data": "usuario"
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
   

            return row.estado == 'Comprado' ? '<button class="comprado btn btn-block btn-default btn-block" ' +
                            'onclick="javascript:void(0);" style="background-color: gray;' +
                            'color: white; cursor:not-allowed"><i class="fas fa-edit"></i></button>' :
                            '<button class="pendiente btn btn-block btn-warning btn-lg" ' +
                            'onclick="modificar(' + row.id+');"><i class="fas fa-edit"></i></button>';
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