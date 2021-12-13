<?php include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['ruc']) ||
      empty($_POST['banco']) ||
    empty($_POST['ciudad']) ||
    empty($_POST['telefono']) ||
    empty($_POST['direccion']) ||
    empty($_POST['estado'])) {
        $alert = '<div class="alert alert-danger" role="alert">
                                    Todo los campos son obligatorios!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
    } else {
        $idbanco =$_POST['idbanco'];
        $ruc = $_POST['ruc'];
        $banco = $_POST['banco'];
        $ciudad = $_POST['ciudad'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        $estado = $_POST['estado'];
        $usuario_id = $_SESSION['idUser'];
        $query = mysqli_query($conexion, "SELECT * FROM banco where ruc = '$ruc'");
        $result = mysqli_fetch_array($query);

        }
        if ($result > 0) {
            $alert = '<div class="alert alert-danger" role="alert">
                                    El banco, ya existe en la base de batos!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
        } else {
            $query_insert = mysqli_query($conexion, "INSERT INTO banco(ruc,banco,ciudad,direccion,telefono,estado, usuario_id) values ('$ruc','$banco', '$ciudad','$direccion','$telefono','$estado', '$usuario_id')");
            if ($query_insert) {
                $alert = '<div class="alert alert-success" role="alert">
                                    Banco Registrado Correctamente!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">
                                    Error al Guardar
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>';
            }
        }
    }
//    mysqli_close($conexion);

?>

<div class="card"style="left: 20px;right: -30;right: 20px;margin-right: 42px;margin-bottom: 20px">
  <div class="card-header text-white" style="background-color: rgb(43, 167, 228);">
    Mantenimiento de Bancos / Nuevo
  </div>
      <div class="card"style="height: 1002px;">
        <div class="card-body">
	<!-- Page Heading -->
	<div class="col-sm-2">
    <div class="card" style="width: 18rem;left: 10px;">
    <img src="img/banco.png" class="card-img-top" alt="..." style="width: 150px;margin-left: 50px;margin-top: 20px;">
          <div class="card-body">
        <h5 class="card-title"><strong>Bancos</strong></h5>
        <a href="lista_banco.php" class="btn btn-danger">Regresar</a>

      </div>
    </div>
  </div>
  <div class="card"style="margin-left: 250px;margin-right: 250px;left: 110px;padding-top: 10px;padding-bottom: 10px;bottom: 248px;">
    <div class="card"style="left: 20px;right: -30;right: 20px;margin-right: 42px;margin-bottom: 20px">
      <div class="card-header text-white" style="background-color: rgb(43, 167, 228);">
        Nuevo
      </div>
        <div class="col-lg-6 m-auto">
            <form id="form" action="" method="post" autocomplete="off">
                <?php echo isset($alert) ? $alert : ''; ?>
                <div class="card"style="width: 582px;right: 140px;"><br>
                <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
                  <input type="hidden" id="idbanco" value="1" name="idbanco" required>
                  <div class="form-group col-md-3">
                    <label for="ruc">Ruc</label>
                    <input type="text" placeholder="Ingrese Ruc" name="ruc" id="ruc" class="form-control">
                  </div>
                <div class="form-group col-md-5">
                    <label for="banco">Entidad Bancaria</label>
                    <input type="text" placeholder="Ingrese banco" name="banco" class="form-control">
                </div>
                </div>
                  <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
                    <div class="form-group col-md-5">
                        <label for="ciudad">Ciudad</label>
                        <?php
                         $query_ciudad = mysqli_query($conexion, "SELECT id, ciudad FROM ciudad ORDER BY ciudad ASC");
                         $resultado_ciudad = mysqli_num_rows($query_ciudad);
                         //mysqli_close($conexion);
                         ?>
                        <select id="ciudad" name="ciudad" class="form-control">
                          <?php
                           if ($resultado_ciudad > 0) {
                             while ($ciudad = mysqli_fetch_array($query_ciudad)) {
                               // code...
                           ?>
                              <option value="<?php echo $ciudad['ciudad']; ?>"><?php echo $ciudad['ciudad']; ?></option>
                          <?php
                             }
                           }
                           ?>
                        </select>
                    </div>
                </div>
                <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
                <div class="form-group col-md-8">
                  <label for="direccion">Direccion</label>
                  <input type="text" placeholder="Ingrese Direccion" name="direccion" id="direccion" class="form-control">
              </div>
              <div class="form-group col-md-5">
                <label for="telefono">Telefono</label>
                <input type="number" placeholder="Ingrese Telefono" name="telefono" id="telefono" class="form-control">
            </div></div>
              <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
                <div class="form-group col-md-5">
                  <label for="estado">Estado</label>
                  <select name="estado" class="form-control">
                    <option value="Activo">Activo</option>
                    <option value="Inactivo" selected>Inactivo</option>
                  </select>
              </div>
                <div class="form-group col1-md-8" style="margin-bottom: 50px;">
                <input type="submit" value="Guardar Banco" class="btn btn-primary" style="margin-left: 150px;">
                <input type="button" onclick="validar();" value="Cancelar" class="btn btn-danger" style="margin-left: 20px;">
                </div>
            </form>
        </div>

    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>
