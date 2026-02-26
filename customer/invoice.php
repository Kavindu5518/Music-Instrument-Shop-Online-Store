<?php
include 'includes/db.php';
require 'includes/fpdf.php';

if(!isset($_GET['order_id'])) die("Invalid order");

$order_id = $_GET['order_id'];

$order = mysqli_fetch_assoc(mysqli_query($conn,"
  SELECT o.*, u.name 
  FROM orders o 
  JOIN users u ON o.user_id=u.user_id 
  WHERE o.order_id=$order_id
"));

$items = mysqli_query($conn,"
  SELECT p.name, oi.quantity, oi.price
  FROM order_items oi
  JOIN products p ON oi.product_id=p.product_id
  WHERE oi.order_id=$order_id
");

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont("Arial","B",16);
$pdf->Cell(0,10,"Melody Masters Invoice",0,1);

$pdf->SetFont("Arial","",12);
$pdf->Cell(0,8,"Customer: ".$order['name'],0,1);
$pdf->Cell(0,8,"Order ID: ".$order_id,0,1);
$pdf->Ln(5);

$pdf->SetFont("Arial","B",12);
$pdf->Cell(80,8,"Product",1);
$pdf->Cell(30,8,"Qty",1);
$pdf->Cell(40,8,"Price",1);
$pdf->Ln();

$pdf->SetFont("Arial","",12);
while($i=mysqli_fetch_assoc($items)){
  $pdf->Cell(80,8,$i['name'],1);
  $pdf->Cell(30,8,$i['quantity'],1);
  $pdf->Cell(40,8,"£".$i['price'],1);
  $pdf->Ln();
}

$pdf->Ln(5);
$pdf->Cell(0,8,"Total: £".$order['total'],0,1);

$pdf->Output();
