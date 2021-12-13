<?php
if (!empty($_GET['id'])) {
    require("../conexion.php");
    $id = $_GET['id'];
    $query_delete = mysqli_query($conexion, "DELETE FROM pedido_delivery WHERE id = $id");
    mysqli_close($conexion);
    header("location: pedido_delivery.php");
}
?>
