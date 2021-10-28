<?php
include "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['cargo'])) {
    $alert = '<div class="alert alert-danger" role="alert">
              Todos los campos son requeridos
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
            </div>';
  } else {
    $idcargo = $_GET['id'];
    $cargo = $_POST['cargo'];
    $estado = $_POST['estado'];
    $sql_update = mysqli_query($conexion, "UPDATE cargo SET cargo = '$cargo',estado = '$estado' WHERE id = $idcargo");

    if ($sql_update) {
      $alert = '<div class="alert alert-primary" role="alert">
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
  header("Location: lista_cargo.php");
  mysqli_close($conexion);
}
$idcargo = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM cargo WHERE id = $idcargo");
mysqli_close($conexion);
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
  header("Location: lista_cargo.php");
} else {
  while ($data = mysqli_fetch_array($sql)) {
    $idcargo = $data['id'];
    $cargo = $data['cargo'];
    $estado = $data['estado'];
  }
}
?>
<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="row" style="margin-bottom: 400px;">
      <div class="col-lg-6 m-auto">
          <div class="card-header bg-primary text-white">
              Editar cargo
          </div>
          <div class="card">
  <div class="row"style="margin-bottom: 50px;">
    <div class="col-lg-6 m-auto">
      <?php echo isset($alert) ? $alert : ''; ?>
      <form class="" action="" method="post">
        <input type="hidden" name="id" value="<?php echo $idcargo; ?>">
        <div class="form-group">
          <label for="cargo">cargo</label>
          <input type="text" placeholder="Ingrese cargo" name="cargo" class="form-control" id="cargo" value="<?php echo $cargo; ?>">
        </div>
        <div class="row">
          <label for="cars" style="padding-left: 15px;">Estado</label>
          <select name="estado" id="estado" style="margin-left: 15px;">
            <option value="Activo">Activo</option>
            <option value="Inactivo">Inactivo</option>
          </select>
        </div><br>
        <input type="submit" value="Actualizar" class="btn btn-primary">
        <a href="lista_cargo.php" class="btn btn-danger">Regresar</a>
      </form>
    </div>
  </div>
  </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>
