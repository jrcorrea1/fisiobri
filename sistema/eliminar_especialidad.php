<?php
if (!empty($_GET['id'])) {
    require("../conexion.php");
    $idespecialidad = $_GET['id'];
    $query_delete = mysqli_query($conexion, "DELETE FROM especialidad WHERE id = $idespecialidad");
    mysqli_close($conexion);
    header("location: lista_especialidad.php");
}
?>
