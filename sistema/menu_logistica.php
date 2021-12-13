<?php include_once "includes/header.php";
?>
<div class="card"style="left: 20px;right: -30;right: 20px;margin-right: 42px;margin-bottom: 20px">
  <div class="card-header text-white" style="background-color: rgb(43, 167, 228);">
    Menu de Logistica
  </div>
      <div class="card">
        <div class="card-body">
<div class="row">
  <div class="col-sm-3">
<div class="card" style="width: 18rem;left: 80px">
<img src="img/pedidodeli.png" class="card-img-top" alt="..." style="width: 150px;margin-left: 50px;">
      <div class="card-body">
        <h5 class="card-title"><strong>Registrar Pedido Delivery</strong></h5>
        <p class="card-text">Luego del cobro, el cliente puede solicitar servicio de delivery</p>
        <a href="pedido_delivery.php" class="btn btn-primary">Nuevo</a>
      </div>
    </div>
  </div>
  <div class="col-sm-2">
    <div class="card" style="width: 18rem;left: 150px;">
    <img src="img/delivery.png" class="card-img-top" alt="..." style="width: 150px;margin-left: 70px;">
          <div class="card-body">
        <h5 class="card-title"><strong>Delivery</strong></h5>
        <p class="card-text">Una vez realizado el pedido, se procede al servicio</p>
        <a href="registro_delivery.php" class="btn btn-primary">Registro Nuevo</a>
      </div>
    </div>
  </div>
    <div class="col-sm-3" >
  <div class="card" style="width: 18rem;left: 320px;">
  <img src="img/logistica.png" class="card-img-top" alt="..." style="width: 140px;margin-left: 70px;margin-top: 10px;">
        <div class="card-body">
          <h5 class="card-title"><strong>Lista de Moviles</strong></h5>
          <p class="card-text">Acceda al listado de transportes disponibles para utilizar</p>
          <a href="#" class="btn btn-primary">Ver</a>
        </div>
      </div>
    </div>
  </div>  </div>
</div>

      <?php include_once "includes/footer.php"; ?>
