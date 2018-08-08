<?php

require_once('includes/db_conn.php');

include("includes/session_check.php");

?>
<!DOCTYPE html>
<html>
<head>
	<title>TradeNet</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
<?php include("includes/header.php"); ?>

<?php include("includes/aside.php"); ?>



<div id="main">
	<div id="heading"><h1>Products</h1></div>
	<div id="prods">

		<?php

		$prod = "SELECT * FROM products ORDER BY product_id DESC";
		$run_prod = mysqli_query($conn, $prod) or die("Failed: run_prod");
		
		$num_run_prod = mysqli_num_rows($run_prod);

		if(!$num_run_prod) echo "No products available for now"; 

		while($row_prod = mysqli_fetch_array($run_prod)){
			$prod_id = $row_prod['product_id'];
			$prod_name = $row_prod['product_name'];
			$prod_image = $row_prod['product_image'];
			$prod_price = $row_prod['product_price'];
			$prod_seller = $row_prod['product_seller'];

			if($prod_seller == $email) continue;

			//Fetching the username of the seller of this product
			$seller = "SELECT * FROM members WHERE member_email='{$prod_seller}'";
			$run_seller = mysqli_query($conn, $seller) or die("
				Failed run_seller");
			$row_seller = mysqli_fetch_array($run_seller);
			$seller_name = $row_seller['member_username'];
		

		?>
		<div class="prod">
			<div class="prod_title"><b><?php echo $prod_name; ?></b></div>
			<div class="prod_img" style="
	background-image: url('products/<?php echo $prod_image; ?>');"></div>
			<div class="prod_seller">Seller: <b><?php echo $seller_name; ?></b></div>
			<div class="prod_price" style="position: relative;">
				Tshs. <b><?php echo $prod_price; ?>/=</b>

				<?php

				$check_cart = "SELECT * FROM cart WHERE product_id={$prod_id} and buyer='{$email}'";
				$run_check_cart = mysqli_query($conn, $check_cart) or die("Failed: run_check_cart");

				$num_check_cart = mysqli_num_rows($run_check_cart);

				if($num_check_cart == 1){
					?>

					<span class="add2cart"><a style="font-size:0.8em; background: #8600b3; color:#fff; text-decoration: none; display: flex; justify-content: center; align-items: center; padding: 0 5px; margin-bottom: 5px; opacity: 0.5;">Added To Cart</a></span>

					<?php
				} else {

					?>

					<span class="add2cart"><a style="font-size:0.8em; background: #8600b3; color:#fff; text-decoration: none; display: flex; justify-content: center; align-items: center; padding: 0 5px; margin-bottom: 5px;" href="addtocart.php?prod_id=<?php echo $prod_id; ?>">Add To Cart</a></span>
					<?php

				}

				?>
			</div>
		</div>

		<?php


		}


		?>

</div>



</body>
</html>