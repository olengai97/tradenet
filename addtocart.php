<?php

require_once('includes/db_conn.php');
require_once('includes/sanitize.php');

include("includes/session_check.php");

if(isset($_GET['prod_id'])){
	$prod_id = $_GET['prod_id'];
	
	$prod_id = sanitize($prod_id);

	$prod_id = mysqli_real_escape_string($conn, $prod_id);

	$check_cart = "SELECT * FROM cart WHERE product_id={$prod_id} and buyer='{$email}'";
	$run_check_cart = mysqli_query($conn, $check_cart) or die("Failed: run_check_cart");

	$num_check_cart = mysqli_num_rows($run_check_cart);

	$email = mysqli_real_escape_string($conn, $email);

	if($num_check_cart == 1){
		header("Location: products.php");
	} else {

		$cart = "INSERT INTO cart (buyer, product_id) VALUES ('{$email}', {$prod_id})";
		$run_cart = mysqli_query($conn, $cart) or die("Failed: run_cart");

		header("Location: products.php");
	}
}


?>