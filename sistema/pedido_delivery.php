<?php include_once "includes/header.php"; ?>
<div class="card" style="    left: 20px;
    right: -30;
    right: 20px;
    margin-right: 42px;
    margin-bottom: 20px">
  <div class="card-body">
    <div align="center"><h5>Formulario de Pedidos de Delivery</h5></div>
  </div>
</div>
  <div class="container-fluid">
    <div class="card-body">
      <div class="row">
          <div class="col-lg-12">
              <div class="form-group">

  <form method="post" name="form_new_cliente_venta" id="form_new_cliente_venta">
      <input type="hidden" name="action" value="addCliente">
      <input type="hidden" id="idcliente" value="1" name="idcliente" required>
      </div>
      <div class="row">
          <div class="col-lg-2">
              <div class="form-group">
                  <label>CI/RUC:</label>
                  <input type="number" name="dni_cliente" id="dni_cliente" class="form-control">
              </div>
          </div>
          </div>
          <div class="row">
          <div class="col-lg-3">
              <div class="form-group">
                  <label>Cliente</label>
                  <input type="text" name="nom_cliente" id="nom_cliente" class="form-control" disabled required>
              </div>
          </div>
          <div class="col-lg-2">
              <div class="form-group">
                  <label>Contacto</label>
                  <input type="number" name="tel_cliente" id="tel_cliente" class="form-control" disabled required>
              </div>
          </div>
          <div class="col-lg-4">
              <div class="form-group">
                  <label>Destino</label>
                  <input type="text" name="dir_cliente" id="dir_cliente" class="form-control" disabled required>
              </div>
          </div>
  <button type="submit" class="btn btn-primary" style="height: 40px; margin-top: 30px">Sign in</button>
</form>
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="table-responsive">
      <table class="table table-striped table-bordered" id="table">
        <thead class="thead-dark">
          <tr>
            <th>N° PEDIDO</th>
            <th>CI/RUC</th>
            <th>CLIENTE</th>
            <th>CONTACTO</th>
            <th>DESTINO</th>
            <?php if ($_SESSION['rol'] == 1) { ?>

            <?php } ?>
          </tr>
        </thead>
        <tbody>


</div>
</div>
</div>
</div>
  </div>
</div>
<?php include_once "includes/footer.php"; ?>
