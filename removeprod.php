<?php

require_once('includes/db_conn.php');
require_once('includes/sanitize.php');

include("includes/session_check.php");

if(isset($_GET['prod_id'])){
	$prod_id = $_GET['prod_id'];
	
	$prod_id = sanitize($prod_id);

	$prod_id = mysqli_real_escape_string($conn, $prod_id);
	$email = mysqli_real_escape_string($conn, $email);

	$sel = "SELECT * FROM products WHERE product_id={$prod_id}";
	$run_sel = mysqli_query($conn, $sel);
	$rw_sel = mysqli_fetch_array($run_sel);
	$img = $rw_sel['product_image'];

	$remove = "DELETE FROM products WHERE product_id={$prod_id} AND product_seller='{$email}'";

	$run_remove = mysqli_query($conn, $remove) or die("Failed: run_remove");

	//HERE THE PRODUCT SHOULD ALSO BE REMOVED FROM THE CART LIST
	
	$remove_c = "DELETE FROM cart WHERE product_id={$prod_id}";

	$run_remove_c = mysqli_query($conn, $remove_c) or die("Failed: run_remove_c");


	//------------->>>>>>>>><<<<<<<<<<--------------

	unlink("products/$img") or die("Failed to del img");

	header("Location: myproducts.php");
}


?>