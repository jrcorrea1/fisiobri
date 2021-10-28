<?php
include "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['categoria'])) {
    $alert = '<div class="alert alert-danger" role="alert">
              Todos los campos son requeridos
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
            </div>';
  } else {
    $idcategoria = $_GET['id'];
    $categoria = $_POST['categoria'];
    $estado = $_POST['estado'];
    $sql_update = mysqli_query($conexion, "UPDATE categoria SET categoria = '$categoria',estado = '$estado' WHERE id = $idcategoria");

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
  header("Location: lista_categoria.php");
  mysqli_close($conexion);
}
$idcategoria = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM categoria WHERE id = $idcategoria");
mysqli_close($conexion);
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
  header("Location: lista_categoria.php");
} else {
  while ($data = mysqli_fetch_array($sql)) {
    $idcategoria = $data['id'];
    $categoria = $data['categoria'];
    $estado = $data['estado'];
  }
}
?>
<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="row" style="margin-bottom: 400px;">
      <div class="col-lg-6 m-auto">
          <div class="card-header bg-primary text-white">
              Editar categoria
          </div>
          <div class="card">
  <div class="row"style="margin-bottom: 50px;">
    <div class="col-lg-6 m-auto">
      <?php echo isset($alert) ? $alert : ''; ?>
      <form class="" action="" method="post">
        <input type="hidden" name="id" value="<?php echo $idcategoria; ?>">
        <div class="form-group">
          <label for="categoria">categoria</label>
          <input type="text" placeholder="Ingrese categoria" name="categoria" class="form-control" id="categoria" value="<?php echo $categoria; ?>">
        </div>
        <div class="row">
          <label for="cars" style="padding-left: 15px;">Estado</label>
          <select name="estado" id="estado" style="margin-left: 15px;">
            <option value="Activo">Activo</option>
            <option value="Inactivo">Inactivo</option>
          </select>
        </div><br>
        <input type="submit" value="Actualizar" class="btn btn-primary">
        <a href="lista_categoria.php" class="btn btn-danger">Regresar</a>
      </form>
    </div>
  </div>
  </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>
