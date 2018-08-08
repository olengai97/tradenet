<?php

$admin = "SELECT * FROM members WHERE member_email='{$email}'";
$run_admin = mysqli_query($conn, $admin);
$row_admin = mysqli_fetch_array($run_admin);
$member_status = $row_admin['member_status'];



?>

<header>
	<div><a id='h1' href='index.php'>TradeNet</a></div>

	<nav>
		<a href="products.php">Products</a>
		<a href='sell.php'>Sell Product</a>
<?php

if($member_status == "admin"){



?>
		<a href="members.php">Members</a>
		<a href="reports.php">Reports</a>
<?php

}

?>
	</nav>
</header>