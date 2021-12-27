<?php
	session_start();
	if(empty($_SESSION['active']))
	{
		header('location: ../');
	}
	include "../../conexion.php";
	
	if(empty($_REQUEST['cl']) || empty($_REQUEST['f']))
	{
		echo "No es posible generar la factura.";
	}else{
		$codCliente = $_REQUEST['cl'];
		$noFactura = $_REQUEST['f'];
		$consulta = mysqli_query($conexion, "SELECT * FROM configuracion");
		$resultado = mysqli_fetch_assoc($consulta);
		$ventas = mysqli_query($conexion, "SELECT * FROM factura WHERE nofactura = $noFactura");
		$result_venta = mysqli_fetch_assoc($ventas);
		$clientes = mysqli_query($conexion, "SELECT * FROM cliente WHERE idcliente = $codCliente");
		$result_cliente = mysqli_fetch_assoc($clientes);
		$productos = mysqli_query($conexion, "SELECT d.nofactura, d.codproducto, d.cantidad, p.codproducto, p.descripcion, p.precio FROM detallefactura d INNER JOIN producto p ON d.nofactura = $noFactura WHERE d.codproducto = p.codproducto");
		require_once 'fpdf/fpdf.php';
		require_once "../core/CifrasEnLetras.php";
		$v=new CifrasEnLetras();
		//Convertimos el total en letras
		$letra=($v->convertirEurosEnLetras($result_venta['totalfactura']));
		
		$pdf = new FPDF('P', 'mm', array(80, 200));
		$pdf->AddPage('portrait','a4');
		$pdf->SetMargins(15, 0, 0);
		$pdf->SetTitle("Ventas");
		$pdf->SetFont('Arial', 'I', 7);
		$pdf->Cell(150, 5,utf8_decode("Elaborado por"), 0, 0, 'R');
		$pdf->SetFont('Arial', 'BI', 7);
		$pdf->Cell(30, 5, utf8_decode($resultado['nombre']), 0, 1, 'C');
		$pdf->image("img/logo.jpg", 68, 21, 30, 30, 'JPG');
		$pdf->SetFont('Arial', 'B', 30);
		$pdf->Cell(180, 45, 'FISIOBRI', 1, 0, 'L');
		$pdf->Ln(10);
		$pdf->SetFont('Arial', 'B', 13);
		$pdf->Cell(130, 12,utf8_decode("N° Factura: "), 0, 0, 'R');
		$pdf->SetFont('Arial', 'B', 12);
		$pdf->Cell(20, 12, $noFactura, 0, 1, 'L');
		$pdf->SetFont('Arial', 'B', 13);
		$pdf->Cell(130, 6, "Ruc: ", 0, 0, 'R');
		$pdf->SetFont('Arial', '', 12);
		$pdf->Cell(30, 6, $resultado['dni'], 0, 1, 'R');
		$pdf->SetFont('Arial', 'B', 13);
		$pdf->Cell(130, 6, utf8_decode("Teléfono: "), 0, 0, 'R');
		$pdf->SetFont('Arial', '', 12);
		$pdf->Cell(30, 6, $resultado['telefono'], 0, 1, 'R');
		$pdf->SetFont('Arial', 'B', 13);
		$pdf->Cell(130, 6, utf8_decode("Dirección: "), 0, 0, 'R');
		$pdf->SetFont('Arial', '', 12);
		$pdf->Cell(32, 6, utf8_decode($resultado['direccion']), 0, 1, 'R');
		$pdf->Ln(10);
		$pdf->SetFont('Arial', 'B', 13);
		$pdf->Cell(50, 10, "Fecha de Emision: ", 0, 0, 'L');
		$pdf->SetFont('Arial', '', 12);
		$fecha_venta = date("d/m/Y", strtotime($result_venta['fecha']));
		$pdf->Cell(50, 10, $fecha_venta, 0, 1, 'L');
		$pdf->SetFont('Arial', 'BU', 13);
		$pdf->Cell(85, 10, "Nombre completo", 0, 0, 'L');
		$pdf->Cell(30, 10, "Ruc", 0, 0, 'L');
		$pdf->Cell(30, 10, utf8_decode("Teléfono"), 0, 1, 'L');
		$pdf->SetFont('Arial', '', 12);
		$pdf->Cell(85, 10, utf8_decode($result_cliente['nombre'].$result_cliente['apellido']), 0, 0, 'L');
		$pdf->Cell(30, 10, utf8_decode($result_cliente['dni']), 0, 0, 'L');
		$pdf->Cell(30, 10, utf8_decode($result_cliente['telefono']), 0, 1, 'L');
		$pdf->SetFont('Arial', 'BU', 13);
		$pdf->Cell(45, 10, utf8_decode("Ciudad"), 0, 0, 'L');
		$pdf->Cell(70, 10, utf8_decode("Dirección"), 0, 1, 'L');
		$pdf->SetFont('Arial', '', 12);
		$pdf->Cell(45, 10, utf8_decode($result_cliente['ciudad']), 0, 0, 'L');
		$pdf->Cell(70, 10, utf8_decode($result_cliente['direccion']), 0, 1, 'L');

		$pdf->SetFont('Arial', 'B', 14);
		$pdf->Cell(75, 10, "Detalle de Ventas", 0, 1, 'L');
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetFillColor(58, 152, 138);
		$pdf->SetFont('Arial', 'B', 12);
		$pdf->Cell(14, 10, 'Cant', 1, 0, 'L',1);
		$pdf->Cell(70, 10, 'Descripcion', 1, 0, 'L',1);
		$pdf->Cell(26, 10, 'Precio Unit', 1, 0, 'L',1);
		$pdf->Cell(20, 10, 'Exent.', 1, 0, 'L',1);
		$pdf->Cell(20, 10, 'Iva5', 1, 0, 'L',1);
		$pdf->Cell(28, 10, 'Iva10', 1, 1, 'L',1);
		$pdf->SetFont('Arial', '', 12);
		while ($row = mysqli_fetch_assoc($productos)) {
			$pdf->Cell(14, 10, $row['cantidad'], 1, 0, 'L');
			$pdf->Cell(70, 10, utf8_decode($row['descripcion']), 1, 0, 'L');
			$pdf->Cell(26, 10, number_format($row['precio'], 2, '.', ','), 1, 0, 'L');
			$pdf->Cell(20, 10,'   -   ', 1, 0, 'L');
			$pdf->Cell(20, 10,'   -   ', 1, 0, 'L');
			$importe = number_format($row['cantidad'] * $row['precio'], 2, '.', ',');
			$pdf->Cell(28, 10, $importe, 1, 1, 'L');
		}
		
		$pdf->SetFont('Arial', 'B', 13);
		$pdf->Cell(178, 10, 'Monto en letras: '.$letra, 1, 1, 'L',1);
		$pdf->Cell(178, 10, 'Total: ' . number_format($result_venta['totalfactura'], 2, '.', ','), 1, 1, 'R',1);
		$pdf->Ln();
		$pdf->SetFont('Arial', '', 15);
		$pdf->Cell(80, 10, utf8_decode("Gracias por su preferencia"), 0, 1, 'C');
		$pdf->Output("compra.pdf", "I");
		}
