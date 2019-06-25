<?php 
include 'sess.php';

if ( !$loggedIn ) {
	header("Location:index.php?msg=Customers must login to order");
	exit();
}
if( $_SESSION["admin"] ){
	header("Location:index.php?msg=Admin donot need to order!");
	exit();
}
include 'controller/db.php';
include 'controller/order.php';
$orderObj = new Order();

if ( isset($_POST["orderBtn"]) ) {
	if ( isset($_POST["quantity"]) && isset($_POST["productid"]) ) {
		$quantity = $_POST["quantity"];
		$productid = $_POST["productid"];
		$r = "";

		if ($quantity > 0) {
			$r = $orderObj->addOrder($productid,$quantity);
			if ( $r == "ok" ) {
				$r = "Your order was sucessfully placed.";
			}else{
				$r = "You have already ordered that product.";	
			}
		}else{
			$r = "You must at least order one quantity.";
		}
		header("Location:index.php?msg=".$r."#products");
		exit();
	}
}

?>