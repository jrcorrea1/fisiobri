<?php
if (!empty($_GET['id'])) {
    require("../conexion.php");
    $idcategoria = $_GET['id'];
    $query_delete = mysqli_query($conexion, "DELETE FROM categoria WHERE id = $idcategoria");
    mysqli_close($conexion);
    header("location: lista_categoria.php");
}
?>
