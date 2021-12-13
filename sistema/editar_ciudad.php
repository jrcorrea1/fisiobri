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
    $departamento = $_POST['departamento'];
    $estado = $_POST['estado'];
    $sql_update = mysqli_query($conexion, "UPDATE ciudad SET ciudad = '$ciudad',departamento = '$departamento', estado = '$estado' WHERE id = $idciudad");

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
  //mysqli_close($conexion);
}
$idciudad = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM ciudad WHERE id = $idciudad");
//mysqli_close($conexion);
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
  header("Location: lista_ciudad.php");
} else {
  while ($data = mysqli_fetch_array($sql)) {
    $idciudad = $data['id'];
    $ciudad = $data['ciudad'];
    $departamento = $data['departamento'];
    $estado = $data['estado'];
  }
}
?>
<div class="card"style="left: 20px;right: -30;right: 20px;margin-right: 42px;margin-bottom: 20px">
  <div class="card-header text-white" style="background-color: rgb(43, 167, 228);">
    Mantenimiento de Ciudad / Editar
  </div>
      <div class="card">
        <div class="card-body">
	<div class="col-sm-2">
    <div class="card" style="width: 18rem;left: 10px;">
    <img src="img/map.png" class="card-img-top" alt="..." style="width: 150px;margin-left: 50px;margin-top: 20px;">
          <div class="card-body">
        <h5 class="card-title"><strong>Ciudad</strong></h5>
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
        <input type="hidden" name="id" value="<?php echo $idciudad; ?>">
        <div class="form-group">
          <label for="ciudad">Ciudad</label>
          <input type="text" placeholder="Ingrese ciudad" name="ciudad" class="form-control" id="ciudad" value="<?php echo $ciudad; ?>">
        </div>
        <div class="form-group">
          <label for="departamento">Departamento</label>
          <?php
           $query_departamento = mysqli_query($conexion, "SELECT id, departamento FROM departamentos ORDER BY departamento ASC");
           $resultado_departamento = mysqli_num_rows($query_departamento);
           //mysqli_close($conexion);
           ?>
           <select class="form-control seleccion" id="departamento" name="departamento">
         <option value="">--- Seleccionar departamento ---</option>
         <?php foreach ($query_departamento as $dep) {
           $selected = ($dep['departamento'] == $departamento) ? "selected" : null;
           echo '<option value="' . $dep['departamento'] . '" ' . $selected . '>' . $dep['departamento'] . '</option>';
         } ?>
       </select>
        </div>
          <div class="row">
            <label for="estado" style="padding-left: 15px;">Estado</label>
            <select name="estado" id="estado" class="form-control">
              <option value="">--- Seleccionar estado ---</option>
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

</script>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>
