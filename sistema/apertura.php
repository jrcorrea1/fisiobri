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
        <a href="./agregarUsuario.php" class="btn btn-success">Abrir Caja</a>
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


  <?php include_once "includes/footer.php"; ?>
  
  <script type="text/javascript">
$(document).ready(function() {

    modificar = function(usuario){
        location.href = './modificarUsuario.php?usuario='+usuario;
    }

    function handleAjaxError( xhr, textStatus, error ) {
      if ( textStatus === 'timeout' ) {
        swal("Advertencia", "Ocurrio un error intentado comunicarse con el servidor. Por favor contacte con el administrador de la red", "warning");
        document.getElementById('listado_processing').style.display = 'none';
      }else{
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
        "columns": [
            { "data": "id" }, // first column of table
            { "data": "fecha_apertura" },
            { "data": "monto_apertura" },
            { "data": "fecha_cierre" },
            { "data": "monto_cierre" },
            { "data": "estado" },           
            { "data" : "id"} // last column of table
        ],
        "columnDefs": [
            {
                "render": function ( number_row, type, row ) {
                    return '<button class="btn btn-warning btn-user btn-block" '+
                    'onclick="modificar('+row.id+');">Modificar</button>';
                },
                "orderable": false,
                "targets": 6   // columna modificar usuario
            }
        ],
        "language": {
            "decimal":        "",
            "emptyTable":     "No hay registros en la tabla",
            "info":           "Se muestran _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty":      "Se muestran 0 a 0 de 0 registros",
            "infoFiltered":   "(filtrado de _MAX_ registros totales)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "Mostrar _MENU_ registros",
            "loadingRecords": "Cargando...",
            "processing":     "Procesando...",
            "search":         "Filtar por (Nombre | Email | Rol):",
            "zeroRecords":    "No se encontraron registros que coincidan",
            "paginate": {
                "first":      "Primero",
                "last":       "Último",
                "next":       "Siguiente",
                "previous":   "Anterior"
            },
            "aria": {
                "sortAscending":  ": activar para ordenar la columna ascendente",
                "sortDescending": ": activar para ordenar la columna descendente"
            }
        }
    });
    
});
</script>
  