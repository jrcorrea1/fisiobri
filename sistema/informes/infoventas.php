<?php
require('../../fpdf/fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
		$this->SetMargins(20, 0, 0);
    $this->Image('../img/logo.jpg',75,5,22);
		$this->SetFont('Arial', 'B', 20);
		$this->Cell(120,10, 'FISIOBRI', 0, 0, 'R');
    $this->SetFont('Arial', 'I', 7);
		$this->Cell(1, 20,"de Junior Alexander Correa", 0, 0, 'R');
		$this->Ln(20);
    // Movernos a la derecha
    $this->Cell(60);
    $this->SetFont('Arial', 'BU', 15);
    $this->Cell(70,10,'INFORME DE VENTAS ',0,0,'C');
    // Salto de línea
    $this->Ln(10);
    $this->SetFillColor(2,157,116);
    $this->SetFont('Arial', 'B', 10);
    $this->Cell(30,10,utf8_decode('N° DE FACT'),1,0,'C',1);
    $this->Cell(40,10,'FECHA DE VENTA',1,0,'C',1);
	  $this->Cell(25,10,'ID CLIENTE',1,0,'C',1);
	  $this->Cell(40,10,'IMPORTE TOTAL',1,1,'C',1);

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
$consulta = "SELECT * FROM FACTURA";
$resultado = mysqli_query($conexion, $consulta);

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);

while ($row=$resultado->fetch_assoc()) {
  $pdf->Cell(30,10,$row['nofactura'],1,0,'C');
	$pdf->Cell(40,10,$row['fecha'],1,0,'C');
	$pdf->Cell(25,10,$row['codcliente'],1,0,'C');
	$pdf->Cell(40,10,$row['totalfactura'],1,1,'C');
}


	$pdf->Output();
?>
