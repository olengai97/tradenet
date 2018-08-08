<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require_once('includes/db_conn.php');

require_once('includes/sanitize.php');
//AFTER PASSWORD CHANGE
if(isset($_POST['set_new_pass'])){
	$rec_email = $_POST['rec_email'];
	$rec_code = $_POST['rec_code'];
	$new_password = $_POST['new_password'];
	$cnew_password = $_POST['cnew_password'];

	$rec_email = sanitize($rec_email);
	$rec_code = sanitize($rec_code);
	$new_password = sanitize($new_password);
	$cnew_password = sanitize($cnew_password);

	if($new_password == "" || $cnew_password == ""){
		echo "Please fill out all fields";
		$recover_now = true;
	} else if($new_password != $cnew_password){
		echo "The passwords do not match";
		$recover_now = true;
	} else {



		$rec_email = mysqli_real_escape_string($conn, $rec_email);
		$rec_code = mysqli_real_escape_string($conn, $rec_code);

		$recovery = "SELECT * FROM members WHERE member_email='{$rec_email}' AND member_recover='{$rec_code}'";

		$run_recovery = mysqli_query($conn, $recovery) or die("failed: run_recovery");

		$num_recovery = mysqli_num_rows($run_recovery);

		if($num_recovery == 0) {
			echo "Wrong details provided";
		} else {
			$row_recovery = (mysqli_fetch_array($run_recovery));
			$salt = $row_recovery['member_salt'];

			$new_password = md5($salt . $new_password);

			$new_password = mysqli_real_escape_string($conn, $new_password);

			$sql_recover = "UPDATE members SET member_password='{$new_password}', member_recover=NULL WHERE member_email='{$rec_email}' AND member_recover='{$rec_code}'";
			// echo $sql_recover; die();
			$run_sql_recover = mysqli_query($conn, $sql_recover) or die("Failed: run_sql_recover " . mysqli_error($conn));

			session_start();

			$_SESSION['email'] = $rec_email;

			header("Location: products.php");
			die();
		}
	}
}

//AFTER SUBMITTING AN EMAIL WHOSE PASSWORD IS TO BE CHANGED
if(isset($_POST['recover'])){
	$email = $_POST['email'];

	$email = sanitize($email);

	if (empty($email)) {
		echo "Please fill your Email.";

	} else {

		//Load Composer's autoloader
		require 'vendor/autoload.php';

		$recover_code = rand(100000, 999999);

			//INSERT QUERY

		
			$rec = "UPDATE members SET member_recover='{$recover_code}' WHERE member_email='{$email}'";
			$run_rec = mysqli_query($conn, $rec) or die("Failed: run_rec");

		
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
			    $mail->Subject = 'TradeNet Account Recovery';
			    $mail->Body    = "Click the link below to reset your TradeNet account Password<br><br> <a href='https://atchosting.ac.tz/tradenet/recover.php?rec_email={$email}&rec_code={$recover_code}'>Reset Your Password</a> <br><br>Thank you for choosing TradeNet";
			    $mail->AltBody = "Click the link below to reset your TradeNet account Password: <a href='https://atchosting.ac.tz/tradenet/recover.php?rec_email={$email}&rec_code={$recover_code}'>Reset Your Password</a>";

			    $mail->send();
			    echo 'A message has been set to your email. Click the link in it to reset your TradeNet account Password <br><br><a href="index.php">Go Back</a><br>';

					die("Successful");
					
			} catch (Exception $e) {
			    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
			    die("<br>Failed");
			} 


		
	}
}


//AFTER CLICKING A LINK SENT TO EMAIL ADRESS PROVIDED FOR CHANGING THE PASSWORD
if(isset($_GET['rec_code'])){
	$rec_code = $_GET['rec_code'];
	$rec_email = $_GET['rec_email'];


	$rec_email = sanitize($rec_email);
	$rec_code = sanitize($rec_code);

	require_once('includes/db_conn.php');

	$rec_email = mysqli_real_escape_string($conn, $rec_email);
	$rec_code = mysqli_real_escape_string($conn, $rec_code);

	$recov = "SELECT * FROM members WHERE member_email='{$rec_email}' AND member_recover={$rec_code}";
	$run_recov = mysqli_query($conn, $recov) or die("Failed: run_recov_ " . mysqli_error($conn));

	$num_recov = mysqli_num_rows($run_recov);

	if($num_recov == 0){
		header("Location: index.php");
		die();
	} else {

		$recover_now = true;
		$row_recov = mysqli_fetch_array($run_recov);
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

<?php

if($recover_now){

?>


<div id="main">
	<form action="recover.php" method="post">
		<div id="form" style="height: 80vh;">
			<div id="h1">TradeNet Password Recovery</div>
			<div id="log">
				<label>Email: <?php echo $rec_email; ?></label>

				<input type="hidden" name="rec_email" value="<?php echo $rec_email; ?>">
				<input type="hidden" name="rec_code" value="<?php echo $rec_code; ?>">
				<input type="password" name="new_password" placeholder="Enter Your New Password">
				<input type="password" name="cnew_password" placeholder="Confirm Your New Password">
				<input type="submit" name="set_new_pass" value="Submit">
			</div>
			<div id="sign">
				<a href=""></a>
				<a href="index.php" class="right">Home</a>
			</div>	
		</div>
	</form>
</div>

<?php


} else {


?>

<div id="main">
	<form action="" method="post">
		<div id="form" style="height: 60vh;">
			<div id="h1">TradeNet Password Recovery</div>
			<div id="log">
				<label>Email</label>
				<input type="email" name="email" placeholder="Enter Your TradeNet Email">
				<input type="submit" name="recover" value="Submit">
			</div>
			<div id="sign">
				<a href=""></a>
				<a href="login.php" class="right">Back</a>
			</div>	
		</div>
	</form>
</div>
<?php

}

?>


</body>
</html>