<?php session_start(); ?>
<?php
if (!isset($_SESSION['idUser'])) {
	echo "No autorizado<br>";
	echo "<a href='./inicio.php'>Inciar sesion</a>";
	exit();
}
require_once 'fpdf/fpdf.php';
include('../core/connection.php');
$dbconn = getConnection();


// GET variables
$idcaja = $_GET['caja'];

// Obtener datos de la caja
$sql = "SELECT * FROM apertura_cierre WHERE id_caja = :id_caja";
$stmt = $dbconn->prepare($sql);
$stmt->bindParam(':id_caja', $idcaja);
$stmt->execute();
$caja = $stmt->fetch(PDO::FETCH_ASSOC);

//Usuario
$stmt3 = $dbconn->prepare("SELECT * FROM usuario WHERE idusuario = :idusuario");
$stmt3->bindValue(":idusuario", $caja['usuario_id']);
$stmt3->execute();
$usuario = $stmt3->fetch(PDO::FETCH_ASSOC);





$pdf = new FPDF('P', 'mm', array(80, 200));
$pdf->AddPage('portrait', 'a4');
$pdf->SetMargins(15, 0, 0);
$pdf->SetTitle("Ventas");
$pdf->SetFont('Arial', 'I', 7);
$pdf->Cell(150, 5, utf8_decode("Elaborado por"), 0, 0, 'R');
$pdf->SetFont('Arial', 'BI', 7);
$pdf->Cell(30, 5, utf8_decode("sd"), 0, 1, 'C');
$pdf->image("img/logo.jpg", 68, 21, 30, 30, 'JPG');
$pdf->SetFont('Arial', 'B', 30);
$pdf->Cell(180, 45, 'FISIOBRI', 1, 0, 'L');
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(130, 12, utf8_decode("N° Caja: "), 0, 0, 'R');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 12,"asd", 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(130, 6, "Ruc: ", 0, 0, 'R');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(30, 6, 0, 0, 1, 'R');
$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(130, 6, utf8_decode("Teléfono: "), 0, 0, 'R');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(30, 6, 0, 0, 1, 'R');
$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(130, 6, utf8_decode("Dirección: "), 0, 0, 'R');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(32, 6, utf8_decode(0), 0, 1, 'R');
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(50, 10, "Fecha de Emision: ", 0, 0, 'L');
$pdf->SetFont('Arial', '', 12);
$fecha_venta = date("d/m/Y", strtotime(1991-05-01));
$pdf->Cell(50, 10, $fecha_venta, 0, 1, 'L');
$pdf->SetFont('Arial', 'BU', 13);
$pdf->Cell(85, 10, "Nombre completo", 0, 0, 'L');
$pdf->Cell(30, 10, "Ruc", 0, 0, 'L');
$pdf->Cell(30, 10, utf8_decode("Teléfono"), 0, 1, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(85, 10, utf8_decode("ddd"), 0, 0, 'L');
$pdf->Cell(30, 10, utf8_decode("dd"), 0, 0, 'L');
$pdf->Cell(30, 10, utf8_decode("sddfas"), 0, 1, 'L');
$pdf->SetFont('Arial', 'BU', 13);
$pdf->Cell(45, 10, utf8_decode("Ciudad"), 0, 0, 'L');
$pdf->Cell(70, 10, utf8_decode("Dirección"), 0, 1, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(45, 10, utf8_decode("s"), 0, 0, 'L');
$pdf->Cell(70, 10, utf8_decode("s"), 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(75, 10, "Detalle de Ventas", 0, 1, 'L');
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(58, 152, 138);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(14, 10, 'Cant', 1, 0, 'L', 1);
$pdf->Cell(70, 10, 'Descripcion', 1, 0, 'L', 1);
$pdf->Cell(26, 10, 'Precio Unit', 1, 0, 'L', 1);
$pdf->Cell(20, 10, 'Exent.', 1, 0, 'L', 1);
$pdf->Cell(20, 10, 'Iva5', 1, 0, 'L', 1);
$pdf->Cell(28, 10, 'Iva10', 1, 1, 'L', 1);
$pdf->SetFont('Arial', '', 12);
/*while ($row = mysqli_fetch_assoc($productos)) {
	$pdf->Cell(14, 10, $row['cantidad'], 1, 0, 'L');
	$pdf->Cell(70, 10, utf8_decode($row['descripcion']), 1, 0, 'L');
	$pdf->Cell(26, 10, number_format($row['precio'], 2, '.', ','), 1, 0, 'L');
	$pdf->Cell(20, 10, '   -   ', 1, 0, 'L');
	$pdf->Cell(20, 10, '   -   ', 1, 0, 'L');
	$importe = number_format($row['cantidad'] * $row['precio'], 2, '.', ',');
	$pdf->Cell(28, 10, $importe, 1, 1, 'L');
}*/
$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(178, 10, 'Monto en letras: ', 1, 1, 'L', 1);
$pdf->Cell(178, 10, 'Total: ' . number_format("s", 2, '.', ','), 1, 1, 'R', 1);
$pdf->Ln();
$pdf->SetFont('Arial', '', 15);
$pdf->Cell(80, 10, utf8_decode("Gracias por su preferencia"), 0, 1, 'C');
$pdf->Output("movimientocaja.pdf", "I");


?>
