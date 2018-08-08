<?php

require_once('includes/db_conn.php');

include("includes/session_check.php");

$admn = "SELECT * FROM members WHERE member_email='{$email}'";
$run_admn = mysqli_query($conn, $admn) or die("Failed: run_admn");
$row_admn = mysqli_fetch_array($run_admn);
$member_status = $row_admn['member_status'];


if(isset($_GET['members'])){

	if($member_status != "admin"){
		header("Location: posts.php");
	}
	require("fpdf/fpdf.php");

	class PDF extends FPDF{

		function Header(){
			$this->SetFont("Times", "BU", 22);
			$this->Cell(0, 10, "TRADENET MEMBERS REPORT", 0, 1, "C");
			$this->Ln();
		}

		function Footer(){
			$this->SetY(-15);
			$this->Cell(0, 10, $this->PageNo(), 0, 1, "C");
		}
		
	}

	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont("Times", "", 16);
	$pdf->Cell(0, 10, "This is a report of members registered in the network", 0, 1, "L");
	$pdf->SetFont("Times", "B", 16);
	$pdf->Cell(20, 10, "SNO", 1, 0);
	$pdf->Cell(100.66, 10, "Email", 1, 0);
	$pdf->Cell(36.33, 10, "Status", 1, 0);
	$pdf->Cell(33.33, 10, "Verified", 1, 0);
	$pdf->Ln();

$sql = "SELECT * FROM members";
$run = mysqli_query($conn, $sql) or die();
$i = 1;

while($rw = mysqli_fetch_array($run)){

	$email = $rw['member_email'];
	$status = $rw['member_status'];

	if($status == "admin") {
		$status = "Admin";
	} else {
		$status = "User";
	}
	
	$verified = $rw['member_verified'];

	if($member_verified == "YES") {
		$member_verified = "Admin";
	} else {
		$member_verified = "NO";
	}

	$pdf->SetFont("Times", "", 16);
	$pdf->Cell(20, 10, $i, 1, 0);
	$pdf->Cell(100.66, 10, $email, 1, 0);
	$pdf->Cell(36.33, 10, $status, 1, 0);
	$pdf->Cell(33.33, 10, $verified, 1, 0);
	$pdf->Ln();

	$i++;
}

	$pdf->Output();
}

if(isset($_GET['products'])){

	if($member_status != "admin"){
		header("Location: posts.php");
	}

	require("fpdf/fpdf.php");

	class PDF extends FPDF{

		function Header(){
			$this->SetFont("Times", "BU", 22);
			$this->Cell(0, 10, "TRADENET PRODUCTS REPORT", 0, 1, "C");
			$this->Ln();
		}

		function Footer(){
			$this->SetY(-15);
			$this->Cell(0, 10, $this->PageNo(), 0, 1, "C");
		}
		
	}

	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont("Times", "", 16);
	$pdf->Cell(0, 10, "This is a report of products submitted by all users", 0, 1, "L");
	$pdf->SetFont("Times", "B", 16);
	$pdf->Cell(15, 10, "SNO", 1, 0);
	$pdf->Cell(37.33, 10, "Product", 1, 0);
	$pdf->Cell(36.33, 10, "Price(Tshs)", 1, 0);
	$pdf->Cell(68.33, 10, "Seller", 1, 0);
	$pdf->Cell(33.33, 10, "Status", 1, 0);
	$pdf->Ln();

$sql = "SELECT * FROM products";
$run = mysqli_query($conn, $sql) or die();
$i = 1;

while($rw = mysqli_fetch_array($run)){

	$name = $rw['product_name'];
	$price = $rw['product_price'];
	$seller = $rw['product_seller'];
	$status = $rw['product_status'];

	if($status == "sold") {
		$status = "SOLD";
	} else {
		$status = "NOT SOLD";
	}

	$pdf->SetFont("Times", "", 14);
	$pdf->Cell(15, 10, $i, 1, 0);
	$pdf->Cell(37.33, 10, $name, 1, 0);
	$pdf->Cell(36.33, 10, $price ."/=", 1, 0);
	$pdf->Cell(68.33, 10, $seller, 1, 0);
	$pdf->Cell(33.33, 10, $status, 1, 0);
	$pdf->Ln();

	$i++;
}

	$pdf->Output();
}if(isset($_GET['self_products'])){

	require("fpdf/fpdf.php");

	class PDF extends FPDF{

		function Header(){
			$this->SetFont("Times", "BU", 22);
			$this->Cell(0, 10, "YOUR TRADENET PRODUCTS REPORT", 0, 1, "C");
			$this->Ln();
		}

		function Footer(){
			$this->SetY(-15);
			$this->Cell(0, 10, $this->PageNo(), 0, 1, "C");
		}
		
	}

	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont("Times", "B", 16);
	$pdf->Cell(0, 10, "Products Report for: $email", 0, 1, "L");
	$pdf->SetFont("Times", "", 16);
	$pdf->Cell(0, 10, "This is a report of all products that you submitted", 0, 1, "L");
	$pdf->SetFont("Times", "B", 16);
	$pdf->Cell(23, 10, "SNO", 1, 0);
	$pdf->Cell(57.33, 10, "Product", 1, 0);
	$pdf->Cell(56.33, 10, "Price(Tshs)", 1, 0);
	$pdf->Cell(53.33, 10, "Status", 1, 0);
	$pdf->Ln();

$sql = "SELECT * FROM products WHERE product_seller='$email'";
$run = mysqli_query($conn, $sql) or die();
$i = 1;

while($rw = mysqli_fetch_array($run)){

	$name = $rw['product_name'];
	$price = $rw['product_price'];
	$seller = $rw['product_seller'];
	$status = $rw['product_status'];

	if($status == "sold") {
		$status = "SOLD";
	} else {
		$status = "NOT SOLD";
	}

	$pdf->SetFont("Times", "", 14);
	$pdf->Cell(23, 10, $i, 1, 0);
	$pdf->Cell(57.33, 10, $name, 1, 0);
	$pdf->Cell(56.33, 10, $price ."/=", 1, 0);
	$pdf->Cell(53.33, 10, $status, 1, 0);
	$pdf->Ln();

	$i++;
}

	$pdf->Output();
}


if(isset($_GET['cart'])){

	if($member_status != "admin"){
		header("Location: posts.php");
	}

	require("fpdf/fpdf.php");

	class PDF extends FPDF{

		function Header(){
			$this->SetFont("Times", "BU", 22);
			$this->Cell(0, 10, "TRADENET CARTS REPORT", 0, 1, "C");
			$this->Ln();
		}

		function Footer(){
			$this->SetY(-15);
			$this->Cell(0, 10, $this->PageNo(), 0, 1, "C");
		}
		
	}

	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont("Times", "", 16);
	$pdf->Cell(0, 10, "This is a report of all products in the carts of all users", 0, 1, "L");
	$pdf->SetFont("Times", "B", 12);
	$pdf->Cell(15, 10, "SNO", 1, 0);
	$pdf->Cell(37.33, 10, "Product", 1, 0);
	$pdf->Cell(29.33, 10, "Price(Tsh)", 1, 0);
	$pdf->Cell(54.33, 10, "Seller", 1, 0);
	$pdf->Cell(54.33, 10, "Ordered By", 1, 0);
	$pdf->Ln();

$sql = "SELECT * FROM cart";
$run = mysqli_query($conn, $sql) or die();
$i = 1;

while($rw = mysqli_fetch_array($run)){
	$cart_prod_id = $rw['product_id'];
	$ordered = $rw['buyer'];

	$prod_sql = "SELECT * FROM products WHERE product_id={$cart_prod_id}";
	$run_prod = mysqli_query($conn, $prod_sql);
	$rw_prod = mysqli_fetch_array($run_prod);
	$name = $rw_prod['product_name'];
	$price = $rw_prod['product_price'];
	$seller = $rw_prod['product_seller'];

	

	$pdf->SetFont("Times", "", 12);
	$pdf->Cell(15, 10, $i, 1, 0);
	$pdf->Cell(37.33, 10, $name, 1, 0);
	$pdf->Cell(29.33, 10, $price. "/=", 1, 0);
	$pdf->Cell(54.33, 10, $seller, 1, 0);
	$pdf->Cell(54.33, 10, $ordered, 1, 0);
	$pdf->Ln();

	$i++;
}

	$pdf->Output();
}

if(isset($_GET['self_cart'])){
	require("fpdf/fpdf.php");

	class PDF extends FPDF{

		function Header(){
			$this->SetFont("Times", "BU", 22);
			$this->Cell(0, 10, "YOUR TRADENET CART REPORT", 0, 1, "C");
			$this->Ln();
		}

		function Footer(){
			$this->SetY(-15);
			$this->Cell(0, 10, $this->PageNo(), 0, 1, "C");
		}
		
	}

	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont("Times", "B", 16);
	$pdf->Cell(0, 10, "Cart Report for: $email", 0, 1, "L");
	$pdf->SetFont("Times", "", 16);
	$pdf->Cell(0, 10, "This is a report of all products in your cart", 0, 1, "L");
	$pdf->SetFont("Times", "B", 12);
	$pdf->Cell(15.33, 10, "SNO", 1, 0);
	$pdf->Cell(57.33, 10, "Product", 1, 0);
	$pdf->Cell(43.33, 10, "Price(Tsh)", 1, 0);
	$pdf->Cell(74.33, 10, "Seller", 1, 0);
	$pdf->Ln();

$sql = "SELECT * FROM cart WHERE buyer='$email'";
$run = mysqli_query($conn, $sql) or die();
$i = 1;
$total_price = 0;

while($rw = mysqli_fetch_array($run)){
	$cart_prod_id = $rw['product_id'];
	$ordered = $rw['buyer'];

	$prod_sql = "SELECT * FROM products WHERE product_id={$cart_prod_id}";
	$run_prod = mysqli_query($conn, $prod_sql);
	$rw_prod = mysqli_fetch_array($run_prod);
	$name = $rw_prod['product_name'];
	$price = $rw_prod['product_price'];
	$seller = $rw_prod['product_seller'];

	$price = (int)$price;
	$total_price = $total_price + $price;

	

	$pdf->SetFont("Times", "", 12);
	$pdf->Cell(15.33, 10, $i, 1, 0);
	$pdf->Cell(57.33, 10, $name, 1, 0);
	$pdf->Cell(43.33, 10, $price. "/=", 1, 0);
	$pdf->Cell(74.33, 10, $seller, 1, 0);
	$pdf->Ln();

	$i++;
}

	$pdf->SetFont("Times", "B", 12);
	$pdf->Cell(15.33, 10, "", 1, 0);
	$pdf->Cell(57.33, 10, "Total", 1, 0);
	$pdf->Cell(43.33, 10, "{$total_price}/=", 1, 0);
	$pdf->Cell(74.33, 10, "", 1, 0);
	$pdf->Ln();

	$pdf->Output();
}



?>
<!DOCTYPE html>
<html>
<head>
	<title>TradeNet</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<style type="text/css">
		#prods a{ display: inline-block; width: 600px; padding: 30px 20px; border: 1px solid #bf00ff; margin: 10px; background: #e699ff; box-shadow: 0px 0px 2px #ccc; transition:  0.2s; }
		#prods a:hover{ padding-left: 30px; background: #f955ff; }
	</style>
</head>
<body>

<?php include("includes/header.php"); ?>

<?php include("includes/aside.php"); ?>

<div id="main">
	<div id="heading"><h1>Reports</h1></div>
	<div id="prods">
		<a target="_blank" href="?products=true">Products</a>
		<a target="_blank" href="?members=true">Members</a>
		<a target="_blank" href="?cart=true">Cart</a>
	</div>

</div>

</body>
</html>