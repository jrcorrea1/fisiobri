<?php include_once "includes/header.php";
include "../conexion.php";
include('core/config.php');
$dbconn = getConnection();
$stmt = $dbconn->query('SELECT * FROM departamentos ORDER BY departamento ASC');
// execute the statement
$departamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (!empty($_POST)) {
  $alert = "";
  if (
    empty($_POST['nombre']) ||
    empty($_POST['apellido']) ||
    empty($_POST['fecha']) ||
    empty($_POST['genero']) ||
    empty($_POST['departamento']) ||
    empty($_POST['ciudad']) ||
    empty($_POST['barrio']) ||
    empty($_POST['direccion']) ||
    empty($_POST['telefono']) ||
    empty($_POST['email'])
  ) {
    $alert = '<div class="alert alert-danger" role="alert">
                                    Todo los campos son obligatorios
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
  } else {
    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fecha = $_POST['fecha'];
    $genero = $_POST['genero'];
    $departamento = $_POST['departamento'];
    $ciudad = $_POST['ciudad'];
    $barrio = $_POST['barrio'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $usuario_id = $_SESSION['idUser'];

    $result = 0;
    if (is_numeric($dni) and $dni != 0) {
      $query = mysqli_query($conexion, "SELECT * FROM cliente where dni = '$dni'");
      $result = mysqli_fetch_array($query);
    }
    if ($result > 0) {
      $alert = '<div class="alert alert-danger" role="alert">
                                    El DNI ya existe
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
    } else {
      $query_insert = mysqli_query($conexion, "INSERT INTO cliente(dni,nombre,apellido,fecha,genero,departamento,ciudad,barrio,direccion,telefono,email, usuario_id) values ('$dni', '$nombre', '$apellido', '$fecha', '$genero','$departamento','$ciudad','$barrio','$direccion','$telefono','$email', '$usuario_id')");
      if ($query_insert) {
        $alert = '<div class="alert alert-primary" role="alert">
                                    Cliente Registrado
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
      } else {
        $alert = '<div class="alert alert-danger" role="alert">
                                    Error al Guardar
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>';
      }
    }
  }
}
?>

<div class="card" style="left: 20px;right: -30;right: 20px;margin-right: 42px;margin-bottom: 20px">
  <div class="card-header text-white" style="background-color: rgb(43, 167, 228);">
    Mantenimiento de Clientes
  </div>
  <div class="card" style="height: 1002px;">
    <div class="card-body">
      <!-- Page Heading -->
      <div class="col-sm-2">
        <div class="card" style="width: 18rem;left: 10px;">
          <img src="img/cliente.png" class="card-img-top" alt="..." style="width: 150px;margin-left: 50px;margin-top: 20px;">
          <div class="card-body">
            <h5 class="card-title"><strong>Clientes</strong></h5>
            <a href="lista_cliente.php" class="btn btn-danger">Regresar</a>

          </div>
        </div>
      </div>
      <div class="card" style="margin-left: 250px;margin-right: 250px;left: 110px;padding-top: 0px;padding-bottom: 0px;bottom: 248px;">
        <div class="card-header text-white" style="background-color: rgb(43, 167, 228);">
          Nuevo
        </div>
        <div class="col-lg-6 m-auto">
          <form id="form" action="" method="post" autocomplete="off">
            <?php echo isset($alert) ? $alert : ''; ?>
            <div class="card" style="width: 582px;right: 140px;">
              <div class="form-group col-md-5" style="margin-left: 0px;margin-right: 0px;padding-left: 35px;margin-top: 20px;">
                <label for="dni">N° Cedula</label>
                <input type="number" placeholder="Ingrese Cedula" name="dni" id="dni" class="form-control">
              </div>
              <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
                <div class="form-group col-md-5">
                  <label for="nombre">Nombres</label>
                  <input type="text" placeholder="Ingrese nombre" name="nombre" id="nombre" class="form-control">
                </div>
                <div class="form-group col-md-5">
                  <label for="apellido">Apellido</label>
                  <input type="text" placeholder="Ingrese apellido" name="apellido" id="apellido" class="form-control">
                </div>
              </div>
              <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
                <div class="form-group col-md-5">
                  <label for="nombre">Fecha de Nacimiento</label>
                  <input type="date" placeholder="Ingrese fecha" name="fecha" id="fecha" class="form-control">
                </div>
                <div class="group" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
                  <label for="genero">Genero</label>
                  <select name="genero" class="form-control">
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino" selected>Femenino</option>
                    <option value="Otros">Otros</option>
                  </select>
                </div>
              </div>
              <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
                <div class="form-group col-md-5">
                  <label for="departamento">Departamento</label>
                  <select class="form-control seleccion" style="width: 100%;" id="departamento" name="departamento">
                    <option value="">--- Seleccionar ---</option>
                    <?php
                    foreach ($departamentos as $dep) {
                      echo '<option value="' . $dep['departamento'] . '">' . $dep['departamento'] . '</option>';
                    } ?>
                  </select>
                </div>
                <div class="form-group col-md-5">
                  <label for="ciudad">Ciudad</label>
                  <select class="form-control seleccion" style="width: 100%;" id="ciudad" name="ciudad" disabled>
                    <option value="">--- Seleccionar---</option>
                  </select>

                </div>
              </div>
              <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
                <div class="form-group col-md-5">
                  <label for="barrio">Barrio</label>
                  <select class="form-control seleccion" style="width: 100%;" id="barrio" name="barrio" disabled>
                    <option value="">--- Seleccionar---</option>
                  </select>
                </div>
                <div class="form-group col-md-8">
                  <label for="direccion">Dirección</label>
                  <input type="text" placeholder="Ingrese Direccion" name="direccion" id="direccion" class="form-control">
                </div>
              </div>
              <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
                <div class="form-group col-md-5">
                  <label for="telefono">Teléfono</label>
                  <input type="number" placeholder="Ingrese Teléfono" name="telefono" id="telefono" class="form-control">
                </div>
                <div class="form-group col-md-5">
                  <label for="email">Email</label>
                  <input type="email" placeholder="Ingrese email" name="email" id="email" class="form-control">
                </div>
              </div>
              <div class="form-group col1-md-8" style="margin-bottom: 50px;">
                <input type="submit" value="Guardar Cliente" class="btn btn-primary" style="margin-left: 150px;">
                <input type="button" onclick="validar();" value="Cancelar" class="btn btn-danger" style="margin-left: 20px;margin-top: 30px;margin-right: 20px;">
              </div>
          </form>

        </div>
      </div>
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
        $('#ciudad').change(function() {
          const ciudad = $(this).val();
          if (ciudad != "") {
            $.ajax({
              url: './backend/listar.php',
              method: 'POST',
              data: {
                'accion': 'listarBarrios',
                'ciudad': $('#ciudad').val(),
                'departamento': $('#departamento').val()
              },
              success: function(data) {

                response = JSON.parse(data);
                if (response.status == "success") {
                  var select2 = document.getElementById("barrio");
                  while (select2.hasChildNodes()) {
                    select2.removeChild(select2.childNodes[0]);
                  }
                  var option = document.createElement("option");
                  option.text = '--- Seleccionar ---';
                  option.value = '';
                  select2.add(option);

                  for (i = 0; i < response.barrios.length; i++) {
                    var option = document.createElement("option");
                    option.text = response.barrios[i].nombre;
                    option.value = response.barrios[i].cod;
                    select2.add(option);
                  }
                  $('#barrio').removeAttr("disabled");
                  $('#barrio').select2();
                }

              }
            });
          } else {
            var select2 = document.getElementById("barrio");
            while (select2.hasChildNodes()) {
              select2.removeChild(select2.childNodes[0]);
            }
            var option = document.createElement("option");
            option.text = '--- Seleccionar ---';
            option.value = '';
            select2.add(option);
            $('#barrio').attr("disabled", "disabled");
          }
        });
      });
    </script>