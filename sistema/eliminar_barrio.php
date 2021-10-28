<?php
if (!empty($_GET['id'])) {
    require("../conexion.php");
    $idbarrio = $_GET['id'];
    $query_delete = mysqli_query($conexion, "DELETE FROM barrio WHERE id = $idbarrio");
    mysqli_close($conexion);
    header("location: lista_barrio.php");
}
?>
