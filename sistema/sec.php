<?php include_once "includes/header.php";
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800" style="
    padding-left: 50px;
">Menu de Seguridad</h1>
</div>
<div class="row">
  <div class="col-sm-3">
<div class="card" style="width: 18rem;left: 80px;">
<img src="img/contact.png" class="card-img-top" alt="..." style="
    width: 150px;
    margin-left: 50px;
">
      <div class="card-body">
        <h5 class="card-title"><strong>Agregar Usuario</strong></h5>
        <p class="card-text">Registrar usuario para acceder a las funciones del sistema</p>
        <a href="registro_usuario.php" class="btn btn-primary">Nuevo</a>
      </div>
    </div>
  </div>
  <div class="col-sm-2">
    <div class="card" style="width: 18rem;left: 80px;">
    <img src="img/profile.png" class="card-img-top" alt="..." style="
    width: 150px;
    margin-left: 50px;
">
          <div class="card-body">
        <h5 class="card-title"><strong>Nuevo Rol</strong></h5>
        <p class="card-text">Una vez agregado el usuario, podras definir el rol que utilizara</p>
        <a href="registro_rol.php" class="btn btn-primary">Nuevo</a>
      </div>
    </div>
  </div>
    <div class="col-sm-3" >
  <div class="card" style="width: 18rem;left: 200px;right: 10px;" >
  <img src="img/list.png" class="card-img-top" alt="..." style="
      width: 150px;
      margin-left: 50px;
  ">
        <div class="card-body">
          <h5 class="card-title"><strong>Lista Usuarios</strong></h5>
          <p class="card-text">Acceda al listado de Usuarios registrados a la fecha</p>
          <a href="lista_usuarios.php" class="btn btn-primary">Nuevo</a>
        </div>
      </div>
    </div>
  </div>
</div><br />

      <?php include_once "includes/footer.php"; ?>
