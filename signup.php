<?php

	// Import PHPMailer classes into the global namespace
	// These must be at the top of your script, not inside a function
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	//Load Composer's autoloader
	require 'vendor/autoload.php';

require_once('includes/db_conn.php');
require_once('includes/sanitize.php');

if(isset($_POST['signup'])){
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$cpassword = $_POST['cpassword'];
	$img_tmp = $_FILES['img']['tmp_name'];
	$img_type = $_FILES['img']['type'];

	$username = sanitize($username);
	$email = sanitize($email);
	$password = sanitize($password);
	$cpassword = sanitize($cpassword);
	$img = sanitize($img);

	if ( $username == "" or $email == "" or $password == "" or $cpassword == "") {
		echo "<p class='msg'>Please fill out all fields.</p>";
	} else if($password !== $cpassword){
		echo "<p class='msg'>Passwords do not match.</p>";
	} else if(!is_uploaded_file($img_tmp)){
		echo "<p class='msg'>Failed to upload file</p>";
	} else if($img_type != "image/png" && $img_type != "image/jpeg"){
		echo "<p class='msg'>Your image should be in JPEG or PNG format only.</p>";
	} else {
		//checking the existence of email
		$email_check = "SELECT * FROM members WHERE member_email='{$email}'";
		$run_email_check = mysqli_query($conn, $email_check) or die("Failed: run_email_check");
		$num_email_check = mysqli_num_rows($run_email_check);

		if($num_email_check != 0){
			echo "<p class='msg'>The email you provided is already in use. Choose another email<br></p>";
		} 


		//checking the existence of username
		$username_check = "SELECT * FROM members WHERE member_username='{$username}'";
		$run_username_check = mysqli_query($conn, $username_check) or die("Failed: run_username_check");
		$num_username_check = mysqli_num_rows($run_username_check);

		if($num_username_check != 0){
			echo "<p class='msg'>The username you provided is already  in use. Choose another username<br></p>";
		} else {

			$img = rand(100000000,1000000000).".jpg";
			move_uploaded_file($img_tmp, "images/{$img}") or die("Failed to move file");
			///Verification code
			$ver_code = rand(10000,100000);


			///Salt
			$salt = rand(10000000000, 100000000000);
			$password = md5($salt . $password);
			
			//INSERT QUERY

				$username = mysqli_real_escape_string($conn, $username);
				$email = mysqli_real_escape_string($conn, $email);
				$password = mysqli_real_escape_string($conn, $password);
				$salt = mysqli_real_escape_string($conn, $salt);
				$image = mysqli_real_escape_string($conn, $image);
				$ver_code = mysqli_real_escape_string($conn, $ver_code);

				$sql = "INSERT INTO members (member_username, member_email, member_password, member_salt, member_image, member_verified) VALUES ('{$username}', '{$email}', '{$password}', '{$salt}', '{$img}', '{$ver_code}')";

				$run_sql = mysqli_query($conn, $sql) or die("Failed to add user");
			//-------=============------------+++++++++++++
			
			//Sending the mail
			$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
			try {
			    //Server settings
			    // $mail->SMTPDebug = 2;                                 // Enable verbose debug output
			    $mail->isSMTP();                                      // Set mailer to use SMTP
			    $mail->Host = 'mail.atchosting.ac.tz';  // Specify main and backup SMTP servers
			    $mail->SMTPAuth = true;                               // Enable SMTP authentication
			    $mail->Username = 'olelaizer@atchosting.ac.tz';                 // SMTP username
			    $mail->Password = '29June1997';                           // SMTP password
			    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
			    $mail->Port = 465;                                    // TCP port to connect to

			    //Recipients
			    $mail->setFrom('olelaizer@atchosting.ac.tz', 'TradeNet');
			    $mail->addAddress($email);     // Add a recipient
			    // $mail->addAddress('ellen@example.com');               // Name is optional
			    // $mail->addReplyTo('info@example.com', 'Information');
			    // $mail->addCC('cc@example.com');
			    // $mail->addBCC('bcc@example.com');

			    // //Attachments
			    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
			    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

			    //Content
			    $mail->isHTML(true);                                  // Set email format to HTML
			    $mail->Subject = 'TradeNet Account Activation';
			    $mail->Body    = "Hi <b>{$username}</b>, <br><br>Click the link below to verify your account<br><br> <a href='https://atchosting.ac.tz/tradenet/activate.php?email={$email}&ver_code={$ver_code}'>Activate Your Account</a> <br><br>Thank you for choosing TradeNet";
			    $mail->AltBody = "Hi {$username}, Click the following link to verify your account https://atchosting.ac.tz/tradenet/activate.php?email={$email}&ver_code={$ver_code}";

			    $mail->send();
			    echo "<p class='msg'>A message has been set to your email. Click the link in it to activate your account <br><br><a href='index.php'>Go Back</a><br></p>";

					die();
					
			} catch (Exception $e) {
			    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
			    die("<br>Failed");
			} 

			//---------------------------------------------

			
		}





	}
}


?>
<!DOCTYPE html>
<html>
<head>
	<title>TradeNet</title>
	<link rel="stylesheet" type="text/css" href="css/signup.css">

</head>
<body>


<div id="main">
	<form action="" method="post" enctype="multipart/form-data">
		<div id="form">
			<div id="h1">TradeNet Sign Up</div>
			<div id="log">
				<label>Username</label>
				<input class='input' type="text" name="username" placeholder="Choose a Username">
				<label>Email</label>
				<input class='input' type="email" name="email" placeholder="Enter Your Email">
				<label>Password</label>
				<input class='input' type="password" name="password" placeholder="Choose Your Password">
				<label>Confirm Password</label>
				<input class='input' type="password" name="cpassword" placeholder="Re-enter Your Password">
				<label>Choose Profile Image</label>
				<input type="file" name="img" style="border-width: 0px;">
				</label>
				<input type="submit" name="signup" value="Sign Up">
			</div>
			<div id="sign">
				<a href="login.php" class="right">Log In</a>
			</div>	
		</div>
	</form>
</div>
	<script type="text/javascript">

	</script>

</body>
</html>