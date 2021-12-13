<?php include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['fecha']) ||
    empty($_POST['cliente']) ||
    empty($_POST['monto']) ||
    empty($_POST['formacobro']) ||
    empty($_POST['cheque']) ||
    empty($_POST['banco'])){

        $alert = '<div class="alert alert-danger" role="alert">
                Todo los campos son obligatorio
                                </div>';
    } else {
        $factura = $_POST['factura'];
        $fecha = $_POST['fecha'];
        $cliente = $_POST['cliente'];
        $monto = $_POST['monto'];
        $formacobro = $_POST['formacobro'];
        $cheque = $_POST['cheque'];
        $banco = $_POST['banco'];
        $usuario_id = $_SESSION['idUser'];

        $result = 0;
        if (is_numeric($factura) and $factura != 0) {
            $query = mysqli_query($conexion, "SELECT * FROM cobros where factura = '$factura'");
            $result = mysqli_fetch_array($query);
        }
        if ($result > 0) {
            $alert = '<div class="alert alert-danger" role="alert">
                                    Ya factura ya ha sido cobrada.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
        } else {
            $query_insert = mysqli_query($conexion, "INSERT INTO cobros(factura,fecha,cliente,monto,formacobro,cheque,banco,usuario_id) values ('$factura', '$fecha', '$cliente', '$monto', '$formacobro','$cheque','$banco','$usuario_id')");
            if ($query_insert) {
                $alert = '<div class="alert alert-primary" role="alert">
                                    Cobro Realizado exitosamente
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">
                                    Error al Efectuar el cobro
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>';
            }
        }
    }
//    mysqli_close($conexion);
}
?>

<!-- Begin Page Content -->
<div class="card" style="left: 20px;right: -30;right: 20px;margin-right: 62px;margin-bottom: 20px">
  <div class="card-body">
    <div align="center"><h4>Registro de Cobros</h4></div>
  </div>
</div>
<form id="cobros">
<div class="card" style="left: 20px;right: -30;right: 20px;margin-right: 42px;margin-bottom: 40px;">
  <div class="card-body">
    <div class="row">
        <div class="col-lg-7">
            <form action="" method="post" autocomplete="off">
                <?php echo isset($alert) ? $alert : ''; ?>
                  <div class="form-group col-md-5" style="margin-left: 0px;margin-right: 0px;padding-left: 35px;margin-top: 20px;">
                      <label for="factura">Fecha Actual</label>
                      <input type="datetime" name="fechacobro" id="fechacobro" class="form-control" value="<?php echo date("d-m-Y");?>" style="width:100px;">
                  </div>
                <div class="form-group col-md-5" style="margin-left: 0px;margin-right: 0px;padding-left: 35px;margin-top: 20px;">
                    <label for="factura">N° de Factua</label>
                    <input type="number" placeholder="N° de Factura" name="factura" id="factura" class="form-control">
                </div>
                <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
                <div class="form-group col-md-5">
                    <label for="fecha">Fecha</label>
                    <input type="text" placeholder="" name="fecha" id="fecha" class="form-control">
                </div>
                <div class="form-group col-md-5">
                    <label for="cliente">Cliente ID</label>
                    <input type="text" placeholder="" name="cliente" id="cliente" class="form-control">
                </div>
                </div>
                  <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
                  <div class="form-group col-md-5">
                    <label for="monto">Importe a cobrar</label>
                    <input type="text" placeholder="" name="monto" id="monto" class="form-control">
                </div>
                <div class="group">
                    <label for="formacobro">Forma de Cobro</label>
                    <select name="formacobro" class="form-control">
                      <option selected="disabled"></option>
                      <option value="Contado">Contado</option>
                      <option value="Credito" selected>Credito</option>
                      <option value="Cheque">Cheque</option>
                    </select>
                </div>
                </div>
                <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
                <div class="form-group col-md-5">
                    <label for="cheque">N° de Cheque</label>
                  <input type="number" placeholder="" name="cheque" id="cheque" class="form-control">
                </div>
                <div class="form-group col-md-5">
                    <label for="banco">Banco</label>
                    <?php
                     $query_banco = mysqli_query($conexion, "SELECT id, banco FROM banco ORDER BY banco ASC");
                     $resultado_banco = mysqli_num_rows($query_banco);
                     mysqli_close($conexion);
                     ?>
                    <select id="banco" name="banco" class="form-control">
                      <?php
                       if ($resultado_banco > 0) {
                         while ($banco = mysqli_fetch_array($query_banco)) {
                           // code...
                       ?>
                          <option value="<?php echo $banco['banco']; ?>"><?php echo $banco['banco']; ?></option>
                      <?php
                         }
                       }
                       ?>
                    </select>
                </div>
                </div>
                <div class="form-group col1-md-8">
                <input type="submit" value="Confirmar Cobro" class="btn btn-primary" style="margin-left: 30px;margin-top: 20px;margin-right: 10px;">
                <input type="submit" onclick="validar();" value="Limpiar" class="btn btn-danger" style="margin-left: 30px;margin-top: 20px;margin-right: 20px;">
                </div>

          </div>
        </div>
</div>
<div class="table-responsive">
  <table class="table table-hover">
      <thead class="thead-dark">
          <tr>
              <th width="100px">ID</th>
              <th>FACTURA N°</th>
              <th>FECHA</th>
              <th width="100px">CLIENTE</th>
              <th class="textright">MONTO</th>
              <th class="textright">FORMA DE COBRO</th>
              <th>ACCIONES</th>
          </tr>
          <tbody>
            <?php
            include "../conexion.php";

            $query = mysqli_query($conexion, "SELECT * FROM cobros");
            $result = mysqli_num_rows($query);
            if ($result > 0) {
              while ($data = mysqli_fetch_assoc($query)) { ?>
                <tr>
                  <td><?php echo $data['id']; ?></td>
                  <td><?php echo $data['factura']; ?></td>
                  <td><?php echo $data['fecha']; ?></td>
                  <td><?php echo $data['cliente']; ?></td>
                  <td><?php echo $data['monto']; ?></td>
                  <td><?php echo $data['formacobro']; ?></td>
                  <?php if ($_SESSION['rol'] == 1) { ?>
                  <td>
                    <form action="#" method="post" class="confirmar d-inline">

                      <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
                    </form>
                  </td>
                  <?php } ?>
                </tr>
            <?php }
            } ?>
          </tbody>
          </form>
</form>
</div>
</div>
</div>
</div>
<!-- /.container-fluid -->


<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>
