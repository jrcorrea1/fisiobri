<?php include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['nombre']) ||
    empty($_POST['apellido']) ||
    empty($_POST['fecha']) ||
    empty($_POST['genero']) ||
    empty($_POST['departamento']) ||
    empty($_POST['ciudad']) ||
    empty($_POST['barrio']) ||
    empty($_POST['direccion']) ||
    empty($_POST['telefono']) ||
    empty($_POST['email'])) {
        $alert = '<div class="alert alert-danger" role="alert">
                                    Todo los campos son obligatorio
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
//    mysqli_close($conexion);
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">
<h1 class="h3 mb-0 text-gray-800" style="padding-left: 20px;">
  Mantenimiento Cliente</h1><br>
    <!-- Page Heading -->
    <!-- Content Row -->
    <div class="row" style="
    margin-bottom: 50px;
">
        <div class="col-lg-6 m-auto">
            <form action="" method="post" autocomplete="off">
                <?php echo isset($alert) ? $alert : ''; ?>
                <div class="card">
                  <div class="card-header bg-primary text-white">
                    Registro Cliente
                  </div>
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
                    <?php
                     $query_departamento = mysqli_query($conexion, "SELECT id, departamento FROM departamentos ORDER BY departamento ASC");
                     $resultado_departamento = mysqli_num_rows($query_departamento);
                     //mysqli_close($conexion);
                     ?>
                      <select id="departamento" name="departamento" class="form-control" data-show-subtext="true" data-live-search="true">
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
                     //mysqli_close($conexion);
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
                    <?php
                     $query_barrio = mysqli_query($conexion, "SELECT id, barrio FROM barrio ORDER BY barrio ASC");
                     $resultado_barrio = mysqli_num_rows($query_barrio);
                     //mysqli_close($conexion);
                     ?>
                    <select id="barrio" name="barrio" class="form-control">
                      <?php
                       if ($resultado_barrio > 0) {
                         while ($barrio = mysqli_fetch_array($query_barrio)) {
                           // code...
                       ?>
                          <option value="<?php echo $barrio['barrio']; ?>"><?php echo $barrio['barrio']; ?></option>
                      <?php
                         }
                       }
                       ?>
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
                <div class="form-group col1-md-8" style="
    margin-bottom: 50px;
">
                <input type="submit" value="Guardar Cliente" class="btn btn-primary" style="margin-left: 150px;">
                <a href="lista_cliente.php" class="btn btn-danger">Regresar</a>
                </div>
            </form>
        </div>
    </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>
