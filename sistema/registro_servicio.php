<?php include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['dni']) ||
    empty($_POST['nombre']) ||
    empty($_POST['apellido']) ||
    empty($_POST['direccion']) ||
    empty($_POST['telefono']) ||
    empty($_POST['especialidad']) ||
    empty($_POST['fecha']) ||
    empty($_POST['hora']) ||
    empty($_POST['personal']) ||
    empty($_POST['servicio']) ||
    empty($_POST['importe'])) {
        $alert = '<div class="alert alert-danger" role="alert">
                                    Todo los campos son obligatorio
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                                
    } else {
        $pedido = $_POST['pedido'];
        $dni = $_POST['dni'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        $especialidad = $_POST['especialidad'];
        $fecha = $_POST['fecha'];
        $hora = $_POST['hora'];
        $personal = $_POST['personal'];
        $servicio = $_POST['servicio'];
        $importe = $_POST['importe'];
        $usuario_id = $_SESSION['idUser'];

        $result = 0;
        if (is_numeric($dni) and $pedido != 0) {
            $query = mysqli_query($conexion, "SELECT * FROM servicio where pedido = '$pedido'");
            $result = mysqli_fetch_array($query);
        }
        if ($result > 0) {
            $alert = '<div class="alert alert-danger" role="alert">
                                    Pedido ya facturado!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
        } else {
            $query_insert = mysqli_query($conexion, "INSERT INTO servicio (pedido,dni,nombre,apellido,direccion,telefono,especialidad,fecha,hora,
              personal, importe, servicio, usuario_id)
              values ('$pedido','$dni', '$nombre', '$apellido','$direccion','$telefono','$especialidad','$fecha','$hora',
                '$personal','$importe', '$servicio', '$usuario_id')");
            if ($query_insert) {
                $alert = '<div class="alert alert-success" role="alert">
                                    Servicio registrado satisfactoriamente!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">
                                    Error al realizar el registro!
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
<form action="" autocomplete="off" method="post" class="card-body p-2" style="margin-bottom: 20px;">
  <?php echo isset($alert) ? $alert : ''; ?>
<div class="card" style="left: 20px;right: -30;right: 20px;margin-right: 42px;margin-bottom: 20px">
  <div class="card-body">
    <div align="center"><h3>Servicio de Fisioterapia</h3></div>
  </div>
</div>
<div class="card"style="left: 20px;right: -30;right: 20px;margin-right: 42px;margin-bottom: 20px">
<div class="card-header text-white" style="background-color: rgb(43, 167, 228);">
    <b>Detalles de Servicio</b>
  </div>
<div class="row">
  <div class="col-sm-8">
    <div class="card">
      <div class="card-body">
    <div class="row">
        <div class="col-lg-2">
            <div class="form-group">
                <label>N° de Pedido</label>
                <input type="number" name="pedido" id="pedido" placeholder="Ingrese N° Pedido"class="form-control">
<!-- INICIO DE Modal -->
</div></div>
<div class="row">
    <div class="col-lg-2">
        <div class="form-group">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter"style="margin-top:30px">
                  Ver
                </button>
                </div>
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Pedidos de Servicio</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- CONTENIDO DEL MODAL -->
                        <div class="card">
                          <div class="card-body">
                            <div class="col-lg-12" >
                              <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="table">
                                  <thead>
                                    <tr>
                                      <th>N° Pedido</th>
                                      <th>Nombre</th>
                                      <th>Apellido</th>
                                      <th>Telefono</th>
                                      <th>Fecha</th>
                                      <th>Horario</th>
                                      <?php if ($_SESSION['rol'] == 1) { ?>
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
                                          </form>
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

                        <!-- FIN DEL CONTENIDO DEL MODAL -->
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
<!-- Modal -->
            </div>
        </div></div>
        <div class="row">
          <div class="col-lg-3">
              <div class="form-group">
                  <label>Ruc</label>
                  <input type="number" name="dni" id="dni" class="form-control">
              </div>
          </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control">
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label>Apellido</label>
                <input type="text" name="apellido" id="apellido" class="form-control">
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
              <label for="direccion">Direccion</label>
              <input type="text" name="direccion" id="direccion" class="form-control">
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label>Teléfono</label>
                <input type="number" name="telefono" id="telefono" class="form-control">
            </div>
        </div>
        <div class="col-lg-4">
          <div class="form-group">
            <label for="especialidad">Tipo Consulta</label>
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
        <div class="col-lg-3">
            <div class="form-group">
              <label for="fecha">Fecha</label>
              <input type="date" name="fecha" id="fecha" class="form-control">
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
              <label for="hora">Horario</label>
              <input type="time" name="hora" id="hora" class="form-control">
            </div>
        </div>
        <div class="col-lg-4">
          <div class="form-group">
            <label for="medico">Medico</label>
            <?php
             $query_personal = mysqli_query($conexion, "SELECT nombre, apellido FROM personal ORDER BY nombre ASC");
             $resultado_personal = mysqli_num_rows($query_personal);
             mysqli_close($conexion);
             ?>
              <select id="personal" name="personal" class="form-control" data-show-subtext="true" data-live-search="true">
              <?php
               if ($resultado_personal > 0) {
                 while ($nombre = mysqli_fetch_array($query_personal)) {
                   // code...
               ?>
                  <option value="<?php echo $nombre['nombre']; ?>"><?php echo $nombre['nombre']; ?></option>
              <?php
                 }
               }
               ?>
            </select>
        </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
              <label for="servicio">Servicio</label>
              <select name="servicio" class="form-control">
                <option value="Consulta">Consulta</option>
                <option value="Control" selected>Control</option>
                <option value="Tratamiento">Tratamiento</option>
              </select>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
              <label for="importe">Costo Servicio</label>
              <input type="text" name="importe" id="importe" class="form-control">
            </div>
        </div>
        <div class="form-group col-md-8">
        <input type="submit" value="Generar Registro" class="btn btn-primary" style="margin-top:30px">
        </div>
      </form>
    </div>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card"style="top: 80px;margin-right: 20px;">
      <div class="card-body">
      <img src="img/fisioterapia.jpg" style="margin-left: 20px;width: 300px;">
      </div>
    </div>
  </div>
</div>
</div>
<div class="card"style="left: 20px;right: -30;right: 20px;margin-right: 42px;margin-bottom: 20px">
  <div class="card-header text-white" style="background-color: rgb(43, 167, 228);">
    Servicios facturados
  </div>
      <div class="card">
        <div class="card-body">
          <div class="card">
            <div class="card-body">
              <div class="col-lg-12">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered" id="table">
                    <tr class="table-info">
                      <tr>
                      <th>N° Pedido</th>
                      <th>Nombre</th>
                      <th>Apellido</th>
                      <th>Especialidad</th>
                      <th>Fecha</th>
                      <th>Hora</th>
                      <th>Medico</th>
                      <th>Servicio</th>
                      <?php if ($_SESSION['rol'] == 1) { ?>
                      <th>Acciones</th>
                      <?php } ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    include "../conexion.php";

                    $query = mysqli_query($conexion, "SELECT * FROM servicio");
                    $result = mysqli_num_rows($query);
                    if ($result > 0) {
                      while ($data = mysqli_fetch_assoc($query)) { ?>
                        <tr>
                          <td><?php echo $data['pedido']; ?></td>
                          <td><?php echo $data['nombre']; ?></td>
                          <td><?php echo $data['apellido']; ?></td>
                          <td><?php echo $data['especialidad']; ?></td>
                          <td><?php echo $data['fecha']; ?></td>
                          <td><?php echo $data['hora']; ?></td>
                          <td><?php echo $data['personal']; ?></td>
                          <td><?php echo $data['servicio']; ?></td>
                          <?php if ($_SESSION['rol'] == 1) { ?>
                          <td>
                            <a href="editar_pedido_serv.php?id=<?php echo $data['id']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>
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
<script>
$('#myModal').on('shown.bs.modal', function () {
  $('#myInput').trigger('focus')
})
</script>


<?php include_once "includes/footer.php"; ?>
