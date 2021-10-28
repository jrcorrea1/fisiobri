<?php
if (!empty($_GET['id'])) {
    require("../conexion.php");
    $idciudad = $_GET['id'];
    $query_delete = mysqli_query($conexion, "DELETE FROM ciudad WHERE id = $idciudad");
    mysqli_close($conexion);
    header("location: lista_ciudad.php");
}
?>
