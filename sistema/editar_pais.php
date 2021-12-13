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
<div class="card"style="left: 20px;right: -30;right: 20px;margin-right: 42px;margin-bottom: 20px">
  <div class="card-header text-white" style="background-color: rgb(43, 167, 228);">
    Mantenimiento de Pais / Nacionalidad / Editar
  </div>
      <div class="card">
        <div class="card-body">
	<!-- Page Heading -->
	<div class="col-sm-2">
    <div class="card" style="width: 18rem;left: 10px;">
    <img src="img/map.png" class="card-img-top" alt="..." style="width: 150px;margin-left: 50px;margin-top: 20px;">
          <div class="card-body">
        <h5 class="card-title"><strong>Pais / Nacionalidad</strong></h5>
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
        <input type="hidden" name="id" value="<?php echo $idpais; ?>">
        <div class="form-group">
          <label for="pais">Pais</label>
          <input type="text" placeholder="Ingrese pais" name="pais" class="form-control" id="pais" value="<?php echo $pais; ?>">
        </div>
        <div class="row">
          <label for="cars" style="padding-left: 15px;">Estado</label>
          <select name="estado" id="estado" style="margin-left: 15px;" class="form-control">
            <option value="Activo">Activo</option>
            <option value="Inactivo">Inactivo</option>
          </select>
        </div><br>
        <form action="editar_pais.php?id=<?php echo $data['id']; ?>" method="post" class="actualizar d-inline">
          <button class="btn btn-primary" type="submit"> Editar</button>
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
