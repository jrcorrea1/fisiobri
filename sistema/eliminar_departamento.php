<?php
if (!empty($_GET['id'])) {
    require("../conexion.php");
    $iddepartamento = $_GET['id'];
    $query_delete = mysqli_query($conexion, "DELETE FROM departamentos WHERE id = $iddepartamento");
    mysqli_close($conexion);
    header("location: lista_departamento.php");
}
?>
