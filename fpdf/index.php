<?php

if(isset($_POST['print'])){

	require 'fpdf.php';




	$buk = new FPDF();
	$buk->AddPage();
	$buk->SetFont("Times", "I", 20);
	$buk->Cell(60, 10 ,"Olengai Laizer", 1, 0, C);
	$buk->Cell(80, 10 ,"oleelaizer@gmail.com", 1, 0, C);
	$buk->Cell(40, 10 ,"20yrs old", 1, 0, C);
	$buk->Ln();
	$buk->SetFont("Times", "I", 20);
	$buk->Cell(60, 10 ,"Olengai Laizer", 1, 0, C);
	$buk->Cell(80, 10 ,"oleelaizer@gmail.com", 1, 0, C);
	$buk->Cell(40, 10 ,"20yrs old", 1, 0, C);
	$buk->Ln();
	$buk->Output();
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Print PDF</title>
</head>
<body>

	<form action="" method="post" enctype="multipart/form-data">
		<input style="display: inline-block; padding: 20px 30px; font-size: 24px;" type="submit" name="print" value="Print">
	</form>

</body>
</html>