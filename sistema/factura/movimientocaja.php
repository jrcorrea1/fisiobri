<?php session_start(); ?>
<?php
if (!isset($_SESSION['idUser'])) {
	echo "No autorizado<br>";
	echo "<a href='./inicio.php'>Inciar sesion</a>";
	exit();
}
require_once 'fpdf/fpdf.php';
require_once '../core/CifrasEnLetras.php';
include('../core/config.php');
$dbconn = getConnection();


// GET variables
$idcaja = $_GET['caja'];

// Obtener datos de la caja
$sql = "SELECT * FROM apertura_cierre WHERE id_caja = :id_caja";
$stmt = $dbconn->prepare($sql);
$stmt->bindParam(':id_caja', $idcaja);
$stmt->execute();
$caja = $stmt->fetch(PDO::FETCH_ASSOC);
$fecha_apertura = empty($caja['fecha_apertura']) ? null : date("d/m/Y H:s", strtotime($caja['fecha_apertura']));
$fecha_cierre = empty($caja['fecha_cierre']) ? null : date("d/m/Y H:s", strtotime($caja['fecha_cierre']));

//Usuario
$stmt3 = $dbconn->prepare("SELECT * FROM usuario WHERE idusuario = :idusuario");
$stmt3->bindValue(":idusuario", $caja['usuario_id']);
$stmt3->execute();
$usuario = $stmt3->fetch(PDO::FETCH_ASSOC);

//configuracion
$stmt4 = $dbconn->prepare("SELECT * FROM configuracion");
$stmt4->execute();
$configuracion = $stmt4->fetch(PDO::FETCH_ASSOC);


$v=new CifrasEnLetras(); 
//Convertimos el total en letras
$letra=($v->convertirEurosEnLetras($caja['monto_cierre']));


$pdf = new FPDF('P', 'mm', array(80, 200));
$pdf->AddPage('portrait', 'a4');
$pdf->SetMargins(15, 0, 0);
$pdf->SetTitle("Caja");
$pdf->SetFont('Arial', 'I', 7);
$pdf->Cell(150, 5, utf8_decode("Elaborado por"), 0, 0, 'R');
$pdf->SetFont('Arial', 'BI', 7);
$pdf->Cell(30, 5, utf8_decode($configuracion['nombre']), 0, 1, 'C');
$pdf->image("img/logo.jpg", 68, 21, 30, 30, 'JPG');
$pdf->SetFont('Arial', 'B', 30);
$pdf->Cell(180, 45, 'FISIOBRI', 1, 0, 'L');
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(130, 12, utf8_decode("N° Caja: "), 0, 0, 'R');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(20, 12, $caja['id_caja'], 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(130, 6, "Fecha Apertura: ", 0, 0, 'R');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(35, 6, $fecha_apertura, 0, 1, 'R');
$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(130, 6, "Fecha Cierre:", 0, 0, 'R');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(35, 6, $fecha_cierre, 0, 1, 'R');


$pdf->Ln(15);


$pdf->SetFont('Arial', 'BU', 13);
$pdf->Cell(45, 10, utf8_decode("Usuario"), 0, 0, 'L');

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(30, 10, $usuario['nombre'], 0, 0, 'L');
$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(75, 10, "Detalle de Caja", 0, 1, 'L');
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(58, 152, 138);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(30, 10, 'Apertura', 1, 0, 'L', 1);
$pdf->Cell(40, 10, 'Efectivo', 1, 0, 'L', 1);
$pdf->Cell(40, 10, 'Tarjeta', 1, 0, 'L', 1);
$pdf->Cell(40, 10, 'Cheque', 1, 0, 'L', 1);
$pdf->Cell(30, 10, 'Cierre', 1, 1, 'L', 1);

$pdf->Cell(30, 10, $caja['monto_apertura'], 1, 0, 'L');
$pdf->Cell(40, 10, $caja['monto_efectivo'], 1, 0, 'L');
$pdf->Cell(40, 10, $caja['monto_tarjeta'], 1, 0, 'L');
$pdf->Cell(40, 10, $caja['monto_cheque'], 1, 0, 'L');
$pdf->Cell(30, 10, $caja['monto_cierre'] - $caja['monto_apertura'], 1,1, 'L');


$pdf->SetFont('Arial', '', 12);

$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(180, 10, 'Monto en letras: '.$letra, 1, 1, 'L', 1);
$pdf->Cell(180, 10, 'Total: ' . number_format($caja['monto_cierre'], 0, ',', '.'), 1, 1, 'R', 1);
$pdf->Ln();
$pdf->SetFont('Arial', '', 15);
$pdf->Cell(80, 10, utf8_decode("Gracias por su preferencia"), 0, 1, 'C');
$pdf->Output("movimientocaja.pdf", "I");


?>
