<?php 
include 'sess.php';
if ( !$loggedIn ) {
	header("Location: index.php?msg=Please login to view profile");
	exit();
}
include 'controller/db.php';
include 'controller/customers.php';

$customer = new Customer();

if ( isset($_POST["btnEdit"]) ) {
	$r = "";
	if ( isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["address"]) && isset($_POST["phone"]) ) {

		$username = $_POST["username"];
		$phone = $_POST["phone"];
		$email = $_POST["email"];
		$address = $_POST["address"];

		if ( strlen($username) > 0 && strlen($phone) > 0 && strlen($email) > 0 && strlen($address) > 0 ) {

			$r = $customer->editProfile($username,$email,$phone,$address);
			if ( $r) {
				$r = "Account edited";
				$_SESSION["username"] = $username;
				$_SESSION["email"] = $email;
				$_SESSION["phone"] = $phone;
				$_SESSION["address"] = $address;
			}else{
				$r = "Error";
			}

		}else{
			$r = "All edit details required to update!";
		}
		header("Location: profile.php?msg=".$r);
		exit();

	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Profile , Online Liquor Store</title>
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

	<div id="landing" class="small">
		<nav>
			<div class="logo">
				<img src="view/img/logo-small.png">
			</div>
			<div class="logoText">Online Liquor Store > User Profile</div>

			<div class="links">
				<a href="index.php">Home</a>
			</div>

		</nav>
	</div>

	<div id="bottom">
		<div class="store-element">
			<h2 style="text-align: center;">Your Informations</h2>
			<br><hr>
			<table>
				<thead>
					<tr>
					  <th>User Id</th>
					  <th>Username</th>
					  <th>Address</th>
					  <th>Phone number</th>
					  <th>Email</th>
					</tr>
				</thead>
				<tbody>
					<td data-column="User id"><?php echo $_SESSION["userid"]; ?></td>
					<td data-column="Username"><?php echo $_SESSION["username"]; ?></td>
					<td data-column="Address"><?php echo $_SESSION["address"]; ?></td>
					<td data-column="Phone number"><?php echo $_SESSION["phone"]; ?></td>
					<td data-column="Email"><?php echo $_SESSION["email"]; ?></td>
				</tbody>
			</table>

		</div>

		<div class="store-element">
			<h2 style="text-align: center;">Edit Profile</h2>
			<!-- <div class="tc small">Hover over the products to order</div> -->
			<br><hr><br>
			<form method="POST" action="profile.php">
				<input type="text" name="username" placeholder="username" value="<?php echo $_SESSION["username"]; ?>">
				<input type="email" name="email" placeholder="email" value="<?php echo $_SESSION["email"]; ?>">
				<input type="text" name="address" placeholder="address" value="<?php echo $_SESSION["address"]; ?>">
				<input type="text" name="phone" placeholder="phone" value="<?php echo $_SESSION["phone"]; ?>">
				<button type="submit" name="btnEdit">Edit</button>
			</form>
		</div>

		<!-- <div class="store-element">
			<h2 style="text-align: center;">Change Password</h2>
			<div class="tc small">Hover over the products to order</div>
			<br><hr><br>
			<form method="POST" action="profile.php">
				<input type="text" name="username" placeholder="username">
				<input type="email" name="email" placeholder="email">
				<input type="text" name="address" placeholder="address">
				<input type="text" name="phone" placeholder="phone">
				<button type="submit" name="btnEdit">Edit</button>
			</form>
		</div> -->

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