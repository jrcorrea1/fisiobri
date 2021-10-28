<?php
if (!empty($_GET['id'])) {
    require("../conexion.php");
    $idmarca = $_GET['id'];
    $query_delete = mysqli_query($conexion, "DELETE FROM marca WHERE id = $idmarca");
    mysqli_close($conexion);
    header("location: lista_marca.php");
}
?>
