<?php
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['rol'])) {
    $alert = '<p class"msg_error">Todo los campos son requeridos</p>';
  } else {
    $idrol = $_GET['idrol'];
    $rol = $_POST['rol'];
    $sql_update = mysqli_query($conexion, "UPDATE rol SET rol = '$rol' WHERE idrol = $idrol");

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

if (empty($_REQUEST['idrol'])) {
  header("Location: lista_rol.php");
  mysqli_close($conexion);
}
$idrol = $_REQUEST['rol'];
$sql = mysqli_query($conexion, "SELECT * FROM rol WHERE idrol = $idrol");
mysqli_close($conexion);
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
  header("Location: lista_rol.php");
} else {
  while ($data = mysqli_fetch_array($sql)) {
    $idrol = $data['idrol'];
    $rol = $data['rol'];
  }
}
?>
<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="row" style="margin-bottom: 400px;">
      <div class="col-lg-6 m-auto">
          <div class="card-header bg-primary text-white">
              Editar Rol
          </div>
          <div class="card">
  <div class="row"style="margin-bottom: 50px;">
    <div class="col-lg-6 m-auto">
      <?php echo isset($alert) ? $alert : ''; ?>
      <form class="" action="" method="post">
        <input type="hidden" name="idrol" value="<?php echo $idrol; ?>">
        <div class="form-group">
          <label for="rol">Rol</label>
          <input type="text" placeholder="Ingrese rol" name="rol" class="form-control" id="rol" value="<?php echo $rol; ?>">
        </div>
        <input type="submit" value="Actualizar" class="btn btn-primary">
        <a href="lista_rol.php" class="btn btn-danger">Regresar</a>
      </form>
    </div>
  </div>
  </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>
