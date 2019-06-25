<?php 
include 'sess.php';

if ( !$loggedIn ) {
	header("Location: index.php?msg=Access denied");
	exit();
}


if ( !$_SESSION["admin"] ) {
	header("Location: index.php?msg=Access denied");
	exit();
}

include 'controller/admin/product.php';
$productController = new ProductController();

if ( isset($_POST["btnAddProduct"]) ) {

	if( !isset($_POST["name"]) || !isset($_POST["description"]) || !isset($_POST["price"]) || !isset($_POST["category"]) || !isset($_POST["shippingcost"])  ){
		header("Location: adminpanel.php?msg=Invalid post.#add");
		exit();
	}
	if( strlen($_POST["description"]) < 1 || strlen($_POST["name"]) < 1 || strlen($_POST["price"]) < 1 || strlen($_POST["category"]) < 1 || strlen($_POST["shippingcost"]) < 1 || !$_FILES["productImage"]["name"] ){
		header("Location: adminpanel.php?msg=All Products details required.#add");
		exit();
	}

	$description = $_POST["description"];
	$name = $_POST["name"];
	$price = $_POST["price"];
	$category = $_POST["category"];
	$shippingCost = $_POST["shippingcost"];

	$imageName = time()."-".$_FILES["productImage"]["name"];
	move_uploaded_file($_FILES["productImage"]["tmp_name"], "productImages/".$imageName);
	
	$product = new Product();
	$product->setDescription($description);
	$product->setName($name);
	$product->setPrice($price);
	$product->setCategory($category);
	$product->setShippingCost($shippingCost);
	$product->setImageName($imageName);

	$r = $productController->addProduct($product);
	if ( $r == "ok" ) {
		$r = "Product added";
	}
	header("Location: adminpanel.php?msg=".$r."#add");
	exit();
}

if ( isset($_POST["btnDeleteProduct"]) ) {
	if( !isset($_POST["productid"])){
		header("Location: adminpanel.php?msg=Invalid post.#delete");
		exit();
	}
	if( intval($_POST["productid"]) < 1 ){
		header("Location: adminpanel.php?msg=Delete details were empty.#delete");
		exit();
	}
	$productId = $_POST["productid"];
	$r = $productController->deleteProduct($product);
	if($r){
		$r = "Product deleted";
	}else{
		$r = "error";
	}
	header("Location: adminpanel.php?msg=".$r."#delete");
	exit();
}

if ( isset($_POST["btnUpdateProduct"]) ) {
	if( !isset($_POST["productid"]) || !isset($_POST["updateFor"]) || !isset($_POST["updateTo"])  ){
		header("Location: adminpanel.php?msg=Invalid post.#update");
		exit();
	}
	if( intval($_POST["productid"]) < 1 || strlen($_POST["updateFor"]) < 1 || strlen($_POST["updateTo"]) < 1  ){
		header("Location: adminpanel.php?msg=Update details cannot be empty.#update");
		exit();
	}
	$productId = $_POST["productid"];
	$updateFor = $_POST["updateFor"];
	$updateTo = $_POST["updateTo"];
	$r = $productController->updateProduct($updateFor,$updateTo,$productId);
	if($r){
		$r = "Product updated";
	}else{
		$r = "error";
	}
	header("Location: adminpanel.php?msg=".$r."#update");
	exit();
}

include 'controller/order.php';
include 'controller/customers.php';

$orderObj = new Order();
$allOrders = $orderObj->getAllOrders();

$customer = new Customer();
$allCustomers = $customer->getAllCustomers();


$allProducts = $productController->getProducts("id > 0")

?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title>
	<?php 
		include 'includes/head.php';	
	?>
</head>
<body class="admin">
	
	<?php 
		$msg = "";
		if(isset($_GET["msg"])){
			$msg = $_GET["msg"];
			echo '<div id="msg">';
			echo htmlspecialchars($msg);
			echo '</div>';
		}  
	?>

	
	<div class="adminpanel">
			
		<div class="head">
			Admin Panel
		</div>

		<div class="leftbody">

			<div id="addProduct" class="adminPanelEl" style="width: 100%;box-shadow: none;border-radius: 0;">
				<h2 style="text-align: center;">Add Product</h2><br>
				<form method="POST" action="adminpanel.php" enctype="multipart/form-data">
					<input type="text" name="name" placeholder="name" style="width: 99%;">
					<input type="number" name="price" placeholder="price">
					<input type="number" name="shippingcost" placeholder="shipping cost">
					<div style="clear: both;margin-bottom: 10px;text-align: left;margin-left: 1%;color: #fff;"><h3>Category</h3></div>
					<select name="category" style="width: 99%;">
						<option value="Beer">Beer</option>
						<option value="Wine">Wine</option>
						<option value="Cider">Cider</option>
						<option value="Rums">Rums</option>
						<option value="Spice Liquor">Spice Liquor</option>
						<option value="Bitterfruit Liquor">Bitterfruit Liquor</option>
						<option value="Bitterfruit Liquor">Whiskey</option>
					</select>
					<div style="clear: both;margin-bottom: 10px;text-align: left;margin-left: 1%;color: #fff;"><h3>Product image</h3></div>
					<input type="file" name="productImage">
					<textarea style="width: 99%;" name="description" placeholder="description"></textarea>
					<button type="submit" name="btnAddProduct">Add</button>
				</form>
			</div>

			<div id="deleteProduct" class="adminPanelEl" style="width: 100%;box-shadow: none;border-radius: 0;">
				<h2 style="text-align: center;">Delete Product</h2><br>
				<form method="POST" action="adminpanel.php">
					<input type="number" name="productid" placeholder="productid" class="full">
					<button type="submit" name="btnDeleteProduct">Delete</button>
				</form>
			</div>

			<div id="updateProduct" class="adminPanelEl" style="width: 100%;box-shadow: none;border-radius: 0;">
				<h2 style="text-align: center;">Update Product</h2><br>
				<form method="POST" action="adminpanel.php">
					<input type="text" name="productid" placeholder="product id" class="full">
					<div style="clear: both;margin-bottom: 10px;text-align: left;margin-left: 1%;color: #fff;"><h3>Update for</h3></div>
					<select  name="updateFor" class="full">
						<option class="name">Name</option>
						<option class="price">Price</option>
						<option class="shippingCost">Shipping Cost</option>
						<option class="description">Description</option>
						<option class="category">Category</option>
					</select>
					<div style="clear: both;margin-bottom: 10px;text-align: left;margin-left: 1%;color: #fff;"><h3>Update to</h3></div>
					<input type="text" name="updateTo" placeholder="update value" class="full">
					<button type="submit" name="btnUpdateProduct">Update</button>
				</form>
			</div>

			<div id="allOrders" class="adminPanelEl" style="width: 100%;box-shadow: none;border-radius: 0;">
				<h2 style="text-align: center;">All Orders</h2><br>
				<?php 

					if ( $allOrders[0] == "ok" ) {
						echo '
							<table>
								<thead>
									<tr>
									  <th>Order Id</th>
									  <th>Ordered By</th>
									  <th>Ordered Product</th>
									  <th>Ordered Quantity</th>
									  <th>Total Order Price</th>
									</tr>
								</thead>
								<tbody>';
						foreach ($allOrders[1] as $order) {
							$product = $order[0];
							$quantity = $order[1];
							$orderId = $order[2];
							$customerId = $order[3];

							$totalOrderPrice = intval($product->getPrice()) + intval($product->getShippingCost());
							

							echo '
								
										<tr>
										  <td data-column="Order Id">'.$orderId.'</td>
										  <td data-column="Ordered By"> Customer id:'.$customerId.'</td>
										  <td data-column="Ordered Product">'; 

										echo '	<div class="product small">
												<div title="'.$product->getDescription().'">'.$product->getDescription().'</div>
											<img src="productImages/'.$product->getImageName().'">
											<p>Id:'.$product->getId()." ".$product->getName().'</p>
										</div>
										';
										  echo '</td>
										  <td data-column="Ordered Quantity">'.$quantity.'</td>
										  <td data-column="Total Order Price">&pound;'.$totalOrderPrice.'</td>
										</tr>
									
							';

						}
					echo '</tbody>
						</table>';
					}else{
						echo "<div class='tc'>No orders to display.</div>";
					}

				?>
			</div>

			<div id="allCustomers" class="adminPanelEl" style="width: 100%;box-shadow: none;border-radius: 0;">
				<h2 style="text-align: center;">All customers</h2><br>
				<?php 

					if ( $allCustomers[0] == "ok" ) {
						echo '
							<table>
								<thead>
									<tr>
										<th>Customer Id</th>
										<th>Username</th>
										<th>Address</th>
										<th>Phone number</th>
										<th>Email</th>
									</tr>
								</thead>
								<tbody>';
						foreach ($allCustomers[1] as $customer) {
							$id = $customer[0];
							$username = $customer[1];
							$email = $customer[5];
							$phone = $customer[3];
							$address = $customer[2];
							
							echo '
							<tr>
								<td data-column="User id">'.$id.'</td>
								<td data-column="Username">'.$username.'</td>
								<td data-column="Address">'.$address.'</td>
								<td data-column="Phone number">'.$phone.'</td>
								<td data-column="Email">'.$email.'</td>
							</tr>
							';

						}
					echo '</tbody>
						</table>';
					}else{
						echo "<div class='tc'>No customers to display.</div>";
					}

				?>
			</div>

			<div id="allProducts" class="adminPanelEl" style="width: 100%;box-shadow: none;border-radius: 0;">
				<h2 style="text-align: center;">All products</h2><br>
				<?php 

					if ( $allProducts[0] == "ok" ) {
						echo '
							<table>
								<thead>
									<tr>
										<th>Product Id</th>
										<th>Name</th>
										<th>Price</th>
										<th>Shipping Cost</th>
										<th>Category</th>
										<th>Product Image</th>
									</tr>
								</thead>
								<tbody>';
						foreach ($allProducts[1] as $product) {
							
							echo '
							<tr>
								<td data-column="Product Id">'.$product->getId().'</td>
								<td data-column="Name">'.$product->getName().'</td>
								<td data-column="Price">&pound;'.$product->getPrice().'</td>
								<td data-column="Shipping Cost">&pound;'.$product->getShippingCost().'</td>
								<td data-column="Category">'.$product->getCategory().'</td>
								<td data-column="Product Image"><img src="productImages/'.$product->getImageName().'"></td>
							</tr>
							';

						}
					echo '</tbody>
						</table>';
					}else{
						echo "<div class='tc'>No products to display.</div>";
					}

				?>
			</div>

		</div>


		<div class="rightNav">
			<a href="#" id="addProdcutBtn">Add Product</a>
			<a href="#" id="deleteProdcutBtn">Delete Product</a>
			<a href="#" id="updateProductBtn">Update Product</a>
			<a href="#" id="viewCustomers">View Customers</a>
			<a href="#" id="viewProdcuts">View Products</a>
			<a href="#" id="viewOrders">View Orders</a>
			<br><hr><br>
			<a href="index.php">Home</a>
			<a href="logout.php" class="bgred">Logout</a>
		</div>

	</div>



	<script type="text/javascript">
		var addProdcutBtn = document.getElementById('addProdcutBtn'),
		deleteProdcutBtn = document.getElementById('deleteProdcutBtn'),
		updateProductBtn = document.getElementById('updateProductBtn'),
		viewProdcutsBtn = document.getElementById('viewProdcuts'),
		viewCustomersBtn = document.getElementById('viewCustomers'),
		viewOrdersBtn = document.getElementById('viewOrders');
		addProdcutBtn.onclick = function(){
			document.getElementById("addProduct").style.display = "block";
			document.getElementById("deleteProduct").style.display = "none";
			document.getElementById("updateProduct").style.display = "none";
			document.getElementById("allOrders").style.display = "none";
			document.getElementById("allProducts").style.display = "none";
			document.getElementById("allCustomers").style.display = "none";
			this.style.backgroundColor = "rgba(255,255,255,0.5)";
			deleteProdcutBtn.style.backgroundColor = "unset";
			updateProductBtn.style.backgroundColor = "unset";
			viewOrdersBtn.style.backgroundColor = "unset";
			viewProdcutsBtn.style.backgroundColor = "unset";
			viewCustomersBtn.style.backgroundColor = "unset";
		};
		deleteProdcutBtn.onclick = function(){
			document.getElementById("addProduct").style.display = "none";
			document.getElementById("deleteProduct").style.display = "block";
			document.getElementById("updateProduct").style.display = "none";
			document.getElementById("allOrders").style.display = "none";
			document.getElementById("allProducts").style.display = "none";
			document.getElementById("allCustomers").style.display = "none";
			this.style.backgroundColor = "rgba(255,255,255,0.5)";
			addProdcutBtn.style.backgroundColor = "unset";
			updateProductBtn.style.backgroundColor = "unset";
			viewOrdersBtn.style.backgroundColor = "unset";
			viewProdcutsBtn.style.backgroundColor = "unset";
			viewCustomersBtn.style.backgroundColor = "unset";
		};
		updateProductBtn.onclick = function(){
			document.getElementById("addProduct").style.display = "none";
			document.getElementById("deleteProduct").style.display = "none";
			document.getElementById("updateProduct").style.display = "block";
			document.getElementById("allOrders").style.display = "none";
			document.getElementById("allProducts").style.display = "none";
			document.getElementById("allCustomers").style.display = "none";
			this.style.backgroundColor = "rgba(255,255,255,0.5)";
			addProdcutBtn.style.backgroundColor = "unset";
			deleteProdcutBtn.style.backgroundColor = "unset";
			viewOrdersBtn.style.backgroundColor = "unset";
			viewProdcutsBtn.style.backgroundColor = "unset";
			viewCustomersBtn.style.backgroundColor = "unset";
		};
		viewOrdersBtn.onclick = function(){
			document.getElementById("addProduct").style.display = "none";
			document.getElementById("deleteProduct").style.display = "none";
			document.getElementById("updateProduct").style.display = "none";
			document.getElementById("allOrders").style.display = "block";
			document.getElementById("allProducts").style.display = "none";
			document.getElementById("allCustomers").style.display = "none";
			this.style.backgroundColor = "rgba(255,255,255,0.5)";
			addProdcutBtn.style.backgroundColor = "unset";
			deleteProdcutBtn.style.backgroundColor = "unset";
			updateProductBtn.style.backgroundColor = "unset";
			viewProdcutsBtn.style.backgroundColor = "unset";
			viewCustomersBtn.style.backgroundColor = "unset";
		};

		viewProdcutsBtn.onclick = function(){
			document.getElementById("addProduct").style.display = "none";
			document.getElementById("deleteProduct").style.display = "none";
			document.getElementById("updateProduct").style.display = "none";
			document.getElementById("allOrders").style.display = "none";
			document.getElementById("allProducts").style.display = "block";
			document.getElementById("allCustomers").style.display = "none";
			this.style.backgroundColor = "rgba(255,255,255,0.5)";
			addProdcutBtn.style.backgroundColor = "unset";
			deleteProdcutBtn.style.backgroundColor = "unset";
			updateProductBtn.style.backgroundColor = "unset";
			viewOrdersBtn.style.backgroundColor = "unset";
			viewCustomersBtn.style.backgroundColor = "unset";
		};

		viewCustomersBtn.onclick = function(){
			document.getElementById("addProduct").style.display = "none";
			document.getElementById("deleteProduct").style.display = "none";
			document.getElementById("updateProduct").style.display = "none";
			document.getElementById("allOrders").style.display = "none";
			document.getElementById("allProducts").style.display = "none";
			document.getElementById("allCustomers").style.display = "block";
			this.style.backgroundColor = "rgba(255,255,255,0.5)";
			addProdcutBtn.style.backgroundColor = "unset";
			deleteProdcutBtn.style.backgroundColor = "unset";
			updateProductBtn.style.backgroundColor = "unset";
			viewOrdersBtn.style.backgroundColor = "unset";
			viewProdcutsBtn.style.backgroundColor = "unset";
		};


		addProdcutBtn.style.backgroundColor = "rgba(255,255,255,0.5)";
		document.getElementById("addProduct").style.display = "block";
		document.getElementById("deleteProduct").style.display = "none";
		document.getElementById("updateProduct").style.display = "none";
		document.getElementById("allOrders").style.display = "none";
		document.getElementById("allProducts").style.display = "none";
		document.getElementById("allCustomers").style.display = "none";

		if ( window.location.hash == "#delete" ) {
			deleteProdcutBtn.click();
		}
		if ( window.location.hash == "#add" ) {
			addProdcutBtn.click();
		}
		if ( window.location.hash == "#update" ) {
			updateProductBtn.click();
		}
	</script>

	<script type="text/javascript">
	if( document.getElementById('msg') ){
		setTimeout(function(){
			document.getElementById('msg').style.display = "none";
		},5000);
	}
</script>
</body>
</html>