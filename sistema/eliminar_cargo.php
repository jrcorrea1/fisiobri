<?php
if (!empty($_GET['id'])) {
    require("../conexion.php");
    $idcargo = $_GET['id'];
    $query_delete = mysqli_query($conexion, "DELETE FROM cargo WHERE id = $idcargo");
    mysqli_close($conexion);
    header("location: lista_cargo.php");
}
?>
