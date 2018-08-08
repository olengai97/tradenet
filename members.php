<?php

require_once('includes/db_conn.php');

include("includes/session_check.php");



?>
<!DOCTYPE html>
<html>
<head>
	<title>TradeNet</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/members.css">
</head>
<body>
<?php include("includes/header.php"); ?>

<?php include("includes/aside.php"); ?>



<div id="main">
	<div id="heading"><h1>Members</h1></div>
	<div id="prods">
		<table border="1">
			<tr style="border-top: 1px solid #888;">
				<td><b>SNO</b></td>
				<td><b>Image</b></td>
				<td><b>Username</b></td>
				<td><b>Email</b></td>
				<td><b>Status</b></td>
				<td></td>
			</tr>

<?php

$members = "SELECT * FROM members";
$run_members = mysqli_query($conn , $members) or die("Failed: run_members");
$i = 1;
while($row_members = mysqli_fetch_array($run_members)){
	$mem_image = $row_members['member_image'];
	$mem_verified = $row_members['member_verified'];
	$mem_username = $row_members['member_username'];
	$mem_email = $row_members['member_email'];
	$mem_id = $row_members['member_id'];
	$mem_status = $row_members['member_status'];

	if($mem_status == "admin") continue;




?>

			<tr>
				<td><?php echo $i; ?></td>
				<td><p class='img' style="display: inline-block; border-radius: 50%; background-image: url('images/<?php echo $mem_image; ?>');"></td>
				<td><?php echo $mem_username; ?></td>
				<td><?php echo $mem_email; ?></td>
				<td>
<?php 

if($mem_verified == "YES"){
	echo "Activated";
} else {
	echo "Not Activated";
}

?>				</td>
				<td><a href="delete_mem.php?mem_id=<?php echo $mem_id; ?>">Delete</a></td>
			</tr>
<?php

$i++;

}


?>
		
		</table>

	
	</div>
</div>






</body>
</html>