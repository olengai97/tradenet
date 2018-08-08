<?php

require_once('includes/db_conn.php');
require_once('includes/sanitize.php');


if(isset($_GET['ver_code'])){
	$ver_code = $_GET['ver_code'];
	$email = $_GET['email'];

	$ver_code = sanitize($ver_code);
	$email = sanitize($email);

	$ver_code = mysqli_real_escape_string($conn, $ver_code);
	$email = mysqli_real_escape_string($conn, $email);

	$sql = "UPDATE members SET member_verified='YES' WHERE member_email='{$email}' AND member_verified='{$ver_code}'";

	$run = mysqli_query($conn, $sql) or die("Failed to activate email". mysqli_error($conn));

	session_start();

	$_SESSION['email'] = $email;

	header("Location: products.php");

} else {
	header("Location: index.php");
}

?>