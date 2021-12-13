<?php include_once "includes/header.php";
?>
<div class="card"style="left: 20px;right: -30;right: 20px;margin-right: 42px;margin-bottom: 20px">
  <div class="card-header text-white" style="background-color: rgb(43, 167, 228);">
    Menu de Fisioterapia
  </div>
      <div class="card">
        <div class="card-body">
<div class="row">
  <div class="col-sm-3">
<div class="card" style="width: 18rem;left: 80px;">
<img src="img/fisio2.png" class="card-img-top" alt="..." style="width: 150px;margin-left: 50px">
      <div class="card-body">
        <h5 class="card-title"><strong>Pedido Servicio Medico</strong></h5>
        <p class="card-text">Se completa el formulario servicios medicos</p>
        <a href="pedido_servicio.php" class="btn btn-primary">Nuevo</a>
      </div>
    </div>
  </div>
  <div class="col-sm-2">
    <div class="card" style="width: 18rem;left: 80px;">
    <img src="img/fisio.png" class="card-img-top" alt="..." style="width: 150px;margin-left: 50px">
          <div class="card-body">
        <h5 class="card-title"><strong> Registrar Servicio</strong></h5>
        <p class="card-text">Una vez realizado el pedido, se procede al servicio</p>
        <a href="registro_servicio.php" class="btn btn-primary">Nuevo</a>
      </div>
    </div>
  </div>
    <div class="col-sm-3" >
  <div class="card" style="width: 18rem;left: 200px;right: 10px;" >
  <img src="img/lista.png" class="card-img-top" alt="..." style="width: 150px;margin-left: 50px;
      margin-top: 11px;  ">
        <div class="card-body">
          <h5 class="card-title"><strong>Lista de Servicios</strong></h5>
          <p class="card-text">Acceda al listado las consultas realizadas</p>
          <a href="#" class="btn btn-primary">Ver</a>
        </div>
      </div>
    </div>
  </div>
</div>

      <?php include_once "includes/footer.php"; ?>
