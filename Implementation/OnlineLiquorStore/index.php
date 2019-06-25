<?php 
include 'sess.php';
include 'controller/admin/product.php';

$amIAdmin = false;

$product = new ProductController();

$allProducts = $product->getProducts("id > 0");

if ( $loggedIn ) {
	include 'controller/order.php';
	$orderObj = new Order();

	$myOrders = $orderObj->getMyOrders();

	if ( $_SESSION["admin"] ) {
		$amIAdmin = true;
	}
}



?>

<!DOCTYPE html>
<html>
<head>
	<title>Online Liquor Store</title>
	<?php 
		include 'includes/head.php';	
	?>
</head>
<body>
	
	<?php 
		$msg = "";
		if(isset($_GET["msg"])){
			$msg = $_GET["msg"];
			echo '<div id="msg">';
			echo htmlspecialchars($msg);
			echo '</div>';
		}  
	?>

	<div id="landing">
		<nav>
			<div class="logo">
				<img src="view/img/logo-small.png">
			</div>
			<div class="logoText">Online Liquor Store</div>

			<div class="links">
				<a href="index.php">Home</a>
				<a href="#about">About</a>
				<?php 

					if ( $loggedIn ) {
						echo '<a href="logout.php" class="bgred">Logout</a>';
						echo "<div class='hi'>Hi, ".$_SESSION["username"]."</div><br>";
						if(!$amIAdmin){
							echo '<a href="#myOrders" class="bgblue">View My Orders</a>';	
							echo '<a href="#products" class="bgblue">Order Products</a>';
						} 
						echo '<a href="profile.php" class="bgblue">View Profile</a>';
						if($_SESSION["admin"]) echo '<a href="adminpanel.php" class="bgred">Admin Panel</a>';
					}else{
						echo '
							<a href="usermanual.php">User Manual</a>
							<a href="#" id="lbtn">Login</a>
							<a href="#" id="rbtn">Register</a>
						';
					}

				?>
				
			</div>
		</nav>

		<?php 

			if (!$loggedIn) {
				echo '

					<div id="login">
						<h2>Login</h2>
						<form method="POST" action="controller/login.php">
							<input type="text" name="username" placeholder="username">
							<input type="password" name="password" placeholder="password">
							<a href="forgotPassword.php" style="float:left;margin-left:1%;">Forgot Password?</a>
							<button type="submit" name="btnLogin">Login</button>
						</form>
					</div>

					<div id="register">
						<h2>Create an account</h2>
						<form method="POST" action="controller/register.php">
							<input type="text" name="username" placeholder="username">
							<input type="password" name="password" placeholder="password">
							<input type="email" name="email" placeholder="email">
							<input type="text" name="address" placeholder="address">
							<input type="text" class="all" name="phone" placeholder="phone">
							<button type="submit" name="btnRegister">Register</button>
						</form>
					</div>
					<script type="text/javascript">
						var lbtn = document.getElementById(\'lbtn\'),
						rbtn = document.getElementById(\'rbtn\');
						lbtn.onclick = function(){
							document.getElementById("login").style.display = "block";
							document.getElementById("register").style.display = "none";
						};
						rbtn.onclick = function(){
							document.getElementById("login").style.display = "none";
							document.getElementById("register").style.display = "block";
						};
						if ( window.location.hash == "#register" ) {
							document.getElementById("login").style.display = "none";
							document.getElementById("register").style.display = "block";
						}
						if ( window.location.hash == "#login" ) {
							document.getElementById("login").style.display = "block";
							document.getElementById("register").style.display = "none";
						}
					</script>

				';
			}

		?>

	</div>



	<div id="bottom">

		<div class="store-element" id="products">
			<h2 style="text-align: center;">Our Products</h2>
			<div class="tc small">Hover over the products to order</div>
			<br><hr><br>

			<div class="sample">
				<?php 

					if ( $allProducts[0] == "ok" ) {
						foreach ($allProducts[1] as $product) {
							echo '	<div class="product">
										<p class="tc small">Price: &pound;'.$product->getPrice().'<br>
										Shipping Cost: &pound;'.$product->getShippingCost().'</p><hr>
										<div>
											<div>'.$product->getDescription().'</div>
											<br><hr><br>';
											
											if ( !$amIAdmin ) {
												echo '

													<form action="order.php" method="POST">
														<input type="hidden" name="productid" value="'.$product->getId().'">
														<input type="number" name="quantity" placeholder="quantity" style="width:100%;" required>
														<button type="submit" name="orderBtn" style="float:none;">Order</button>
													</form>

												';
											}
										echo '</div>
										<img src="productImages/'.$product->getImageName().'">
										<p>'.$product->getName().'</p>
										
									</div>
									';
						}
					}else{
						echo "<div class='tc'>No products to display.</div>";
					}

				?>
			</div>
		</div>
		
		<?php 
		if ( $loggedIn ) {
			
			if ( !$amIAdmin ) {
				echo '<div class="store-element" id="myOrders">
					<h2 style="text-align: center;">Your Orders</h2>
					<br><hr><br>';

						if ( $myOrders[0] == "ok" ) {
							foreach ($myOrders[1] as $order) {
								$product = $order[0];
								$quantity = $order[1];
								$orderId = $order[2];

								$totalOrderPrice = intval($product->getPrice()) + intval($product->getShippingCost());
								echo '	<div class="product">
											<p class="tc small">Total Order Price: &pound;'.$totalOrderPrice.'</p><hr>
											<div>
												<div>'.$product->getDescription().'</div>
											</div>
											<img src="productImages/'.$product->getImageName().'">
											<p>'.$product->getName().'</p>
										</div>
										';
							}
						}else{
							echo "<div class='tc'>No orders to display.</div>";
						}

						

				echo '</div>';
			}

		}
		?>

		<div class="store-element" id="about">
			<h2>About</h2>
			<br><hr><br>
			<p>Now online business became the easy and faster growing business. As the use of technology is rapidly increasing day after day. In the present time, technology is being use for every possible thing. Online business is also the must growing network. People are now modern and technology dependent they want everything easy and faster. Mobile phones, laptops and other technologies are being use rapidly. Nowadays everything is possible by the use of these technologies. By the use of these now people can order everything at their place, which end the tension of going to the market to buy anything. This type of business now provides faster services.<br>
			Online liquor store is the online business, which is going to sell every possible wines, beers, or other types of liquors. Nowadays ton of people, male and female alike, consume liquor on a daily basis. This proves that there is a big market for liquor business and as an aspiring entrepreneur looking for a business to start. Online liquor market will be the big project to complete as their possibly will be the large demand of the product.</p>
		</div>

		<div class="store-element" id="footer">
			<span>&copy; Online Liquor Store</span>
			<div id="socail">
				<a href="#"><img src="view/img/fb.png"></a>
				<a href="#"><img src="view/img/youtube.png"></a>
				<a href="#"><img src="view/img/instagram.png"></a>
			</div>
			<a href="usermanual.php" style="color: #000; text-decoration: underline;float: right; margin-right: 10px;margin-top: 6px;">User Manual</a>
		</div>

	</div>

	<script type="text/javascript">
	if( document.getElementById('msg') ){
		setTimeout(function(){
			document.getElementById('msg').style.display = "none";
		},5000);
	}
	</script>
</body>
</html>