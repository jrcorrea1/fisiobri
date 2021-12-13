<?php
include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['ciudad'])) {
        $alert = '<div class="alert alert-danger" role="alert">
                        Todo los campos son obligatorios
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
    } else {
        $ciudad = $_POST['ciudad'];
        $departamento = $_POST['departamento'];
        $estado = $_POST['estado'];
        $usuario_id = $_SESSION['idUser'];
        $query = mysqli_query($conexion, "SELECT * FROM ciudad where ciudad = '$ciudad'");
        $result = mysqli_fetch_array($query);

        if ($result > 0) {
            $alert = '<div class="alert alert-danger" role="alert">
                        La ciudad ya esta registrada
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
        }else{


        $query_insert = mysqli_query($conexion, "INSERT INTO ciudad(ciudad,departamento,estado,usuario_id) values ('$ciudad','$departamento','$estado','$usuario_id')");
        if ($query_insert) {
            $alert = '<div class="alert alert-success" role="alert">
                        Ciudad Registrada Correctamente!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
        } else {
            $alert = '<div class="alert alert-danger" role="alert">
                       Error al registrar ciudad
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                       </button>
                    </div>';
        }
        }
    }
}
//mysqli_close($conexion);
?>

<div class="card"style="left: 20px;right: -30;right: 20px;margin-right: 42px;margin-bottom: 20px">
  <div class="card-header text-white" style="background-color: rgb(43, 167, 228);">
    Mantenimiento de Ciudad / Nuevo
  </div>
      <div class="card">
        <div class="card-body">
	<!-- Page Heading -->
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
          Nuevo
        </div>
            <div class="card">
              <div class="row"style="margin-bottom: 50px;">
                <div class="col-lg-6 m-auto">
                <form action="" autocomplete="off" method="post" class="card-body p-2">
                    <?php echo isset($alert) ? $alert : ''; ?>
                    <div class="form-group">
                        <label for="ciudad">Ciudad</label>
                        <input type="text" placeholder="Ingrese nueva ciudad" name="ciudad" id="ciudad" class="form-control">
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
                    <div class="form-group">
                      <label for="barrio">Estado</label>
                      <select name="estado" id="estado" class="form-control">
                        <option value="">--- Seleccionar estado ---</option>
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                      </select>
                    </div><br>
                    <input type="submit" value="Guardar" class="btn btn-primary">
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
