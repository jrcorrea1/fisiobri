<?php include_once "includes/header.php";
include "../conexion.php";
include('core/config.php');
$dbconn = getConnection();
$stmt = $dbconn->query('SELECT * FROM departamentos ORDER BY departamento ASC');
// execute the statement
$departamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['barrio'])) {
    $alert = '<div class="alert alert-danger" role="alert">
                        Todo los campos son obligatorios
                    </div>';
  } else {
    $barrio = $_POST['barrio'];
    $departamento = $_POST['departamento'];
    $ciudad = $_POST['ciudad'];
    $estado = $_POST['estado'];
    $usuario_id = $_SESSION['idUser'];
    $query = mysqli_query($conexion, "SELECT * FROM barrio where barrio = '$barrio'");
    $result = mysqli_fetch_array($query);

    if ($result > 0) {
      $alert = '<div class="alert alert-danger" role="alert">
                        El barrio ya esta registrado
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
    } else {


      $query_insert = mysqli_query($conexion, "INSERT INTO barrio(barrio,ciudad,estado,usuario_id, departamento) values ('$barrio','$departamento','$estado','$usuario_id','$departamento')");
      if ($query_insert) {
        $alert = '<div class="alert alert-success" role="alert">
                        Barrio Registrado Exitosamente!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
      } else {
        $alert = '<div class="alert alert-danger" role="alert">
                       Error al registrar barrio
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                       </button>
                    </div>';
      }
    }
  }
}
//mysqli_close($conexion);
?>

<!-- Begin Page Content -->
<div class="card" style="left: 20px;right: -30;right: 20px;margin-right: 42px;margin-bottom: 20px">
  <div class="card-header text-white" style="background-color: rgb(43, 167, 228);">
    Mantenimiento de Barrios
  </div>
  <div class="card">
    <div class="card-body">
      <!-- Page Heading -->
      <div class="col-sm-2">
        <div class="card" style="width: 18rem;left: 10px;">
          <img src="img/map.png" class="card-img-top" alt="..." style="width: 150px;margin-left: 50px;margin-top: 20px;">
          <div class="card-body">
            <h5 class="card-title"><strong>Barrio</strong></h5>
          </div>
        </div>
      </div>
      <!-- Content Row -->
      <div class="card" style="margin-left: 250px;margin-right: 250px;left: 110px;padding-top: 10px;padding-bottom: 10px;bottom: 190px;">
        <div class="card" style="left: 20px;right: -30;right: 20px;margin-right: 42px;margin-bottom: 20px">
          <div class="card-header text-white" style="background-color: rgb(43, 167, 228);">
            Nuevo
          </div>
          <div class="card">
            <form action="" autocomplete="off" method="post" class="card-body p-2">
              <?php echo isset($alert) ? $alert : ''; ?>
              <div class="form-group">
                <label for="barrio">Barrio</label>
                <input type="text" placeholder="Ingrese nuevo barrio" name="barrio" id="barrio" class="form-control">
              </div>
              <div class="form-group">
                <label for="barrio">Departamento</label>
                <select class="form-control seleccion" style="width: 100%;" id="departamento" name="departamento">
                  <option value="">--- Seleccionar ---</option>
                  <?php           
                  foreach ($departamentos as $dep) {                
                    echo '<option value="' . $dep['departamento'] . '">' . $dep['departamento'] . '</option>';
                  } ?>
                </select>
              </div>
              <div class="form-group">
                <label for="barrio">Ciudad</label>
                <select class="form-control seleccion" style="width: 100%;" id="ciudad" name="ciudad" disabled>
                      <option value="">--- Seleccionar---</option>
                    </select>
              </div>

              <label for="barrio">Estado</label>
              <select name="estado" id="estado" class="form-control">
                <option value="">--- Seleccionar estado ---</option>
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>
              </select>
              <br>
              <input type="submit" value="Guardar" class="btn btn-primary">
              <a href="lista_barrio.php" class="btn btn-danger">Regresar</a>
            </form>
          </div>
        </div>
      </div>
    </div>


  </div>
  <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>
<script type="text/javascript">
      $(document).ready(function() {
        $('.seleccion').select2();

        $('#departamento').change(function() {

          if ($(this).val() != "") {
            $.ajax({
              url: './backend/listar.php',
              method: 'POST',
              data: {
                'accion': 'listarCiudad',
                'departamento': $('#departamento').val(),
                'ciudad': $('#ciudad').val()
              },
              success: function(data) {

                response = JSON.parse(data);
                if (response.status == "success") {
                  var select2 = document.getElementById("ciudad");
                  while (select2.hasChildNodes()) {
                    select2.removeChild(select2.childNodes[0]);
                  }

                  var option = document.createElement("option");
                  option.text = '--- Seleccionar ---';
                  option.value = '';
                  select2.add(option);

                  for (i = 0; i < response.ciudad.length; i++) {
                    var option = document.createElement("option");
                    option.text = response.ciudad[i].nombre;
                    option.value = response.ciudad[i].cod;
                    select2.add(option);
                  }
                  $('#ciudad').removeAttr("disabled");
                  $('#ciudad').select2();

                }
              }
            });
          } else {
            var select2 = document.getElementById("ciudad");
            while (select2.hasChildNodes()) {
              select2.removeChild(select2.childNodes[0]);
            }
            var option = document.createElement("option");
            option.text = '--- Seleccionar ---';
            option.value = '';
            select2.add(option);
            $('#ciudad').attr("disabled", "disabled");
          }
        });
      
      });
    </script>