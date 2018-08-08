<?php

$user = "SELECT * FROM members WHERE member_email='{$email}'";
$run_user = mysqli_query($conn, $user) or die("query failed");
$row_user = mysqli_fetch_array($run_user);
$member_image = $row_user['member_image'];
$member_username = $row_user['member_username'];



?>

<aside>
	
	<div id="prof_img" style="
background-image: url('images/<?php echo $member_image; ?>');"></div>
	<a id="prof" style="font-size: 16px;"><?php echo $member_username; ?></a>
	
	<?php

		$cart_n = "SELECT * FROM cart WHERE buyer='{$email}'";
		$run_cart_n = mysqli_query($conn, $cart_n) or die('Failed: run_cart');
		$num_car_n = mysqli_num_rows($run_cart_n);



	?>

	<a href='cart.php' id="sell">View Cart (<?php echo $num_car_n; ?>)</a>


	<?php
		$product_n = "SELECT * FROM products WHERE product_seller='{$email}'";
		$run_product_n = mysqli_query($conn, $product_n) or die('Failed: run_cart');
		$num_product_n = mysqli_num_rows($run_product_n);



	?>


	<a href='myproducts.php' id="sell">My Products(<?php echo $num_product_n; ?>)</a>
	<a href='chpass.php' id="sell">Change Password</a>	
	<a href='logout.php' id="sell">Log Out</a>

</aside>