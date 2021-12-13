<?php include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['fecha']) ||
    empty($_POST['cliente']) ||
    empty($_POST['dni']) ||
    empty($_POST['nombre']) ||
    empty($_POST['apellido']) ||
    empty($_POST['ciudad']) ||
    empty($_POST['fecha_pedido'])) {
        $alert = '<div class="alert alert-danger" role="alert">
                                    Todo los campos son obligatorio
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
    } else {
        $factura = $_POST['factura'];
        $fecha = $_POST['fecha'];
        $cliente = $_POST['cliente'];
        $dni = $_POST['dni'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $ciudad = $_POST['ciudad'];
        $fecha_pedido = $_POST['fecha_pedido'];
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
            $query_insert = mysqli_query($conexion, "INSERT INTO pedido_delivery (factura,fecha,cliente,dni,nombre,apellido,ciudad,fecha_pedido,usuario_id)
values ('$factura','$fecha','$cliente','$dni','$nombre','$apellido','$ciudad','$fecha_pedido','$usuario_id')");
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
    <div align="center"><h4>Pedido de Delivery</h4></div>
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
      <img src="img/courrier.jpg" style="margin-left: 50px;width: 300px;height: 256px;">
      </div>
    </div>
  </div>

  <div class="col-sm-6">
    <div class="card" style="width: 722px;top: 15px;margin-left: 12px;left: 40px;">
      <div class="card-body">
        <input type="hidden" id="idcliente" value="1" name="idcliente" required>
        <input type="hidden" id="pedido_delivery" value="1" name="pedido_delivery" required>
    <div class="row">
        <div class="col-lg-2">
            <div class="form-group">
                <label>Comprob.</label>
                <input type="number" name="factura" id="factura" class="form-control">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Fecha Comprob.</label>
                <input type="text" name="fecha" id="fecha" class="form-control">
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
                <label>Cedula</label>
                <input type="text" name="dni" id="dni" class="form-control">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Cliente</label>
                <input type="text" name="nombre" id="nombre" class="form-control">
            </div>
        </div>

        <div class="col-lg-4"style="margin-top: 16px;right: 20px;">
            <div class="form-group">
                <label></label>
                <input type="text" name="apellido" id="apellido" class="form-control"style="margin-top: 8px;">
            </div>
        </div>
        <div class="col-lg-4">
          <div class="form-group">
            <label for="ciudad">Ciudad</label>
            <?php
             $query_ciudad = mysqli_query($conexion, "SELECT id, ciudad FROM ciudad ORDER BY ciudad ASC");
             $resultado_ciudad = mysqli_num_rows($query_ciudad);
             //mysqli_close($conexion);
             ?>
             <select class="form-control seleccion" id="ciudad" name="ciudad">
           <option value="">--- Seleccionar ciudad ---</option>
           <?php foreach ($query_ciudad as $ciu) {
             $selected = ($ciu['ciudad'] == $ciudad) ? "selected" : null;
             echo '<option value="' . $ciu['ciudad'] . '" ' . $selected . '>' . $ciu['ciudad'] . '</option>';
           } ?>
         </select>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <label for="actual">Fecha Actual</label>
              <input type="datetime" name="fecha_pedido" id="fecha_pedido" class="form-control" value="<?php echo date("d-m-Y");?>">
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
  <div class="card"style="width: 1220px;top: 35px;margin-left: 12px;left: 30px;">
    <div class="card-body">
      <div class="col-lg-12" >
        <div class="table-responsive">
          <table class="table table-striped table-bordered" id="table">
            <thead>
              <tr>
              <th>N° Pedido</th>
              <th>Comprante</th>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Destino</th>
              <th>Fecha Pedido</th>
              <?php if ($_SESSION['rol'] == 1) { ?>
              <th>Acciones</th>
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
                  <td><?php echo $data['factura']; ?></td>
                  <td><?php echo $data['nombre']; ?></td>
                  <td><?php echo $data['apellido']; ?></td>
                  <td><?php echo $data['ciudad']; ?></td>
                  <td><?php echo $data['fecha_pedido']; ?></td>
                  <?php if ($_SESSION['rol'] == 1) { ?>
                  <td>
                    <button class="btn btn-success" type="submit"><i class="fas fa-file-alt"></i></button>
                    <form action="eliminar-pedido_delivery.php?id=<?php echo $data['id']; ?>" method="post" class="confirmar d-inline">
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
<?php include_once "includes/footer.php"; ?>
