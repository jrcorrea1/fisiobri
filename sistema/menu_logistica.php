<?php include_once "includes/header.php";
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800" style="
    padding-left: 50px;
">Menu Logistica</h1>
</div>
<div class="row">
  <div class="col-sm-3">
<div class="card" style="width: 18rem;left: 80px;">
<img src="img/pedidodeli.png" class="card-img-top" alt="..." style="
    width: 150px;
    margin-left: 50px;
">
      <div class="card-body">
        <h5 class="card-title"><strong>Registrar Pedido Delivery</strong></h5>
        <p class="card-text">Luego del cobro, el cliente puede solicitar servicio de delivery</p>
        <a href="pedido_delivery.php" class="btn btn-primary">Nuevo</a>
      </div>
    </div>
  </div>
  <div class="col-sm-2">
    <div class="card" style="width: 18rem;left: 80px;">
    <img src="img/delivery.png" class="card-img-top" alt="..." style="
    width: 150px;
    margin-left: 50px;
">
          <div class="card-body">
        <h5 class="card-title"><strong>Delivery</strong></h5>
        <p class="card-text">Una vez realizado el pedido, se procede al servicio</p>
        <a href="registro_rol.php" class="btn btn-primary">Nuevo</a>
      </div>
    </div>
  </div>
    <div class="col-sm-3" >
  <div class="card" style="width: 18rem;left: 200px;right: 10px;" >
  <img src="img/logistica.png" class="card-img-top" alt="..." style="
      width: 150px;
      margin-left: 50px;
  ">
        <div class="card-body">
          <h5 class="card-title"><strong>Lista de Moviles</strong></h5>
          <p class="card-text">Acceda al listado de transportes disponibles para utilizar</p>
          <a href="lista_usuarios.php" class="btn btn-primary">Ver</a>
        </div>
      </div>
    </div>
  </div>
</div><br />

      <?php include_once "includes/footer.php"; ?>
