<?php
require('../../fpdf/fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{

    // Arial bold 15

		$this->SetMargins(20, 0, 0);
    $this->Image('../img/logo.jpg',110,5,22);
		$this->SetFont('Arial', 'B', 20);
		$this->Cell(160,10, 'FISIOBRI', 0, 0, 'R');
    $this->SetFont('Arial', 'I', 7);
		$this->Cell(1, 20,"de Junior Alexander Correa", 0, 0, 'R');
		$this->Ln(20);
    // Movernos a la derecha
    $this->Cell(60);
    $this->SetFont('Arial', 'BU', 15);
    $this->Cell(140,10,'INFORME DE VENTAS ',0,0,'C');
    // Salto de línea
    $this->Ln(10);
    $this->SetFillColor(2,157,116);
    $this->SetFont('Arial', 'B', 10);
		$this->Cell(10,10,'ID',1,0,'C',1);
    $this->Cell(20,10,utf8_decode('N° DE FACT'),1,0,'C',1);
    $this->Cell(45,10,'FECHA VENTA',1,0,'C',1);
	  $this->Cell(30,10,'ID CLIENTE',1,0,'C',1);
    $this->Cell(30,10,'IMPORTE',1,0,'C',1);
		$this->Cell(30,10,'METODO',1,0,'C',1);
    $this->Cell(20,10,'CHEQUE',1,0,'C',1);
    $this->Cell(20,10,'BANCO',1,1,'C',1);


}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,utf8_decode('Página') .$this->PageNo().'/{nb}',0,0,'C');
}
}

require ("../../conexion.php");
$consulta = "SELECT * FROM COBROS";
$resultado = mysqli_query($conexion, $consulta);

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('landscape','a4');
$pdf->SetFont('Arial','B',10);

while ($row=$resultado->fetch_assoc()) {
  $pdf->Cell(10,10,$row['id'],1,0,'C');
	$pdf->Cell(20,10,$row['factura'],1,0,'C');
	$pdf->Cell(45,10,$row['fecha'],1,0,'C');
	$pdf->Cell(30,10,$row['cliente'],1,0,'C');
  $pdf->Cell(30,10,$row['monto'],1,0,'C');
  $pdf->Cell(30,10,$row['formacobro'],1,0,'C');
	$pdf->Cell(20,10,$row['cheque'],1,0,'C');
  $pdf->Cell(20,10,$row['banco'],1,1,'C');
}


	$pdf->Output();
?>
