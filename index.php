<?php
$alert = '';
session_start();
if (!empty($_SESSION['active'])) {
  header('location: sistema/');
} else {
  if (!empty($_POST)) {
    if (empty($_POST['usuario']) || empty($_POST['clave'])) {
      $alert = '<div class="alert alert-danger" role="alert">
  Ingrese su usuario y su clave
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
  </button>
</div>';
    } else {
      require_once "conexion.php";

      //seteamos la variables de usuario y clave
      $user = mysqli_real_escape_string($conexion, $_POST['usuario']);
      $clave = md5(mysqli_real_escape_string($conexion, $_POST['clave']));
      //verificamos si el usuario existe en la base de datos
      $query = mysqli_query($conexion, "SELECT u.idusuario, u.nombre, u.correo,u.usuario,r.idrol,r.rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE u.usuario = '$user' AND u.clave = '$clave' AND u.estado=1");

      $result = mysqli_num_rows($query);
      // verificamos si el resultado es mayor a 0
      if ($result > 0) {
        // si el usuario existe, obtenemos los datos del usuario
        $data = mysqli_fetch_array($query);
        // seteamos las variables de sesion
        $_SESSION['active'] = true;
        $_SESSION['idUser'] = $data['idusuario'];
        $_SESSION['nombre'] = $data['nombre'];
        $_SESSION['email'] = $data['correo'];
        $_SESSION['user'] = $data['usuario'];
        $_SESSION['rol_name'] = $data['rol'];
        $_SESSION['rol'] = $data['idrol'];
        //actualizamos el intento de login
        $intento = mysqli_query($conexion, "UPDATE usuario SET intentos = 0 WHERE usuario = '$user'");
        // redireccionamos al sistema
        header('location: sistema/');
      } else {
        // pregunto si el usuario existe en la base de datos pero se equivoco en la clave
        $query = mysqli_query($conexion, "SELECT u.idusuario, u.nombre, u.correo,u.usuario,r.idrol,r.rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE u.usuario = '$user' AND u.estado=1");

        $result = mysqli_num_rows($query);
        if ($result > 0) {
          $data = mysqli_fetch_array($query);
          $intento = mysqli_query($conexion, "SELECT intentos FROM usuario WHERE usuario = '$user'");
          $row = mysqli_fetch_array($intento);
          $intentos = $row['intentos'];
          // verificamos si el numero de intentos es igual a 3 bloqueamos el usuario
          if ($intentos == 3) {
            $query = mysqli_query($conexion, "UPDATE usuario SET estado = 0 WHERE usuario = '$user'");
            $alert = '<div class="alert alert-danger" role="alert">
                        El usuario se encuentra bloqueado
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                      </div>';
          } else {
            // si el usuario no existe, incrementamos el numero de intentos            
            $query = mysqli_query($conexion, "UPDATE usuario SET intentos = $intentos+1 WHERE usuario = '$user'");
            $alert = '<div class="alert alert-danger" role="alert">
              Usuario o clave incorrecta
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
            </div>';
          }
        } else {
          // si existe el usuario pero su estado es 0
          $query = mysqli_query($conexion, "SELECT u.idusuario, u.nombre, u.correo,u.usuario,r.idrol,r.rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE u.usuario = '$user' AND u.estado=0");
          $result = mysqli_num_rows($query);
          if ($result > 0) {
            $alert = '<div class="alert alert-danger" role="alert">
              El usuario se encuentra bloqueado
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
            </div>';
          } else {
            // si el usuario no existe, le informamos al usuario
            $alert = '<div class="alert alert-danger" role="alert">
            Usuario o clave incorrecta
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>';
          }
        }
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>FisioBri</title>

  <!-- Custom fonts for this template-->
  <link href="sistema/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="sistema/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9" style="top: 140px;">


        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-6 d-none d-lg-block bg-login-image">
            <img src="sistema/img/logo.png" class="img-thumbnail">
          </div>
          <div class="col-lg-6">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-white-900 mb-4" style="color:white;">Iniciar Sesión</h1>
              </div>
              <form class="user" method="POST">
                <?php echo isset($alert) ? $alert : ""; ?>
                <div class="form-group">
                  <label for="" style="color:white;">Usuario</label>
                  <div class="input-group-prepend">
                    <input type="text" class="form-control" placeholder="Ingrese nombre de usuario" name="usuario">
                  </div><br>
                  <div class="form-group">
                    <label for="" style="color:white;">Contraseña</label>
                    <input type="password" class="form-control" placeholder="Ingrese contraseña" name="clave">
                  </div><br>
                  <input type="submit" value="Iniciar" class="btn btn-primary" style="width: 326px;margin-left: 12px;">
                  <hr>
              </form>
              <hr>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="sistema/vendor/jquery/jquery.min.js"></script>
  <script src="sistema/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="sistema/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="sistema/js/sb-admin-2.min.js"></script>

</body>

</html>