<?php
include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['categoria'])) {
        $alert = '<div class="alert alert-danger" role="alert">
                        Todo los campos son obligatorios
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
    } else {
        $categoria = $_POST['categoria'];
        $estado = $_POST['estado'];
        $usuario_id = $_SESSION['idUser'];
        $query = mysqli_query($conexion, "SELECT * FROM categoria where categoria = '$categoria'");
        $result = mysqli_fetch_array($query);

        if ($result > 0) {
            $alert = '<div class="alert alert-danger" role="alert">
                        El categoria ya esta registrado
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
        }else{


        $query_insert = mysqli_query($conexion, "INSERT INTO categoria(categoria,estado,usuario_id) values ('$categoria','$estado','$usuario_id')");
        if ($query_insert) {
            $alert = '<div class="alert alert-success" role="alert">
                        categoria Registrado
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
        } else {
            $alert = '<div class="alert alert-danger" role="alert">
                       Error al registrar categoria
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

<div class="card"style="left: 20px;right: -30;right: 20px;margin-right: 42px;margin-bottom: 20px">
  <div class="card-header text-white" style="background-color: rgb(43, 167, 228);">
    Mantenimiento de Categoria / Nuevo
  </div>
      <div class="card">
        <div class="card-body">
    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card-header bg-primary text-white">
                Registro categoria
            </div>
            <div class="card">
                <form action="" autocomplete="off" method="post" class="card-body p-2">
                    <?php echo isset($alert) ? $alert : ''; ?>
                    <div class="form-group">
                        <label for="categoria">Categoria</label>
                        <input type="text" placeholder="Ingrese categoria" name="categoria" id="categoria" class="form-control">
                    </div>
                    <div class="row">
                      <label for="cars" style="padding-left: 15px;">Estado</label>
                      <select name="estado" id="estado" style="margin-left: 15px;" class="form-control">
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                      </select>
                    </div><br>
                    <input type="submit" value="Guardar categoria" class="btn btn-primary">
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
