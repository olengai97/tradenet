<?php

require_once('includes/db_conn.php');
require_once('includes/sanitize.php');

include("includes/session_check.php");

if(isset($_GET['prod_id'])){
	$prod_id = $_GET['prod_id'];
	
	$prod_id = sanitize($prod_id);



	$prod_id = mysqli_real_escape_string($conn, $prod_id);

	$email = mysqli_real_escape_string($conn, $email);

	$remove = "DELETE FROM cart WHERE product_id={$prod_id} AND buyer='{$email}'";

	$run_remove = mysqli_query($conn, $remove) or die("Failed: run_remove");

	header("Location: cart.php");
}


?>