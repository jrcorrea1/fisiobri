<?php include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['nombre']) ||
    empty($_POST['apellido']) ||
    empty($_POST['telefono']) ||
    empty($_POST['especialidad']) ||
    empty($_POST['fecha']) ||
    empty($_POST['hora'])) {
        $alert = '<div class="alert alert-danger" role="alert">
                                    Todo los campos son obligatorio
                                </div>';
    } else {
        $dni = $_POST['dni'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $telefono = $_POST['telefono'];
        $especialidad = $_POST['especialidad'];
        $fecha = $_POST['fecha'];
        $hora = $_POST['hora'];
        $usuario_id = $_SESSION['idUser'];

        $result = 0;
        if (is_numeric($dni) and $fecha and $hora != 0) {
            $query = mysqli_query($conexion, "SELECT * FROM pedido_servicio where fecha = '$fecha' and hora = '$hora'");
            $result = mysqli_fetch_array($query);
        }
        if ($result > 0) {
            $alert = '<div class="alert alert-danger" role="alert">
                                    No disponible, por favor seleccione otro dia!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
        } else {
            $query_insert = mysqli_query($conexion, "INSERT INTO pedido_servicio (dni,nombre,apellido,telefono,especialidad,fecha,hora,usuario_id)
              values ('$dni', '$nombre', '$apellido','$telefono','$especialidad','$fecha','$hora','$usuario_id')");
            if ($query_insert) {
                $alert = '<div class="alert alert-success" role="alert">
                                    Pedido Realizado satisfactoriamente!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">
                                    Error al realizar el pedido!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>';
            }
        }
    }
//   mysqli_close($conexion);
}
?>
<form id="form" action="" autocomplete="off" method="post" class="card-body p-2" style="margin-bottom: 20px;">
  <?php echo isset($alert) ? $alert : ''; ?>
<div class="card" style="left: 20px;right: -30;right: 20px;margin-right: 42px;margin-bottom: 20px">
  <div class="card-body">
    <div align="center"><h4>Pedido de Servicio</h4></div>
  </div>
</div>
<div class="card"style="left: 20px;right: -30;right: 20px;margin-right: 42px;margin-bottom: 20px">
  <div class="card-header text-white" style="background-color: rgb(43, 167, 228);">
    Nuevo
  </div>
<div class="row">
  <div class="col-sm-8">
    <div class="card">
      <div class="card-body">
        <input type="hidden" id="idcliente" value="1" name="idcliente" required>
    <div class="row">
        <div class="col-lg-4">
            <div class="form-group">
                <label>N° de Cedula</label>
                <input type="number" name="dni" id="dni" class="form-control">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Apellido</label>
                <input type="text" name="apellido" id="apellido" class="form-control">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Teléfono</label>
                <input type="number" name="telefono" id="telefono" class="form-control">
            </div>
        </div>

        <div class="col-lg-4">
          <div class="form-group">
            <label for="especialidad">Especialidad</label>
            <?php
             $query_especialidad = mysqli_query($conexion, "SELECT id, especialidad FROM especialidad ORDER BY especialidad ASC");
             $resultado_especialidad = mysqli_num_rows($query_especialidad);
             //mysqli_close($conexion);
             ?>
              <select id="especialidad" name="especialidad" class="form-control" data-show-subtext="true" data-live-search="true">
              <?php
               if ($resultado_especialidad > 0) {
                 while ($especialidad = mysqli_fetch_array($query_especialidad)) {
                   // code...
               ?>
                  <option value="<?php echo $especialidad['especialidad']; ?>"><?php echo $especialidad['especialidad']; ?></option>
              <?php
                 }
               }
               ?>
            </select>
        </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
              <label for="fecha">Fecha</label>
              <input type="date" name="fecha" id="fecha" class="form-control">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
              <label for="hora">Horario</label>
              <input type="time" name="hora" id="hora" class="form-control">
            </div>
        </div>
        <div class="form-group col1-md-8">
        <input type="submit" value="Guardar" class="btn btn-primary" style="margin-left: 12px;margin-top: 30px;">
        <input type="button" onclick="validar();" value="Cancelar" class="btn btn-danger" style="margin-left: 20px;margin-top: 30px;margin-right: 20px;">
        </div>
      </form>
        <div class="card">
          <div class="card-body">
            <div class="col-lg-12">
              <div class="table-responsive">
                <table class="table table-striped table-bordered" id="table">
                  <thead class="thead" style="background-color: rgb(43, 167, 228);" white-t>
                    <tr>
                    <th>N° Pedido</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Telefono</th>
                    <th>Fecha</th>
                    <th>Horario</th>
                    <?php if ($_SESSION['rol'] == 1) { ?>
                    <th>Acciones</th>
                    <?php } ?>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  include "../conexion.php";

                  $query = mysqli_query($conexion, "SELECT * FROM pedido_servicio");
                  $result = mysqli_num_rows($query);
                  if ($result > 0) {
                    while ($data = mysqli_fetch_assoc($query)) { ?>
                      <tr>
                        <td><?php echo $data['pedido']; ?></td>
                        <td><?php echo $data['nombre']; ?></td>
                        <td><?php echo $data['apellido']; ?></td>
                        <td><?php echo $data['telefono']; ?></td>
                        <td><?php echo $data['fecha']; ?></td>
                        <td><?php echo $data['hora']; ?></td>
                        <?php if ($_SESSION['rol'] == 1) { ?>
                        <td>
                          <button class="btn btn-success" type="submit"><i class="fas fa-file-alt"></i></button>
                          <form action="eliminar_pedido_serv.php?id=<?php echo $data['id']; ?>" method="post" class="confirmar d-inline">
                            <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
                          </form>
                        </td>
                        <?php } ?>
                      </tr>
                  <?php }
                  } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card">
      <div class="card-body">
      <img src="img/fisio2.png" style="margin-left: 20px;width: 300px;">
      </div>
    </div>
  </div>
</div>
</div>

<?php include_once "includes/footer.php"; ?>
