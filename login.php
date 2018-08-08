<?php

session_start();

require_once('includes/db_conn.php');
require_once('includes/sanitize.php');

if(isset($_SESSION['email'])){
	header("Location: products.php");
}
	if(isset($_POST['login'])){
		$email = $_POST['email'];
		$password = $_POST['password'];

		if(empty($email) || empty($password)){
			echo "<p class='msg'>Please fill out all fields</p>";
		} else {

			$email = sanitize($email) or die("fail");
			$password = sanitize($password);

			$email = mysqli_real_escape_string($conn, $email);
			$password = mysqli_real_escape_string($conn, $password);

			$pass = "SELECT * FROM members WHERE member_email='{$email}'";
			$run_pass = mysqli_query($conn, $pass) or die("Failed: run_pass");

			$num_pass = mysqli_num_rows($run_pass);

			if($num_pass == 1){

				$row_pass = mysqli_fetch_array($run_pass);
				$verified = $row_pass['member_verified'];
				$salt = $row_pass['member_salt'];
				$pass = $row_pass['member_password'];

				if($verified != "YES"){
					echo "<p class='msg'>Your account is not Activated.<br><br> Click on the link sent to your email during registration to Activate your Acount.<br><br><a href='index.php'>Go Back</a></p>";
				} else {

					$password = md5($salt . $password);

					if($pass != $password){
						echo "<p class='msg'>Wrong Username or Password</p>";
					} else {
						$_SESSION['email'] = $email;
						header("Location: products.php");
					}

				}

			} else {

				echo "<p class='msg'>Wrong email or password.</p>";
				
			}
		}

}
	





?>
<!DOCTYPE html>
<html>
<head>
	<title>TradeNet</title>
	<link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>



<div id="main">
	<form action="" method="post">
		<div id="form">
			<div id="h1">TradeNet Log In</div>
			<div id="log">
				<label>Email</label>
				<input type="text" name="email" placeholder="Enter Your Email">
				<label>Password</label>
				<input type="password" name="password" placeholder="Enter Your Password">
				<input type="submit" name="login" value="Log In">
			</div>
			<div id="sign">
				<a href="recover.php">Forgot Password?</a>
				<a href="signup.php" class="right">Sign Up</a>
				<a href="index.php" class="right" style="padding-right: 30px; display: inline-block;">HOME</a>
			</div>	
		</div>
	</form>
</div>


</body>
</html>