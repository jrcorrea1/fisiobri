<?php include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['fecha']) ||
    empty($_POST['cliente']) ||
    empty($_POST['monto']) ||
    empty($_POST['formacobro']) ||
    empty($_POST['cheque']) ||
    empty($_POST['banco'])) {
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
        if (is_numeric($dni) and $factura != 0) {
            $query = mysqli_query($conexion, "SELECT * FROM cobros where factura = '$factura'");
            $result = mysqli_fetch_array($query);
        }
        if ($result > 0) {
            $alert = '<div class="alert alert-danger" role="alert">
                                    La factura ya esta cancelada!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
        } else {
            $query_insert = mysqli_query($conexion, "INSERT INTO cobros(factura,fecha,cliente,monto,formacobro,cheque,banco,usuario_id) values ('$factura', '$fecha', '$cliente', '$monto', '$formacobro','$cheque','$banco','$usuario_id')");
            if ($query_insert) {
                $alert = '<div class="alert alert-primary" role="alert">
                                    Factura cobrada exitosamente
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">
                                    Error al efectuar el cobro
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
<div class="container-fluid">
    <div class="row" style="margin-bottom: 50px;">
        <div class="col-lg-6 m-auto">
            <form action="" method="post" autocomplete="off">
                <?php echo isset($alert) ? $alert : ''; ?>
                <form id="cobros">
                  <div class="card">
                  <div class="card-header bg-primary text-white">
                    Registro de Cobros
                  </div>
                <div class="form-group col-md-5" style="margin-left: 0px;margin-right: 0px;padding-left: 35px;margin-top: 20px;">
                    <label for="dni">N° de factura</label>
                    <input type="number" placeholder="Ingrese numero de factura" name="factura" id="factura" class="form-control">
                </div>
                <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
                <div class="form-group col-md-5">
                    <label for="fecha">Fecha</label>
                    <input type="text" placeholder="" name="fecha" id="fecha" class="form-control">
                </div>
                <div class="form-group col-md-5">
                    <label for="apellido">Id cliente</label>
                    <input type="text" placeholder="" name="cliente" id="cliente" class="form-control">
                </div>
                </div>
                  <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
                  <div class="form-group col-md-5">
                    <label for="monto">Importe a cobrar</label>
                    <input type="text" placeholder="" name="monto" id="monto" class="form-control">
                </div>
                <div class="group" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
                  <label for="formacobro">Forma de Cobro</label>
                  <select name="formacobro" class="form-control">
                    <option selected="disabled"></option>
                    <option value="Efectivo">Efectivo</option>
                    <option value="Tarjeta" selected>Tarjeta</option>
                    <option value="Cheque">Cheque</option>
                  </select>
                </div>
                </div>
                <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
                <div class="form-group col-md-5">
                  <label for="cheque">N° de cheque</label>
                  <input type="number" placeholder="" name="cheque" id="cheque" class="form-control">
              </div>
                <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
                  <div class="form-group col-md-5"style="right: 20px;">
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
                <div class="form-group col1-md-8" style="margin-bottom: 50px;">
                <input type="submit" value="Confirmar Cobro" class="btn btn-primary" style="margin-left: 150px;">
                <input type="submit" onclick="validar();" value="Limpiar" class="btn btn-danger" style="margin-left: 30px;margin-top: 1px;margin-right: 20px;">
                </div>
            </form>
        </div>
    </div>
    </div>


</div>
<!-- /.container-fluid -->

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
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>
