<?php include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['nombre']) ||
  empty($_POST['apellido']) ||
  empty($_POST['fecha']) ||
  empty($_POST['genero']) ||
  empty($_POST['cargo']) ||
  empty($_POST['pais']) ||
  empty($_POST['departamento']) ||
  empty($_POST['ciudad']) ||
  empty($_POST['barrio']) ||
  empty($_POST['direccion']) ||
  empty($_POST['telefono']) ||
  empty($_POST['email'])) {
    $alert = '<div class="alert alert-danger" role="alert">
                Todos los campos son requeridos
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>';
  } else {
    $idpersonal = $_POST['id'];
    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fecha = $_POST['fecha'];
    $genero = $_POST['genero'];
    $cargo = $_POST['cargo'];
    $pais = $_POST['pais'];
    $departamento = $_POST['departamento'];
    $ciudad = $_POST['ciudad'];
    $barrio = $_POST['barrio'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    $result = 0;
    if (is_numeric($dni) and $dni != 0) {

      $query = mysqli_query($conexion, "SELECT * FROM personal where (dni = '$dni' AND idpersonal != $idpersonal)");
      $result = mysqli_fetch_array($query);
      $resul = mysqli_num_rows($query);
    }

    if ($resul >= 1) {
      $alert = '<div class="alert alert-danger" role="alert">
                  El DNI ya existe
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
              </div>';
    } else {
      if ($dni == '') {
        $dni = 0;
      }
      $sql_update = mysqli_query($conexion, "UPDATE personal SET dni = '$dni', nombre = '$nombre' ,apellido = '$apellido',fecha = '$fecha',
        genero = '$genero',cargo = '$cargo',pais = '$pais',departamento = '$departamento',ciudad = '$ciudad',barrio = '$barrio',
        direccion = '$direccion',telefono = '$telefono', email = '$email' WHERE idpersonal = $idpersonal");

      if ($sql_update) {
        $alert = '<div class="alert alert-primary" role="alert">
                    Modificado Exitosamente
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
      } else {
        $alert =   $alert = '<div class="alert alert-danger" role="alert">
                     Error al modificar
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>';
      }
    }
  }
}
// Mostrar Datos

if (empty($_REQUEST['id'])) {
  header("Location: lista_personal.php");
}
$idpersonal = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM personal WHERE idpersonal = $idpersonal");
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
  header("Location: lista_personal.php");
} else {
  while ($data = mysqli_fetch_array($sql)) {
    $idpersonal = $data['idpersonal'];
    $dni = $data['dni'];
    $nombre = $data['nombre'];
    $apellido = $data['apellido'];
    $fecha = $data['fecha'];
    $genero = $data['genero'];
    $cargo = $data['cargo'];
    $pais = $data['pais'];
    $departamento = $data['departamento'];
    $ciudad = $data['ciudad'];
    $barrio = $data['barrio'];
    $direccion = $data['direccion'];
    $telefono = $data['telefono'];
    $email = $data['email'];
}
}
?>
      <!-- Begin Page Content -->
      <div class="container-fluid">
      <h1 class="h3 mb-0 text-gray-800" style="padding-left: 20px;">
        Mantenimiento Personal</h1><br>
          <!-- Page Heading -->

          <!-- Content Row -->
          <div class="row" style="
          margin-bottom: 50px;
      ">
            <div class="col-lg-6 m-auto">

              <form class="" action="" method="post">
                <?php echo isset($alert) ? $alert : ''; ?>
                <div class="card">
                  <div class="card-header bg-primary text-white">
                    Editar personal
                  </div>
                <input type="hidden" name="id" value="<?php echo $idpersonal; ?>">
              <div class="form-group col-md-5" style="margin-left: 0px;margin-right: 0px;padding-left: 35px;margin-top: 20px;">
                  <label for="dni">N° Cedula</label>
                  <input type="number" placeholder="Ingrese Cedula" name="dni" id="dni" class="form-control" value="<?php echo $dni; ?>">
              </div>
              <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
              <div class="form-group col-md-5">
                  <label for="nombre">Nombres</label>
                  <input type="text" placeholder="Ingrese nombre" name="nombre" id="nombre" class="form-control" value="<?php echo $nombre; ?>">
              </div>
              <div class="form-group col-md-5">
                  <label for="apellido">Apellido</label>
                  <input type="text" placeholder="Ingrese apellido" name="apellido" id="apellido" class="form-control" value="<?php echo $apellido; ?>">
              </div>
              </div>
                <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
                <div class="form-group col-md-5">
                  <label for="fecha">Fecha de Nacimiento</label>
                  <input type="date" placeholder="Ingrese fecha" name="fecha" id="fecha" class="form-control" value="<?php echo $fecha; ?>">
              </div>
              <div class="form-group col-md-5">
                  <label for="genero">Genero</label>
                  <select name="genero" style="
  margin-top: 32px;
  margin-left: 10px;
  padding-right: 45px;
">
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino" selected>Femenino</option>
                    <option value="Otros">Otros</option>
                  </select>
              </div>
              </div>
              <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
              <div class="form-group col-md-5">
                  <label for="cargo">Cargo</label>
                  <?php
                   $query_cargo = mysqli_query($conexion, "SELECT id, cargo FROM cargo ORDER BY cargo ASC");
                   $resultado_cargo = mysqli_num_rows($query_cargo);
                   //mysqli_close($conexion);
                   ?>
                  <select id="cargo" name="cargo" class="form-control">
                    <?php
                     if ($resultado_cargo > 0) {
                       while ($cargo = mysqli_fetch_array($query_cargo)) {
                         // code...
                     ?>
                        <option value="<?php echo $cargo['cargo']; ?>"><?php echo $cargo['cargo']; ?></option>
                    <?php
                       }
                     }
                     ?>
                  </select>
              </div>
                <div class="form-group col-md-5">
                    <label for="pais">Nacionalidad</label>
                    <?php
                     $query_pais = mysqli_query($conexion, "SELECT id, pais FROM paises ORDER BY pais ASC");
                     $resultado_pais = mysqli_num_rows($query_pais);
                     //mysqli_close($conexion);
                     ?>
                    <select id="pais" name="pais" class="form-control">
                      <?php
                       if ($resultado_pais > 0) {
                         while ($pais = mysqli_fetch_array($query_pais)) {
                           // code...
                       ?>
                          <option value="<?php echo $pais['pais']; ?>"><?php echo $pais['pais']; ?></option>
                      <?php
                         }
                       }
                       ?>
                    </select>
                </div>
                </div>

              <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
              <div class="form-group col-md-5">
                  <label for="departamento">Departamento</label>
                  <?php
                   $query_departamento = mysqli_query($conexion, "SELECT id, departamento FROM departamentos ORDER BY departamento ASC");
                   $resultado_departamento = mysqli_num_rows($query_departamento);
                   //mysqli_close($conexion);
                   ?>
                  <select id="departamento" name="departamento" class="form-control">
                    <?php
                     if ($resultado_departamento > 0) {
                       while ($departamento = mysqli_fetch_array($query_departamento)) {
                         // code...
                     ?>
                        <option value="<?php echo $departamento['departamento']; ?>"><?php echo $departamento['departamento']; ?></option>
                    <?php
                       }
                     }
                     ?>
                  </select>
              </div>
              <div class="form-group col-md-5">
                  <label for="ciudad">Ciudad</label>
                  <?php
                   $query_ciudad = mysqli_query($conexion, "SELECT id, ciudad FROM ciudad ORDER BY ciudad ASC");
                   $resultado_ciudad = mysqli_num_rows($query_ciudad);
                   mysqli_close($conexion);
                   ?>
                  <select id="ciudad" name="ciudad" class="form-control">
                    <?php
                     if ($resultado_ciudad > 0) {
                       while ($ciudad = mysqli_fetch_array($query_ciudad)) {
                         // code...
                     ?>
                        <option value="<?php echo $ciudad['ciudad']; ?>"><?php echo $ciudad['ciudad']; ?></option>
                    <?php
                       }
                     }
                     ?>
                  </select>
              </div>
              </div>
              <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
              <div class="form-group col-md-5">
                  <label for="barrio">Barrio</label>
                  <input type="text" placeholder="Ingrese barrio" name="barrio" id="barrio" class="form-control" value="<?php echo $barrio; ?>">
              </div>
              <div class="form-group col-md-5">
                  <label for="direccion">Dirección</label>
                  <input type="text" placeholder="Ingrese Direccion" name="direccion" id="direccion" class="form-control" value="<?php echo $direccion; ?>">
              </div>
              </div>
              <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
              <div class="form-group col-md-5">
                  <label for="telefono">Teléfono</label>
                  <input type="number" placeholder="Ingrese Teléfono" name="telefono" id="telefono" class="form-control" value="<?php echo $telefono; ?>">
              </div>
              <div class="form-group col-md-5">
                  <label for="email">Email</label>
                  <input type="email" placeholder="Ingrese email" name="email" id="email" class="form-control" value="<?php echo $email; ?>">
              </div>
              </div>
              <div class="form-group col1-md-8" style="
  margin-bottom: 50px;
">

                <input type="submit" value="Actualizar" class="btn btn-primary" style="margin-left: 220px;">
                <a href="lista_personal.php" class="btn btn-danger">Regresar</a>
              </form>
            </div>
          </div>
</div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
      <?php include_once "includes/footer.php"; ?>
