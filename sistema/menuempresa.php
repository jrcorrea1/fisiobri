<?php include_once "includes/header.php";
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800" style="
    padding-left: 50px;
">Empresa</h1>
</div>
<div class="row">
  <div class="col-sm-3">
<div class="card" style="width: 18rem;left: 80px;">
<img src="img/empleado.png" class="card-img-top" alt="..." style="
    width: 150px;
    margin-left: 50px;
">
      <div class="card-body">
        <h5 class="card-title"><strong>Agregar Empleado</strong></h5>
        <p class="card-text">Alta de empleados para de la empresa</p>
        <a href="#" class="btn btn-primary">Nuevo</a>
      </div>
    </div>
  </div>
  <div class="col-sm-2">
    <div class="card" style="width: 18rem;left: 80px;">
    <img src="img/prof.png" class="card-img-top" alt="..." style="
    width: 150px;
    margin-left: 50px;
">
          <div class="card-body">
        <h5 class="card-title"><strong>Cargos</strong></h5>
        <p class="card-text">Una vez dado de alta al empleado, procede registrar cargo</p>
        <a href="#" class="btn btn-primary">Nuevo</a>
      </div>
    </div>
  </div>
    <div class="col-sm-3" >
  <div class="card" style="width: 18rem;left: 200px;right: 10px;" >
  <img src="img/sucursal.png" class="card-img-top" alt="..." style="
      width: 150px;
      margin-left: 50px;
  ">
        <div class="card-body">
          <h5 class="card-title"><strong>Sucursales</strong></h5>
          <p class="card-text">Acceda a Sucursales </p>
          <a href="#" class="btn btn-primary">Acceder</a>
        </div>
      </div>
    </div>
  </div>
</div><br />
<div class="card" style="width: 18rem;left: 80px;margin-bottom: 30px;">
  <div class="card-body">
    <h5 class="card-title">Informacion de FisioBri</h5>

    <p class="card-text">Datos basicos de la empresa</p>
    <a href="info.php" class="card-link">Info</a>
  </div>
</div>

      <?php include_once "includes/footer.php"; ?>
