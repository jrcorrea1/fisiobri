  <?php
include "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['departamento'])) {
    $alert = '<p class"msg_error">Todo los campos son requeridos</p>';
  } else {
    $iddepartamento = $_GET['id'];
    $departamento = $_POST['departamento'];
    $estado = $_POST['estado'];
    $sql_update = mysqli_query($conexion, "UPDATE departamentos SET departamento = '$departamento', estado = '$estado' WHERE id = $iddepartamento");

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
  header("Location: lista_departamento.php");
  mysqli_close($conexion);
}
$iddepartamento = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM departamentos WHERE id = $iddepartamento");
mysqli_close($conexion);
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
  header("Location: lista_departamento.php");
} else {
  while ($data = mysqli_fetch_array($sql)) {
    $iddepartamento = $data['id'];
    $departamento = $data['departamento'];
    $estado = $data['estado'];
  }
}
?>
<!-- Begin Page Content -->
<div class="card"style="left: 20px;right: -30;right: 20px;margin-right: 42px;margin-bottom: 20px">
  <div class="card-header text-white" style="background-color: rgb(43, 167, 228);">
    Mantenimiento de Departamento / Editar
  </div>
      <div class="card">
        <div class="card-body">
	<!-- Page Heading -->
	<div class="col-sm-2">
    <div class="card" style="width: 18rem;left: 10px;">
    <img src="img/map.png" class="card-img-top" alt="..." style="width: 150px;margin-left: 50px;margin-top: 20px;">
          <div class="card-body">
        <h5 class="card-title"><strong>Departamento</strong></h5>
      </div>
    </div>
  </div>
    <!-- Content Row -->
    <div class="card"style="margin-left: 250px;margin-right: 250px;left: 110px;padding-top: 10px;padding-bottom: 10px;bottom: 190px;">
      <div class="card"style="left: 20px;right: -30;right: 20px;margin-right: 42px;margin-bottom: 20px">
        <div class="card-header text-white" style="background-color: rgb(43, 167, 228);">
          Editar
        </div>
          <div class="card">
  <div class="row"style="margin-bottom: 50px;">
    <div class="col-lg-6 m-auto">
      <?php echo isset($alert) ? $alert : ''; ?>
      <form class="" action="" method="post">
        <input type="hidden" name="id" value="<?php echo $iddepartamento; ?>">
        <div class="form-group">
          <label for="departamento">Departamento</label>
          <input type="text" placeholder="Ingrese departamento" name="departamento" class="form-control" id="departamento" value="<?php echo $departamento; ?>">
        </div>
          <div class="row">
            <label for="cars" style="padding-left: 15px;">Estado</label>
            <select name="estado" id="estado" style="margin-left: 15px;"class="form-control">
              <option value="Activo">Activo</option>
              <option value="Inactivo">Inactivo</option>
            </select>
          </div><br>
        <input type="submit" value="Actualizar" class="btn btn-primary">
        <a href="lista_departamento.php" class="btn btn-danger">Regresar</a>
      </form>
    </div>
  </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>
