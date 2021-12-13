<?php
include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['marca'])) {
        $alert = '<div class="alert alert-danger" role="alert">
                        Todo los campos son obligatorios
                    </div>';
    } else {
        $marca = $_POST['marca'];
        $categoria = $_POST['categoria'];
        $estado = $_POST['estado'];
        $usuario_id = $_SESSION['idUser'];
        $query = mysqli_query($conexion, "SELECT * FROM marca where marca = '$marca'");
        $result = mysqli_fetch_array($query);

        if ($result > 0) {
            $alert = '<div class="alert alert-danger" role="alert">
                        La marca ya esta registrada
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
        }else{


        $query_insert = mysqli_query($conexion, "INSERT INTO marca(marca,categoria,estado,usuario_id) values ('$marca','$categoria','$estado','$usuario_id')");
        if ($query_insert) {
            $alert = '<div class="alert alert-success" role="alert">
                        Marca Registrada Exitosamente
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
        } else {
            $alert = '<div class="alert alert-danger" role="alert">
                       Error al registrar marca
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

<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="card"style="left: 20px;right: -30;right: 20px;margin-right: 42px;margin-bottom: 20px">
    <div class="card-header text-white" style="background-color: rgb(43, 167, 228);">
      Mantenimiento de Marcas / Nuevo
    </div>

<div class="col-sm-2">
  <div class="card" style="width: 18rem;left: 10px;">
  <img src="img/add.png" class="card-img-top" alt="..." style="
  width: 150px;margin-left: 55px;margin-top: 20px;">
        <div class="card-body">
    </div>
  </div>
  </div>
    <!-- Content Row -->
    <div class="card"style="margin-left: 250px;margin-right: 250px;left: 110px;padding-top: 50px;padding-bottom: 50px;bottom: 210px;">

        <div class="col-lg-8 m-auto">
            <div class="card-header bg-primary text-white">
                              Nuevo Registro
            </div>
            <div class="card">
                <form action="" autocomplete="off" method="post" class="card-body p-2">
                    <?php echo isset($alert) ? $alert : ''; ?>
                    <div class="form-group col-md-6">
                        <label for="marca">Marca</label>
                        <input type="text" placeholder="Ingrese marca" name="marca" id="marca" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="categoria">Categoria</label>
                        <?php
                         $query_categoria = mysqli_query($conexion, "SELECT id, categoria FROM categoria");
                         $resultado_categoria = mysqli_num_rows($query_categoria);
                         //mysqli_close($conexion);
                         ?>
                         <select class="form-control seleccion" id="categoria" name="categoria">
                       <option value="">-- Seleccionar categoria --</option>
                       <?php foreach ($query_categoria as $cat) {
                         $selected = ($cat['categoria'] == $categoria) ? "selected" : null;
                         echo '<option value="' . $cat['categoria'] . '" ' . $selected . '>' . $cat['categoria'] . '</option>';
                       } ?>
                     </select>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-6">
                      <label for="cars" style="padding-left: 15px;">Estado</label>
                      <select name="estado" id="estado" style="margin-left: 15px;" class="form-control">
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                      </select>
                    </div></div><br>
                    <div class="form-group col-md-6">
                    <input type="submit" value="Guardar" class="btn btn-primary">
                    <a href="lista_marca.php" class="btn btn-danger">Regresar</a>
                    <br>
                </form>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->


<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>
