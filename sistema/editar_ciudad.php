<?php
include "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['ciudad'])) {
    $alert = '<p class"msg_error">Todo los campos son requeridos</p>';
  } else {
    $idciudad = $_GET['id'];
    $ciudad = $_POST['ciudad'];
    $estado = $_POST['estado'];
    $sql_update = mysqli_query($conexion, "UPDATE ciudad SET ciudad = '$ciudad', estado = '$estado' WHERE id = $idciudad");

    if ($sql_update) {
      $alert = '<div class="alert alert-success" role="alert">
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
  header("Location: lista_ciudad.php");
  mysqli_close($conexion);
}
$idciudad = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM ciudad WHERE id = $idciudad");
mysqli_close($conexion);
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
  header("Location: lista_ciudad.php");
} else {
  while ($data = mysqli_fetch_array($sql)) {
    $idciudad = $data['id'];
    $ciudad = $data['ciudad'];
    $estado = $data['estado'];
  }
}
?>
<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="row" style="margin-bottom: 400px;">
      <div class="col-lg-6 m-auto">
          <div class="card-header bg-primary text-white">
              Editar ciudad
          </div>
          <div class="card">
  <div class="row"style="margin-bottom: 50px;">
    <div class="col-lg-6 m-auto">
      <?php echo isset($alert) ? $alert : ''; ?>
      <form class="" action="" method="post">
        <input type="hidden" name="id" value="<?php echo $idciudad; ?>">
        <div class="form-group">
          <label for="ciudad">Ciudad</label>
          <input type="text" placeholder="Ingrese ciudad" name="ciudad" class="form-control" id="ciudad" value="<?php echo $ciudad; ?>">
        </div>
          <div class="row">
            <label for="cars" style="padding-left: 15px;">Estado</label>
            <select name="estado" id="estado" style="margin-left: 15px;">
              <option value="Activo">Activo</option>
              <option value="Inactivo">Inactivo</option>
            </select>
          </div><br>
        <input type="submit" value="Actualizar" class="btn btn-primary">
        <a href="lista_ciudad.php" class="btn btn-danger">Regresar</a>
      </form>
    </div>
  </div>
  </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>
