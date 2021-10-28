<?php
    include('conec.php');
    $valor = $_GET['valor'];
    $sql2 = new conectarMySQL("localhost", "junior", "56824319", "nomina");
    $sql2->conectar();
    $sql2->consultar("SELECT nombre, apaterno, amaterno, rfc, puesto FROM trabajadores WHERE id = '$valor' ");
    $row = $sql2->obtendatos();
    echo $row['nombre'].'|'.$row['apaterno'].'|'.$row['amaterno'].'|'.$row['puesto'].'|'.$row['rfc'];
    sleep(1);
    return $dat = $row['nombre'].'|'.$row['apaterno'].'|'.$row['amaterno'].'|'.$row['puesto'].'|'.$row['rfc'];
    $sql2->cerrarconexion();
    $sql2->limpiaconsulta();
?>
