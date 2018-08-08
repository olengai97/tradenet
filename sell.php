<?php

session_start();

require_once('includes/db_conn.php');
require_once('includes/sanitize.php');

if(isset($_SESSION['email'])){
	$email = $_SESSION['email'];
} else {
	header("Location: index.php");
	die();
}


if(isset($_POST["sell"])){
	$prod_name = $_POST['prod_name'];
	$prod_price = $_POST['prod_price'];
	$prod_img = $_FILES['prod_img']['name'];
	$prod_img_tmp = $_FILES['prod_img']['tmp_name'];

	$prod_name = sanitize($prod_name);
	$prod_price = sanitize($prod_price);
	$prod_img = sanitize($prod_img);

	$prod_name = mysqli_real_escape_string($conn, $prod_name);
	$prod_price = mysqli_real_escape_string($conn, $prod_price);
	$prod_img = mysqli_real_escape_string($conn, $prod_img);
	$email = mysqli_real_escape_string($conn, $email);

	if($prod_name == "" || $prod_price == ""){
		echo "<p class='msg'>Please fill out all fields</p>";
	} else if(!is_uploaded_file($prod_img_tmp)){
		echo "<p class='msg'>Image failed to upload</p>";
	} else {

		$prod_img = rand(100000000000,1000000000000) . ".jpg";
		move_uploaded_file($prod_img_tmp, "products/{$prod_img}") or die("Failed to move file");

		$sell = "INSERT INTO products (product_name, product_image, product_seller, product_price) VALUES ('{$prod_name}', '{$prod_img}', '{$email}', '{$prod_price}')";


		// echo $sell; die();

		$run_sell = mysqli_query($conn, $sell) or die("Failed run_sell");
		if($run_sell) echo "<p class='msg'>Product added successfully</p>";

		header("Refresh:3, url=products.php");
	}
}


?>
<!DOCTYPE html>
<html>
<head>
	<title>TradeNet</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/sell.css">
</head>
<body>
<?php include("includes/header.php"); ?>

<?php include("includes/aside.php"); ?>



<div id="main">
	<div id="prods">

	<form action="" method="post" enctype="multipart/form-data">
		<div id="form">
			<div id="hh1">Sell Your Product</div>
			<div id="log">
				<label>Product Name</label>
				<input class='input' type="text" name="prod_name" placeholder="Enter Your Product Name">
				<label>Price (in Tshs.)</label>
				<input class='input' type="number" name="prod_price" placeholder="Enter Your Product Price in Tshs">
				<label>Choose Product Image</label>
				<input type="file" name="prod_img" style="border-width: 0px;">
				</label>
				<input type="submit" name="sell" value="Sell">
			</div>
			<div id="sign">
			</div>	
		</div>
	</form>
</div>
</div>






</body>
</html>