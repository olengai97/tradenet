<?php

require_once('includes/db_conn.php');

include("includes/session_check.php");

?>
<!DOCTYPE html>
<html>
<head>
	<title>TradeNet</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<style type="text/css">
		#main {
			position: relative;
		}
		#main #pay {
			position: absolute;
			right: 30px;
			top: 10px;
			padding: 10px 20px;
			display: inline-block;	
			background: #8600b3;
			color: #fff;
		}
	</style>
</head>
<body>
<?php include("includes/header.php"); ?>

<?php include("includes/aside.php"); ?>



<div id="main">
	<div id="heading"><h1>Products</h1></div>
	<div id="prods">

		<?php

		$prod = "SELECT * FROM products";
		$run_prod = mysqli_query($conn, $prod) or die("Failed: run_prod");
		
		$num_run_prod = mysqli_num_rows($run_prod);

		if(!$num_run_prod) {echo "No products available"; }

		while($row_prod = mysqli_fetch_array($run_prod)){
			$prod_id = $row_prod['product_id'];
			$prod_name = $row_prod['product_name'];
			$prod_image = $row_prod['product_image'];
			$prod_price = $row_prod['product_price'];
			$prod_seller = $row_prod['product_seller'];

			if($prod_seller != $email) continue;
		

		?>
		<div class="prod">
			<div class="prod_title"><strong><?php echo $prod_name; ?></strong></div>
			<div class="prod_img" style="
	background-image: url('products/<?php echo $prod_image; ?>');"></div>
			<div class="prod_seller">Seller: <strong>You</strong></div>
			<div class="prod_price" style="position: relative;">
				Tshs. <b><?php echo $prod_price; ?></b>/=
			<span class="add2cart"><a style="font-size:0.8em; background: #8600b3; color:#fff; text-decoration: none; display: flex; justify-content: center; align-items: center; padding: 0 5px; margin-bottom: 5px;" href="removeprod.php?prod_id=<?php echo $prod_id; ?>">Remove</a></span>
			</div>
		</div>

		<?php

		

		}


		?>

		<div id="pay"><a target="_blank" href="reports.php?self_products=true" style="display: inline-block;  color:#ccc; text-decoration: underline;">My Products Report</a></div> 

</div>



</body>
</html>