<?php include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['fecha_pedido']) ||
    empty($_POST['cliente']) ||
    empty($_POST['dni']) ||
    empty($_POST['nombre']) ||
    empty($_POST['apellido']) ||
    empty($_POST['ciudad'])) {
        $alert = '<div class="alert alert-danger" role="alert">
                                    Todo los campos son obligatorio
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
    } else {
        $factura = $_POST['factura'];
        $fecha_pedido = $_POST['fecha_pedido'];
        $cliente = $_POST['cliente'];
        $dni = $_POST['dni'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $ciudad = $_POST['ciudad'];
        $usuario_id = $_SESSION['idUser'];
        $result = 0;
        if (is_numeric($dni) and $factura != 0) {
            $query = mysqli_query($conexion, "SELECT * FROM pedido_delivery where factura = '$factura'");
            $result = mysqli_fetch_array($query);
        }
        if ($result > 0) {
            $alert = '<div class="alert alert-danger" role="alert">
                                    Factura ya tiene solicitud de Delivery!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
        } else {
            $query_insert = mysqli_query($conexion, "INSERT INTO pedido_delivery (factura,fecha,cliente,dni,nombre,apellido,ciudad,usuario_id)
values ('$factura','$fecha','$cliente','$dni','$nombre','$apellido','$ciudad','$usuario_id')");
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
    <div align="center"><h4>Registro de Delivery</h4></div>
  </div>
</div>
<div class="card"style="left: 20px;right: -30;right: 20px;margin-right: 42px;margin-bottom: 20px;padding-bottom: 35px;">
  <div class="card-header text-white" style="background-color: rgb(43, 167, 228);">
    Nuevo
  </div>
  <div class="row">
  <div class="col-sm-4">
    <div class="card" style="left: 30px;top: 15px;">
      <div class="card-body">
      <img src="img/deliverys.png" style="margin-left: 50px;width: 250px;height: 256px;">
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card" style="width: 722px;top: 15px;margin-left: 12px;left: 40px;">
      <div class="card-body">
    <div class="row">
        <div class="col-lg-2">
            <div class="form-group">
                <label>N° pedido</label>
                <input type="number" name="nopedido" id="nopedido" class="form-control">
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
                                        <h5 class="modal-title" id="exampleModalLongTitle">Pedidos de Delivery</h5>
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
                                                    <th>Destino</th>
                                                    <th>Fecha Pedido</th>
                                                    <?php if ($_SESSION['rol'] == 1) { ?>
                                                    <?php } ?>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <?php
                                                  include "../conexion.php";
                                                  $query = mysqli_query($conexion, "SELECT * FROM pedido_delivery");
                                                  $result = mysqli_num_rows($query);
                                                  if ($result > 0) {
                                                    while ($data = mysqli_fetch_assoc($query)) { ?>
                                                      <tr>
                                                        <td><?php echo $data['id']; ?></td>
                                                        <td><?php echo $data['nombre']; ?></td>
                                                        <td><?php echo $data['apellido']; ?></td>
                                                        <td><?php echo $data['ciudad']; ?></td>
                                                        <td><?php echo $data['fecha_pedido']; ?></td>
                                                        <?php if ($_SESSION['rol'] == 1) { ?>
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
                        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label>Fecha</label>
                <input type="datetime" name="fecha" id="fecha" class="form-control" value="<?php echo date("d-m-Y");?>">
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label>Id Cliente</label>
                <input type="number" name="cliente" id="cliente" class="form-control">
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label>Cedula N°</label>
                <input type="number" name="dni" id="dni" class="form-control">
            </div>
        </div></div>
        <div class="row">
        <div class="col-lg-4">
            <div class="form-group">
              <div class="row">
              <div class="col-lg-2">
                    <label><b>Informacion</b></label>
                  </div>
                    </div></div>
                <label>Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control">
            </div>
        <div class="col-lg-4"style="top: 48px;">
            <div class="form-group">
                <label>Apellido</label>
                <input type="text" name="apellido" id="apellido" class="form-control">
            </div></div>
        </div><br>
        <div class="row">
        <div class="col-lg-4">
          <div class="form-group">
            <label for="ciudad">Ciudad</label>
            <?php
             $query_ciudad = mysqli_query($conexion, "SELECT id, ciudad FROM ciudad ORDER BY ciudad ASC");
             $resultado_ciudad = mysqli_num_rows($query_ciudad);
             //mysqli_close($conexion);
             ?>
              <select id="ciudad" name="ciudad" class="form-control" data-show-subtext="true" data-live-search="true">
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
          <div class="col-lg-6">
              <div class="form-group">
                  <label>Direccion de Entrega</label>
                  <input type="text" name="apellido" id="apellido" class="form-control">
              </div>
          </div></div>
          <div class="row">
          <div class="col-lg-3">
              <div class="form-group"style="margin-bottom: 0px;">
                <label><b>Chofer Asignado</b></label><br></div></div>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>ID</label>
                            <input type="number" name="chofer" id="chofer" class="form-control">
                            <!-- INICIO DE Modal -->
                            </div></div>
                            <!-- Button trigger modal -->
                            <div class="form-group">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"style="margin-top:30px">
                              Ver
                            </button></div>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Personal de Logistica - Chofer</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <div class="card" style="bottom: 30px;">
                                  		<div class="card-body">
                                  			<div class="col-lg-12">
                                  				<div class="table-responsive">
                                  					<table class="table table-striped table-bordered" id="table">
                                  						<thead class="thead-dark">
                                  							<tr>
                                  							<th>ID</th>
                                  							<th>NOMBRE</th>
                                  							<th>APELLIDO</th>
                                  							<?php if ($_SESSION['rol'] == 1) { ?>
                                  							<?php } ?>
                                  						</tr>
                                  					</thead>
                                  					<tbody>
                                  						<?php
                                  						include "../conexion.php";

                                  						$query = mysqli_query($conexion, "SELECT * FROM personal WHERE cargo='Chofer'");
                                  						$result = mysqli_num_rows($query);
                                  						if ($result > 0) {
                                  							while ($data = mysqli_fetch_assoc($query)) { ?>
                                  								<tr>
                                  									<td><?php echo $data['idpersonal']; ?></td>
                                  									<td><?php echo $data['nombre']; ?></td>
                                  									<td><?php echo $data['apellido']; ?></td>
                                  									<?php if ($_SESSION['rol'] == 1) { ?>

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
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  </div>
                                </div>
                              </div>
                            </div>

                        <div class="col-lg-3">
              <div class="form-group">
                  <label>Nombre</label>
                  <input type="text" name="nombre2" id="nombre2" class="form-control">
              </div></div>
                <div class="col-lg-3">
              <div class="form-group">
                  <label>Apellido</label>
                  <input type="text" name="apellido2" id="apellido2" class="form-control">
              </div></div>

        <div class="form-group col1-md-8">
        <input type="submit" value="Solicitar" class="btn btn-primary" style="margin-left: 12px;margin-top: 30px;">
        <input type="button" onclick="validar();" value="Limpiar" class="btn btn-danger" style="margin-left: 30px;margin-top: 30px;">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
  <div class="card"style="width: 1200px;top: 35px;margin-left: 12px;left: 30px;">
    <div class="card-body">
      <div class="col-lg-12" >
        <div class="table-responsive">
          <table class="table table-striped table-bordered" id="table">
            <thead class="thead-dark">
              <tr>
              <th>ID</th>
              <th>N° Pedido</th>
              <th>Ciudad</th>
              <th>Direccion de entrega</th>
              <?php if ($_SESSION['rol'] == 1) { ?>
                <th>Acciones</th>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
            <?php
            include "../conexion.php";

            $query = mysqli_query($conexion, "SELECT * FROM delivery");
            $result = mysqli_num_rows($query);
            if ($result > 0) {
              while ($data = mysqli_fetch_assoc($query)) { ?>
                <tr>
                  <td><?php echo $data['id_delivery']; ?></td>
                  <td><?php echo $data['nopedido']; ?></td>
                  <td><?php echo $data['ciudad']; ?></td>
                  <td><?php echo $data['direccion']; ?></td>
                  <?php if ($_SESSION['rol'] == 1) { ?>
                    <td>
  										<a href="editar_ciudad.php?id=<?php echo $data['id']; ?>" class="btn btn-success"><i class='fas fa-edit'></i> Editar</a>
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
<?php include_once "includes/footer.php"; ?>
