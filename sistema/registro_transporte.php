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
<div class="card"style="left: 20px;right: -30;right: 20px;margin-right: 42px;margin-bottom: 20px">
  <div class="card-header text-white" style="background-color: rgb(43, 167, 228);">
    Mantenimiento de Ciudad / Nuevo
  </div>
      <div class="card">
        <div class="card-body">
	<!-- Page Heading -->
	<div class="col-sm-2">
    <div class="card" style="width: 18rem;left: 10px;">
    <img src="img/transporte.png" class="card-img-top" alt="..." style="width: 150px;margin-left: 50px;margin-top: 20px;">
          <div class="card-body">
        <h5 class="card-title"><strong>Transporte</strong></h5>
      </div>
    </div>
  </div>
<!-- Begin Page Content -->
<div class="card"style="margin-left: 250px;margin-right: 250px;left: 110px;padding-top: 10px;bottom: 175px;">
  <div class="card"style="left: 20px;right: -30;right: 20px;margin-right: 42px;margin-bottom: 20px">
    <div class="card-header text-white" style="background-color: rgb(43, 167, 228);">
      Nuevo
    </div>
        <div class="card">
          <div class="row"style="margin-bottom: 50px;">
            <form action="" autocomplete="off" method="post" class="card-body p-2">
                <?php echo isset($alert) ? $alert : ''; ?>
                <div class="form-group col-md-5" style="margin-left: 0px;margin-right: 0px;padding-left: 35px;margin-top: 20px;">
                    <label for="tipo_transporte">Tipo Transporte</label>
                    <select name="tipo_transporte" class="form-control">
                      <option disabled selected value> -- Seleccionar -- </option>
                      <option value="Auto">Auto</option>
                      <option value="Pick-up">Pick-up</option>
                      <option value="Furgoneta">Furgoneta</option>
                      <option value="Camion">Furgoneta</option>
                      <option value="Camion">Motocicleta</option>
                    </select>
                </div>
                <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
                <div class="form-group col-md-5">
                    <label for="marca">Marca</label>
                    <?php
                     $query_marca = mysqli_query($conexion, "SELECT id, marca FROM marca WHERE categoria='Transportes' ORDER BY marca ASC");
                     $resultado_marca = mysqli_num_rows($query_marca);
                     //mysqli_close($conexion);
                     ?>
                     <select class="form-control seleccion" id="marca" name="marca">
                   <option value="">--- Seleccionar marca ---</option>
                   <?php foreach ($query_marca as $mar) {
                     $selected = ($mar['marca'] == $marca) ? "selected" : null;
                     echo '<option value="' . $mar['marca'] . '" ' . $selected . '>' . $mar['marca'] . '</option>';
                   } ?>
                 </select>
                </div>
                <div class="form-group col-md-5">
                    <label for="modelo">Modelo</label>
                    <input type="text" placeholder="" name="modelo" id="modelo" class="form-control">
                </div>
                </div>
                  <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;">
                  <div class="form-group col-md-5">
                    <label for="año">Año</label>
                    <input type="number" placeholder="" name="año" id="año" class="form-control">
                </div>
                <div class="form-group col-md-5">
                  <label for="monto">Matricula</label>
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
                    <label for="cargo">Marca</label>
                    <?php
                     $query_cargo = mysqli_query($conexion, "SELECT id, marca FROM marca WHERE categoria = 'transportes'");
                     $resultado_cargo = mysqli_num_rows($query_cargo);
                     //mysqli_close($conexion);
                     ?>
                     <select class="form-control seleccion" id="cargo" name="cargo">
                   <option value="">--- Seleccionar cargo ---</option>
                   <?php foreach ($query_cargo as $car) {
                     $selected = ($car['cargo'] == $cargo) ? "selected" : null;
                     echo '<option value="' . $car['cargo'] . '" ' . $selected . '>' . $car['cargo'] . '</option>';
                   } ?>
                 </select>
                  </div>
                <div class="form-group col1-md-8" style="margin-bottom: 50px;">
                <input type="submit" value="Confirmar Cobro" class="btn btn-primary" style="margin-left: 150px;">
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
