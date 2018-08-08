<?php

require_once('includes/db_conn.php');
require_once('includes/sanitize.php');

include("includes/session_check.php");


if(isset($_POST['chpass'])){

	$curr_pass = $_POST['curr_pass'];
	$new_pass = $_POST['new_pass'];
	$cnew_pass = $_POST['cnew_pass'];

	$curr_pass = sanitize($curr_pass);
	$new_pass = sanitize($new_pass);
	$cnew_pass = sanitize($cnew_pass);

	if($curr_pass == "" || $new_pass == "" || $cnew_pass == ""){
		echo "<p class='msg'>Please fill out all fields</p>";
	} else if($new_pass != $cnew_pass){
		echo "<p class='msg'>The new passwords do not match</p>";
	} else {

		$email = mysqli_real_escape_string($conn, $email);

		$chpass = "SELECT * FROM members WHERE member_email='{$email}'";
		$run_chpass = mysqli_query($conn, $chpass) or die("Failed: run_chpass");
		$row_chpass = mysqli_fetch_array($run_chpass);

		$curr_password = $row_chpass['member_password'];
		$salt = $row_chpass['member_salt'];



		$curr_pass = md5($salt . $curr_pass);


		if($curr_password != $curr_pass) {
			echo "<p class='msg'>The password you entered is incorrect</p>";
		} else {

			$new_pass = md5($salt . $new_pass);

			$email = mysqli_real_escape_string($conn, $email);
			$new_pass = mysqli_real_escape_string($conn, $new_pass);

			$pass_up = "UPDATE members SET member_password='{$new_pass}' WHERE member_email='{$email}'";
			$run_pass_up = mysqli_query($conn, $pass_up) or die("Failed run_pass_up");
			echo "<p class='msg'>Password changed successfully</p>";

			header("Refresh:5, url=products.php");
		}

		
		
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

	<form action="" method="post">
		<div id="form">
			<div id="hh1">Change Your Password</div>
			<div id="log">
				<label>Current Password</label>
				<input class='input' type="password" name="curr_pass" placeholder="Enter Your Current Password">
				<label>New Password</label>
				<input class='input' type="password" name="new_pass" placeholder="Enter New Password">
				<label>Confirm New Password</label>
				<input class='input' type="password" name="cnew_pass" placeholder="Confirm Your New Password">
				<input type="submit" name="chpass" value="Change Password">
			</div>
			<div id="sign">
			</div>	
		</div>
	</form>
</div>
</div>






</body>
</html>