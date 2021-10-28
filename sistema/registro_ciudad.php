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


        $query_insert = mysqli_query($conexion, "INSERT INTO ciudad(ciudad,estado,usuario_id) values ('$ciudad','$estado','$usuario_id')");
        if ($query_insert) {
            $alert = '<div class="alert alert-primary" role="alert">
                        Ciudad Registrada
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
mysqli_close($conexion);
?>

<!-- Begin Page Content -->
	<div class="container-fluid">
		<h1 class="h3 mb-0 text-gray-800" style="padding-left: 20px;">
      Mantenimiento Ciudad</h1><br>

<!-- Begin Page Content -->
<div class="col-sm-2">
  <div class="card" style="width: 18rem;left: 10px;">
  <img src="img/add.png" class="card-img-top" alt="..." style="
  width: 150px;margin-left: 55px;margin-top: 20px;">
        <div class="card-body">
    </div>
  </div>
</div>
  </div>
    <!-- Content Row -->
    <div class="card"style="margin-left: 250px;margin-right: 250px;left: 110px;padding-top: 50px;padding-bottom: 50px;bottom: 210px;">

        <div class="col-lg-6 m-auto">
            <div class="card-header bg-primary text-white">
                Nuevo Registro
            </div>
            <div class="card">
                <form action="" autocomplete="off" method="post" class="card-body p-2">
                    <?php echo isset($alert) ? $alert : ''; ?>
                    <div class="form-group">
                        <label for="ciudad">Ciudad</label>
                        <input type="text" placeholder="Ingrese nueva ciudad" name="ciudad" id="ciudad" class="form-control">
                    </div>
                    <div class="row">
                      <label for="cars" style="padding-left: 15px;">Estado</label>
                      <select name="estado" id="estado" style="margin-left: 15px;">
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
