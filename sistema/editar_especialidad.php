<?php
include "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['especialidad'])) {
    $alert = '<div class="alert alert-danger" role="alert">
              Todos los campos son requeridos
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
            </div>';
  } else {
    $idespecialidad = $_GET['id'];
    $especialidad = $_POST['especialidad'];
    $estado = $_POST['estado'];
    $sql_update = mysqli_query($conexion, "UPDATE especialidad SET especialidad = '$especialidad',estado = '$estado' WHERE id = $idespecialidad");

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
  header("Location: lista_especialidad.php");
  mysqli_close($conexion);
}
$idespecialidad = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM especialidad WHERE id = $idespecialidad");
mysqli_close($conexion);
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
  header("Location: lista_especialidad.php");
} else {
  while ($data = mysqli_fetch_array($sql)) {
    $idespecialidad = $data['id'];
    $especialidad = $data['especialidad'];
    $estado = $data['estado'];
  }
}
?>
<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="row" style="margin-bottom: 400px;">
      <div class="col-lg-6 m-auto">
          <div class="card-header bg-primary text-white">
              Editar especialidad
          </div>
          <div class="card">
  <div class="row"style="margin-bottom: 50px;">
    <div class="col-lg-6 m-auto">
      <?php echo isset($alert) ? $alert : ''; ?>
      <form class="" action="" method="post">
        <input type="hidden" name="id" value="<?php echo $idespecialidad; ?>">
        <div class="form-group">
          <label for="especialidad">Especialidad</label>
          <input type="text" placeholder="Ingrese especialidad" name="especialidad" class="form-control" id="especialidad" value="<?php echo $especialidad; ?>">
        </div>
        <div class="row">
          <label for="cars" style="padding-left: 15px;">Estado</label>
          <select name="estado" id="estado" style="margin-left: 15px;">
            <option value="Activo">Activo</option>
            <option value="Inactivo">Inactivo</option>
          </select>
        </div><br>
        <input type="submit" value="Actualizar" class="btn btn-primary">
        <a href="lista_especialidad.php" class="btn btn-danger">Regresar</a>
      </form>
    </div>
  </div>
  </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>
