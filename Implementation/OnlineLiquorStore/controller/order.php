<?php 

class Order extends Connection{

	public function __construct(){
		$this->connect();
	}

	public function addOrder($productId,$quantity){
		$query = "INSERT INTO `orders`(`customer_id`, `product_id`, `quantity`) VALUES (?,?,?)";
		$st = $this->conn->prepare($query);
		$st->bind_param("iii",$a,$b,$c);

		$a = $_SESSION["userid"];
		$b = $productId;
		$c = $quantity;

		if ( $st->execute() ){
			$rt = "ok";
		}else{
			$rt = "error";
		}
		return $rt;
	}

	public function getMyOrders(){
		$r = array();
		$query = "SELECT o.id,o.product_id,quantity,price,imageName,shippingCost,name,description FROM orders o,products p WHERE o.product_id = p.id AND o.customer_id = ? ORDER BY o.id DESC";
		$st = $this->conn->prepare($query);
		$st->bind_param("i",$sid);
		$sid = $_SESSION["userid"];

		if ( $st->execute() ){
			$st->store_result();
			$st->bind_result($orderId,$productId,$quantity,$price,$imageName,$shippingCost,$name,$description);

			if ( $st->num_rows < 1 ) {
				$r[0] = "no";
			}else{
				$r[0] = "ok";
				$r[1] = array();
				while( $st->fetch() ){

					$product = new Product();
					$product->setId($productId);
					$product->setName($name);
					$product->setShippingCost($shippingCost);
					$product->setPrice($price);
					$product->setImageName($imageName);
					$product->setDescription($description);

					array_push($r[1],array($product,$quantity,$orderId));
				}
			}

		}else{
			$r[0] = "Error";
		}
		$st->close();
		return $r;
	}

	public function getAllOrders(){
		$r = array();
		$query = "SELECT o.id,o.product_id,quantity,price,imageName,shippingCost,name,description,customer_id FROM orders o,products p WHERE o.product_id = p.id ORDER BY o.id DESC";
		$st = $this->conn->prepare($query);

		if ( $st->execute() ){
			$st->store_result();
			$st->bind_result($orderId,$productId,$quantity,$price,$imageName,$shippingCost,$name,$description,$customerId);

			if ( $st->num_rows < 1 ) {
				$r[0] = "no";
			}else{
				$r[0] = "ok";
				$r[1] = array();
				while( $st->fetch() ){

					$product = new Product();
					$product->setId($productId);
					$product->setName($name);
					$product->setShippingCost($shippingCost);
					$product->setPrice($price);
					$product->setImageName($imageName);
					$product->setDescription($description);

					array_push($r[1],array($product,$quantity,$orderId,$customerId));
				}
			}

		}else{
			$r[0] = "Error";
		}
		$st->close();
		return $r;
	}

}
