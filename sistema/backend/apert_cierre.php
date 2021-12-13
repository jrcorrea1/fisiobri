<?php 

session_start();
include('../../conexion.php');

include('../core/config.php');
$dbconn = getConnection();

if ($_SESSION['idUser']) {

    //consultamos todos los cobros realizados por id de caja
    $sql = "SELECT * FROM cobros WHERE id_caja = '".$_SESSION['idCaja']."'";
    $stmt = $dbconn->prepare($sql);
    $stmt->execute();
    $cobros = $stmt->fetchAll();   

    // sumamos los cobros
    $totalCobros = 0;
    foreach ($cobros as $cobro) {
        $totalCobros += $cobro['monto'];
    }
    // insertamos los cobros en la tabla de apertura
    $sql = "INSERT INTO apertura_cierre (id_caja, fecha, monto_cobros, monto_efectivo, monto_tarjeta, monto_cheque, monto_deposito, monto_transferencia, monto_otros, monto_total) VALUES (:id_caja, :fecha, :monto_cobros, :monto_efectivo, :monto_tarjeta, :monto_cheque, :monto_deposito, :monto_transferencia, :monto_otros, :monto_total)";
    $stmt = $dbconn->prepare($sql);
    $stmt->bindParam(':id_caja', $_SESSION['idCaja']);
    $stmt->bindParam(':fecha', date('Y-m-d'));
    $stmt->bindParam(':monto_cobros', $totalCobros);
    $stmt->bindParam(':monto_efectivo', $_POST['monto_efectivo']);
    $stmt->bindParam(':monto_tarjeta', $_POST['monto_tarjeta']);
    $stmt->bindParam(':monto_cheque', $_POST['monto_cheque']);
    $stmt->bindParam(':monto_deposito', $_POST['monto_deposito']);
    $stmt->bindParam(':monto_transferencia', $_POST['monto_transferencia']);
    $stmt->bindParam(':monto_otros', $_POST['monto_otros']);
    $stmt->bindParam(':monto_total', $_POST['monto_total']);
    $stmt->execute();

    //realizamos un cierre de caja para el usuario
    $sql = "INSERT INTO cierre_caja (id_usuario, fecha_cierre, monto_cierre) 
    VALUES (".$_SESSION['idUser'].", NOW(), ".$_SESSION['monto_cierre'].")";
    $stmt = $dbconn->prepare($sql);
    $stmt->execute();



}else // NOT LOGGED
{
    print json_encode(array("status" => "error", "message" => "No autorizado"));
}
