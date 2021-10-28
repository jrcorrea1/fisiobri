 <?php include_once "includes/header.php";
  include "../conexion.php";
  if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['proveedor']) || empty($_POST['producto']) || empty($_POST['precio']) || $_POST['precio'] <  0 || empty($_POST['cantidad'] || $_POST['cantidad'] <  0)) {
      $alert = '<div class="alert alert-danger" role="alert">
                Todo los campos son obligatorios
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
              </div>';
    } else {
      $proveedor = $_POST['proveedor'];
      $producto = $_POST['producto'];
      $precio = $_POST['precio'];
      $cantidad = $_POST['cantidad'];
      $marca = $_POST['marca'];
      $categoria = $_POST['categoria'];
      $usuario_id = $_SESSION['idUser'];

      $query_insert = mysqli_query($conexion, "INSERT INTO producto(proveedor,descripcion,precio,existencia,marca,categoria,usuario_id) values ('$proveedor', '$producto', '$precio', '$cantidad','$marca','$categoria','$usuario_id')");
      if ($query_insert) {
        $alert = '<div class="alert alert-primary" role="alert">
                Producto Registrado
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
              </div>';
      } else {
        $alert = '<div class="alert alert-danger" role="alert">
                Error al registrar el producto
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
              </div>';
      }
    }
  }
  ?>

 <!-- Begin Page Content -->
 <div class="container-fluid">
<div class="card" style="    left: 20px;
    right: -30;
    right: 20px;
    margin-right: 42px;
    margin-bottom: 20px">
  <div class="card-body">
    <div align="center"><h4>Mantenimiento de Producto</h4></div>
    </div>
    </div>
      <div class="row" style="
      margin-bottom: 50px;
  ">
          <div class="col-lg-8 m-auto">
              <form action="" method="post" autocomplete="off">

                  <div class="card">
                    <div class="card-header bg-primary text-white">
                      Registro Producto Nuevo
                    </div><br />

   <!-- Content Row -->
   <div class="row">
     <div class="col-lg-8 m-auto">
       <form action="" method="post" autocomplete="off">
         <?php echo isset($alert) ? $alert : ''; ?>
         <div class="form-group">
           <label>Proveedor</label>
           <?php
            $query_proveedor = mysqli_query($conexion, "SELECT codproveedor, proveedor FROM proveedor ORDER BY proveedor ASC");
            $resultado_proveedor = mysqli_num_rows($query_proveedor);
            //mysqli_close($conexion);
            ?>
           <select id="proveedor" name="proveedor" class="form-control">
             <?php
              if ($resultado_proveedor > 0) {
                while ($proveedor = mysqli_fetch_array($query_proveedor)) {
                  // code...
              ?>
                 <option value="<?php echo $proveedor['codproveedor']; ?>"><?php echo $proveedor['proveedor']; ?></option>
             <?php
                }
              }
              ?>
           </select>
         </div>
         <div class="form-group">
           <label for="producto">Producto</label>
           <input type="text" placeholder="Ingrese nombre del producto" name="producto" id="producto" class="form-control">
         </div>
         <div class="form-group">
           <label for="marca">Marca</label>
           <?php
            $query_marca = mysqli_query($conexion, "SELECT id, marca FROM marca ORDER BY marca ASC");
            $resultado_marca = mysqli_num_rows($query_marca);
            //mysqli_close($conexion);
            ?>
           <select id="marca" name="marca" class="form-control">
             <?php
              if ($resultado_marca > 0) {
                while ($marca = mysqli_fetch_array($query_marca)) {
                  // code...
              ?>
                 <option value="<?php echo $marca['marca']; ?>"><?php echo $marca['marca']; ?></option>
             <?php
                }
              }
              ?>
           </select>
         </div>
         <div class="form-group">
           <label for="categoria">Categoria</label>
            <?php
             $query_categoria = mysqli_query($conexion, "SELECT id, categoria FROM categoria ORDER BY categoria ASC");
             $resultado_categoria = mysqli_num_rows($query_categoria);
             //mysqli_close($conexion);
             ?>
            <select id="categoria" name="categoria" class="form-control">
              <?php
               if ($resultado_categoria > 0) {
                 while ($categoria = mysqli_fetch_array($query_categoria)) {
                   // code...
               ?>
                  <option value="<?php echo $categoria['categoria']; ?>"><?php echo $categoria['categoria']; ?></option>
              <?php
                 }
               }
               ?>
            </select>
         </div>
         <div class="form-group">
           <label for="precio">Precio</label>
           <input type="text" placeholder="Ingrese precio" class="form-control" name="precio" id="precio">
         </div>
         <div class="form-group">
           <label for="cantidad">Cantidad</label>
           <input type="number" placeholder="Ingrese cantidad" class="form-control" name="cantidad" id="cantidad">
         </div><br />
         <input type="submit" value="Guardar Producto" class="btn btn-primary">
         <a href="lista_productos.php" class="btn btn-danger">Regresar</a><br /><br />
       </form>
     </div>
   </div>


 </div>
 <!-- /.container-fluid -->

 </div>
 <!-- End of Main Content -->
 <?php include_once "includes/footer.php"; ?>
