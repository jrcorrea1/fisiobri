<?php include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['ruc']) ||
  empty($_POST['banco']) ||
  empty($_POST['ciudad']) ||
  empty($_POST['direccion']) ||
  empty($_POST['telefono']) ||
  empty($_POST['estado'])) {
    $alert = '<div class="alert alert-danger" role="alert">
                Todos los campos son requeridos
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>';
  } else {
    $idbanco = $_POST['idbanco'];
    $ruc = $_POST['ruc'];
    $banco = $_POST['banco'];
    $ciudad = $_POST['ciudad'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $estado = $_POST['estado'];
    $result = 0;
    if (is_numeric($ruc) and $ruc != 0) {
      $query = mysqli_query($conexion, "SELECT * FROM banco where (ruc = '$ruc' AND idbanco != $idbanco)");
      $result = mysqli_fetch_array($query);
      $resul = mysqli_num_rows($query);
    }

    if ($resul >= 1) {
      $alert = '<div class="alert alert-danger" role="alert">
                  El Banco ya existe
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
              </div>';
    } else {
      if ($ruc == '') {
        $ruc = 0;
      }
      $sql_update = mysqli_query($conexion, "UPDATE banco SET ruc = '$ruc', banco = '$banco' ,ciudad = '$ciudad',direccion = '$direccion',
        telefono = '$telefono' , estado = '$estado' WHERE idbanco = $idbanco");

      if ($sql_update) {
        $alert = '<div class="alert alert-success" role="alert">
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

if (empty($_REQUEST['idbanco'])) {
  //header("Location: lista_banco.php");
  //mysqli_close($conexion);
}
$idbanco = $_REQUEST['idbanco'];
$sql = mysqli_query($conexion, "SELECT * FROM banco WHERE idbanco = $idbanco");
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
  header("Location: lista_banco.php");
} else {
  while ($data = mysqli_fetch_array($sql)) {
    $idbanco = $data['idbanco'];
    $ruc = $data['ruc'];
    $banco = $data['banco'];
    $ciudad = $data['ciudad'];
    $direccion = $data['direccion'];
    $telefono = $data['telefono'];
    $estado = $data['estado'];
}
}
?>
<div class="card"style="left: 20px;right: -30;right: 20px;margin-right: 42px;margin-bottom: 20px">
  <div class="card-header text-white" style="background-color: rgb(43, 167, 228);">
    Mantenimiento de Banco / Editar
  </div>
      <div class="card"style="height: 1002px;">
        <div class="card-body">
  <!-- Page Heading -->
  <div class="col-sm-2">
    <div class="card" style="width: 18rem;left: 10px;">
    <img src="img/banco.jpg" class="card-img-top" alt="..." style="width: 150px;margin-left: 50px;margin-top: 20px;">
          <div class="card-body">
        <h5 class="card-title"><strong>Entidad Bancaria</strong></h5>
      </div>
    </div>
  </div>
    <!-- Content Row -->
    <div class="card"style="margin-left: 250px;margin-right: 250px;left: 110px;padding-top: 10px;padding-bottom: 10px;bottom: 218px;">
      <div class="card"style="left: 20px;right: -30;right: 20px;margin-right: 42px;margin-bottom: 20px">
        <div class="card-header text-white" style="background-color: rgb(43, 167, 228);">
          Editar
        </div>
          <div class="row" style="margin-bottom: 50px;">
            <div class="col-lg-6 m-auto">
              <form class="" action="" method="post">
                <?php echo isset($alert) ? $alert : ''; ?>
                <div class="card"style="width: 582px;right: 140px;">
                <input type="hidden" name="idbanco" value="<?php echo $idbanco; ?>">
              <div class="form-group col-md-5" style="margin-left: 0px;margin-right: 0px;padding-left: 35px;margin-top: 20px;">
                  <label for="ruc">Ruc</label>
                  <input type="number" placeholder="Ingrese Cedula" name="ruc" id="ruc" class="form-control" value="<?php echo $ruc; ?>">
              </div>
              <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
              <div class="form-group col-md-5">
                  <label for="banco">Razon Social</label>
                  <input type="text" placeholder="Ingrese banco" name="banco" id="banco" class="form-control" value="<?php echo $banco; ?>">
              </div>
              <div class="form-group col-md-5">
                  <label for="ciudad">Ciudad</label>
                  <input type="text" placeholder="Ingrese ciudad" name="ciudad" id="ciudad" class="form-control" value="<?php echo $ciudad; ?>">
              </div>
              </div>
                <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
                <div class="form-group col-md-5">
                  <label for="direccion">Direccion</label>
                  <input type="text" placeholder="Ingrese direccion" name="direccion" id="direccion" class="form-control" value="<?php echo $direccion; ?>">
              </div>
              <div class="form-group col-md-5">
                <label for="telefono">Telefono</label>
                <input type="number" placeholder="Ingrese telefono" name="telefono" id="telefono" class="form-control" value="<?php echo $telefono; ?>">
            </div>
              </div>
              <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
                <div class="form-group col-md-5">
                  <label for="estado">Estado</label>
                  <select name="estado"  class="form-control">
                    <option value="Activo">Activo</option>
                    <option value="Inactivo" selected>Inactivo</option>
                  </select>
              </div>  </div>
              <div class="form-group col1-md-8" style="margin-bottom: 50px;">
                <input type="submit" value="Actualizar" class="btn btn-primary" style="margin-left: 220px;">
                <a href="lista_banco.php" class="btn btn-danger">Regresar</a>
              </form>
            </div>
          </div>
        </div>
        </div>
      </div>
      <?php include_once "includes/footer.php"; ?>
