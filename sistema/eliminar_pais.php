<?php
if (!empty($_GET['id'])) {
    require("../conexion.php");
    $idpais = $_GET['id'];
    $query_delete = mysqli_query($conexion, "DELETE FROM paises WHERE id = $idpais");
    mysqli_close($conexion);
    header("location: lista_pais.php");
}
?>
