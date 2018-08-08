<?php 

require_once('includes/db_conn.php');
require_once('includes/sanitize.php');

include("includes/session_check.php");


if(isset($_GET['mem_id'])){
	$mem_id = $_GET['mem_id'];
	
	$mem_id = sanitize($mem_id);

	$mem_id = mysqli_real_escape_string($conn, $mem_id);


	//FETCH MEMBER EMAIL
	$mem_fetch = "SELECT * FROM members WHERE member_id={$mem_id}";
	$run_mem_fetch = mysqli_query($conn, $mem_fetch) or die("Failed: run_mem_fetch");
	$rw_mem_fetch = mysqli_fetch_array($run_mem_fetch);
	$mem_email = $rw_mem_fetch['member_email'];
	$img = $rw_mem_fetch['member_image'];

	$cart_rem = "DELETE FROM cart WHERE buyer='{$mem_email}'";
	$run_cart_rem = mysqli_query($conn, $cart_rem) or die("Failed: run_cart_rem");

	$product_rem = "DELETE FROM products WHERE product_seller='{$mem_email}'";
	$run_product_rem = mysqli_query($conn, $product_rem) or die("Failed: run_product_rem");


	$del = "DELETE FROM members WHERE member_id={$mem_id}";

	$run_del = mysqli_query($conn, $del) or die("Failed: run_del");

	unlink("images/{$img}") or die("failed to del img");

	header("Location: members.php");
}


?>