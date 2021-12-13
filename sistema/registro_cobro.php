<?php include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['factura'])) {
        $alert = '<div class="alert alert-danger" role="alert">
                        Todo los campos son obligatorios
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
    } else {
        $no_factura = $_POST['factura'];
        $fecha_fac = $_POST['fecha'];
        $nom_cliente = $_POST['cliente'];
        $monto_fac = $_POST['monto'];
        $box = $_POST['formacobro'];
        $nombre = $_POST['cheque'];
        $campo2 = $_POST['banco'];
        $usuario_id = $_SESSION['idUser'];
        $query = mysqli_query($conexion, "SELECT * FROM cobros where factura = '$factura'");
        $result = mysqli_fetch_array($query);

        if ($result > 0) {
            $alert = '<div class="alert alert-danger" role="alert">
                        El Pais ya esta registrado
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
        }else{


        $query_insert = mysqli_query($conexion, "INSERT INTO cobros(factura,fecha,cliente,monto,formacobro,cheque,banco,usuario_id) values ('$no_factura','$fecha_fac','$nom_cliente','$monto_fac','$box','$nomnre','$campo2','$usuario_id')");
        if ($query_insert) {
            $alert = '<div class="alert alert-primary" role="alert">
                        Cobro Registrado
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
  </button>
                    </div>';
        } else {
            $alert = '<div class="alert alert-danger" role="alert">
                       Error al registrar Cobro
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
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="card" style="    left: 20px;
                                    right: -30;
                                    right: 20px;
                                    margin-right: 42px;
                                    margin-bottom: 20px">
                                  <div class="card-body">
                                    <div align="center"><h4>Registros de Cobro</h4></div>
                                  </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <form method="post" name="form_new_cliente_venta" id="form_new_cliente_venta">
                                        <input type="hidden" name="action" value="addCliente">
                                        <input type="hidden" id="idcliente" value="1" name="idcliente" required>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Numero de Factura</label>
                                                    <input type="number" name="no_factura" placeholder="Introduce el No de Factura a cobrar" id="no_factura" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Fecha</label>
                                                    <input type="text" name="fecha_fac" id="fecha_fac" class="form-control" disabled required>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Cliente</label>
                                                    <input type="text" name="nom_cliente" id="nom_cliente" class="form-control" disabled required>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Importe a Cobrar</label>
                                                        <input type="text" name="monto_fac" id="monto_fac" class="form-control" disabled required>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Forma de Cobro</label>

<form name="formulario">

</form>

                                              <script>
                                              function funcion(){
                                                  if(document.formulario.box3.checked == true){
                                                      document.formulario.nombre.disabled = false;
                                                      document.formulario.campo2.disabled = false;
                                                  }
                                                  else{
                                                      document.formulario.nombre.disabled = true;
                                                      document.formulario.campo2.disabled = true;
                                                  }
                                              }
                                              </script>
                                              <form name="formulario">
                                                <div class="checkbox">
                                              <input type="checkbox" name="box" value="Contado" onclick="funcion()" />Contado
                                              </div>
                                              <input type="checkbox" name="box" value="Credito" onclick="funcion()" />Credito
                                              <div class="checkbox">
                                              <input type="checkbox" name="box3" value="Cheque"onclick="funcion()" />Cheque
                                            </div><br />
                                              No de Cheque<input type="number" name="nombre" placeholder="Ingrese numero de cheque"class="form-control" disabled /><br />

                                              Entidad Bancaria<select name="campo2" class="form-control" disabled>
                                                <option value="">Seleccione Banco</option>
                                                <option value="Banco Itau">Banco Itau</option>
                                                <option value="Banco Continenta">Banco Continental</option>
                                                <option value="Vision Banco">Vision Banco</option>
                                                <option value="BBVA">BBVA</option>
                                                <option value="FBanco Itapua" >Banco Itapua</option>
                                              </select>
                                              </form></div></div>

                                          <input type="submit" value="Guardar" class="btn btn-primary" style="margin-left: 80px;">
                                          <button type="submit" class="btn btn-primary">Confirmar</button>
                                                          </div>
                                                        </div></div>
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
                                </div>
                            </div>



                            <?php include_once "includes/footer.php"; ?>
