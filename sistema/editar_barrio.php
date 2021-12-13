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
              Todos los campos son requeridos
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
            </div>';
  } else {
    $idbarrio = $_GET['id'];
    $barrio = $_POST['barrio'];
    $ciudad = $_POST['ciudad'];
    $departamento = $_POST['departamento'];
    $estado = $_POST['estado'];
    $sql_update = mysqli_query($conexion, "UPDATE barrio SET barrio = '$barrio', ciudad = '$ciudad', departamento = '$departamento', estado = '$estado' WHERE id = $idbarrio");

    if ($sql_update) {
      $alert = '<div class="alert alert-primary" role="alert">
                  Modificado Correctamente!
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
              </div>';
    } else {
      $alert = '<div class="alert alert-danger" role="alert">
                Error al Actualizar
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
              </div>';
    }
  }
}
// Mostrar Datos

if (empty($_REQUEST['id'])) {
  header("Location: lista_barrio.php");
  mysqli_close($conexion);
}
$idbarrio = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM barrio WHERE id = $idbarrio");
mysqli_close($conexion);
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
  header("Location: lista_barrio.php");
} else {
  while ($data = mysqli_fetch_array($sql)) {
    $idbarrio = $data['id'];
    $barrio = $data['barrio'];
    $ciudad = $data['ciudad'];
    $departamento = $data['departamento'];
  }
}
?>
<!-- Begin Page Content -->
<div class="card" style="left: 20px;right: -30;right: 20px;margin-right: 42px;margin-bottom: 20px">
  <div class="card-header text-white" style="background-color: rgb(43, 167, 228);">
    Mantenimiento de Barrios / Editar
  </div>
  <div class="card">
    <div class="card-body">
      <div class="col-lg-6 m-auto">
        <div class="card-header bg-primary text-white">
          Editar barrio
        </div>
        <div class="card">
          <div class="row">
            <div class="col-lg-6 m-auto">
              <?php echo isset($alert) ? $alert : ''; ?>
              <form class="" action="" method="post">
                <input type="hidden" name="id" value="<?php echo $idbarrio; ?>">
                <div class="form-group">
                  <label for="barrio">Barrio</label>
                  <input type="text" placeholder="Ingrese barrio" name="barrio" class="form-control" id="barrio" value="<?=$barrio; ?>">
                </div>
                <div class="form-group">
                  <label for="barrio">Departamento</label>
                  <input type="text" placeholder="Ingrese barrio" name="depa" class="form-control" id="depa" value="<?= $departamento; ?>">
                </div>
                <div class="form-group">
                  <label for="barrio">Ciudad</label>
                  <input type="text" placeholder="Ingrese barrio" name="ciu" class="form-control" id="ciu" value="<?= $ciudad; ?>">
                </div>
                <div class="form-group">
                  <label for="barrio">Departamento</label>
                  <select class="form-control seleccion" style="width: 100%;" id="departamento" name="departamento">
                    <option value="">--- Seleccionar ---</option>
                    <?php
                    foreach ($departamentos as $dep) {
                      $selected = ($dep['departamento'] == $departamento) ? "selected" : null;
                      echo '<option value="' . $dep['departamento'] . '" ' . $selected . '>' . $dep['departamento'] . '</option>';
                    } ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="barrio">Ciudad</label>
                  <select class="form-control seleccion" style="width: 100%;" id="ciudad" name="ciudad">
                    <option value="">--- Seleccionar ---</option>                   
                  </select>
                </div>
                <div class="row">
                  <label for="cars">Estado</label>
                  <select name="estado" id="estado" class="form-control">
                    <option value="">--- Seleccionar estado ---</option>
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                  </select>
                </div><br>
                <input type="submit" value="Actualizar" class="btn btn-primary">
                <a href="lista_barrio.php" class="btn btn-danger">Regresar</a>
              </form>
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
            console.log($(this).val());
            $.ajax({
              url: './backend/listar.php',
              method: 'POST',
              data: {
                'accion': 'listarCiudad',
                'departamento': '<?=$departamento; ?>'
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

      
      $('#departamento').change();
    </script>