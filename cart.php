<?php

require_once('includes/db_conn.php');

include("includes/session_check.php");

?>
<!DOCTYPE html>
<html>
<head>
	<title>TradeNet</title>
	<link rel="stylesheet" type="text/css" href="css/cart.css">
</head>
<body>
<?php include("includes/header.php"); ?>

<?php include("includes/aside.php"); ?>



<div id="main">
	<div id="heading"><h1>Cart</h1></div>
	<div id="prods">
		<?php

		$cart = "SELECT * FROM cart WHERE buyer='{$email}'";
		$run_cart = mysqli_query($conn, $cart) or die('Failed: run_cart');

		$price_count = 0;
		$num_cart = mysqli_num_rows($run_cart);

		if($num_cart == 0) {		

			echo "<p class='msg'>You currently have no products on the cart.</p>";
			
		}

		while($row_cart = mysqli_fetch_array($run_cart)){
			$cart_id = $row_cart['cart_id'];
			$cart_prod_id = $row_cart['product_id'];

			$prod_cart = "SELECT * FROM products WHERE product_id={$cart_prod_id}";
			$run_prod_cart = mysqli_query($conn, $prod_cart) or die("Failed: run_prod_cart");
			$row_prod_cart = mysqli_fetch_array($run_prod_cart);
			$prod_name = $row_prod_cart['product_name'];
			$prod_image = $row_prod_cart['product_image'];
			$prod_price = $row_prod_cart['product_price'];
			$prod_seller = $row_prod_cart['product_seller'];

			//Fetching the username of the seller of this product
			$seller = "SELECT * FROM members WHERE member_email='{$prod_seller}'";
			$run_seller = mysqli_query($conn, $seller) or die("
				Failed run_seller");
			$row_seller = mysqli_fetch_array($run_seller);
			$seller_name = $row_seller['member_username'];

			$prod_price = (int)$prod_price;

			$price_count = $price_count + $prod_price;

		?>

		
		<div class="prod">
			<div class="prod_title"><b><?php echo $prod_name; ?></b></div>
			<div class="prod_img" style="
	background-image: url('products/<?php echo $prod_image; ?>');"></div>
			<div class="prod_seller">Seller: <b><?php echo $seller_name; ?></b></div>
			<div class="prod_price" style="position: relative;">Tsh. <b><?php echo $prod_price; ?>/=</b>
				<span class="add2cart"><a style="font-size:0.8em; background: #8600b3; color:#fff; text-decoration: none; display: flex; justify-content: center; align-items: center; padding: 0 5px; margin-bottom: 5px;" href="cartremove.php?prod_id=<?php echo $cart_prod_id; ?>">Remove</a></span>
			</div>
		</div>

		<?php

		}

		?>

		<div id="pay"><a target="blank" href="reports.php?self_cart=true" style="display: inline-block; padding-right: 40px; color:#ccc; text-decoration: underline;">Cart Report</a>Total: <span style='color:#eee;'>Tshs. <b><?php echo $price_count; ?>/=</b></span></div> 

		


</div>



</body>
</html>