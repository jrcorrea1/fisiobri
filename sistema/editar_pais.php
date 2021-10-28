<?php
include "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['pais'])) {
    $alert = '<p class"msg_error">Todo los campos son requeridos</p>';
  } else {
    $idpais = $_GET['id'];
    $pais = $_POST['pais'];
    $estado = $_POST['estado'];
    $sql_update = mysqli_query($conexion, "UPDATE paises SET pais = '$pais', estado = '$estado' WHERE id = $idpais");

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
  header("Location: lista_pais.php");
  mysqli_close($conexion);
}
$idpais = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM paises WHERE id = $idpais");
mysqli_close($conexion);
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
  header("Location: lista_pais.php");
} else {
  while ($data = mysqli_fetch_array($sql)) {
    $idpais = $data['id'];
    $pais = $data['pais'];
    $estado = $data['estado'];
  }
}
?>
<div class="card" style="    left: 20px;
    right: -30;
    right: 20px;
    margin-right: 42px;
    margin-bottom: 20px">
  <div class="card-body">
    <div align="center"><h5>Mantenimiento de Pais</h5></div>
  </div>
</div>
<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="row" style="margin-bottom: 400px;">
      <div class="col-lg-6 m-auto">
          <div class="card-header bg-primary text-white">
              Editar Pais
          </div>
          <div class="card">
  <div class="row"style="margin-bottom: 50px;">
    <div class="col-lg-6 m-auto">
      <?php echo isset($alert) ? $alert : ''; ?>
      <form class="" action="" method="post">
        <input type="hidden" name="id" value="<?php echo $idpais; ?>">
        <div class="form-group">
          <label for="pais">Pais</label>
          <input type="text" placeholder="Ingrese pais" name="pais" class="form-control" id="pais" value="<?php echo $pais; ?>">
        </div>
        <div class="row">
          <label for="cars" style="padding-left: 15px;">Estado</label>
          <select name="estado" id="estado" style="margin-left: 15px;">
            <option value="Activo">Activo</option>
            <option value="Inactivo">Inactivo</option>
          </select>
        </div><br>
        <input type="submit" value="Actualizar" class="btn btn-primary">
        <a href="lista_pais.php" class="btn btn-danger">Regresar</a>
      </form>
    </div>
  </div>
  </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>
