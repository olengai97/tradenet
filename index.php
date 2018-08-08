<?php

session_start();


if(isset($_SESSION['email'])){
	header("Location: products.php");
}
	

?>
<!DOCTYPE html>
<html>
<head>
	<title>TradeNet</title>
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<style type="text/css">
		#form {
			width: 100vw;
			height: 100vh;
			margin: 0 auto;
			border-radius: 0;
		}

		#h1 {
			border-radius: 0;
		}

		.btn {
			display: inline-block;
			padding: 20px 25px;
			background: #4d0066;
			color: #fff;
			font-size: 25px;
			transition: background 0.4s;
			border-radius: 5px;
			margin: 10px;
		}
		
		.btn:hover {
			background: #220055;
		}

		#log {
			display: flex;
		}

		.intros {
			display: inline-block;
			width:30%;
			font-size: 30px;
			padding: 20px;
			margin: 10px;
			color: #fff;
			border-radius: 0 30px 0 30px;
			line-height: 62px;
			background: #7300e6
		}
	</style>
</head>
<body>


<div id="main">
		<div id="form">
			<div id="h1">Welcome To TradeNet Online Market</div>
			<div id="log" style="min-height: 65vh; margin: auto; width: 80%; padding-top:30px;">
				<p class='intros'>Welcome to Tradenet. This is the only place to earn well with your products at hand.</p><br>
				<br>
				<p class='intros'>Buy and Sell Products for free without any transaction fee. We are here to help you.</p><br><br>

				<p class='intros'>Join our growing trading community and experience trade with people surrounding you.</p>
			</div>
			<div id="sign">
				<a href="signup.php" class="btn right">Sign Up</a>
				<a href="login.php" class="btn right">Log In</a>
			</div>	
		</div>
</div>


</body>
</html>