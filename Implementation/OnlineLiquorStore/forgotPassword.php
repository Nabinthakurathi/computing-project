<?php 
include 'sess.php';

if ($loggedIn) {
	header("Location: index.php");
	exit();
}

include 'controller/db.php';
include 'controller/customers.php';

$customer = new Customer();

if ( isset($_POST["btnForgot"]) ) {
	$r = "";
	if ( isset($_POST["newPassword"]) && isset($_POST["phone"]) && isset($_POST["newPasswordAgain"]) ) {

		$newPassword = $_POST["newPassword"];
		$phone = $_POST["phone"];
		$newPasswordAgain = $_POST["newPasswordAgain"];

		if ( strlen($newPassword) > 0 && strlen($phone) > 0 && strlen($newPasswordAgain) > 0 ) {

			if( $newPassword != $newPasswordAgain ){
				header("Location: forgotPassword.php?msg=Password didnot match");
				exit();
			}

			$r = intval($customer->forgotPassword($newPassword,$phone));
			if ( $r === 1 ) {
				$r = "Password Sucessfully updated for your account, You can login now.";
			}
			if($r === 0){
				$r = "Error! No account found with that phone number!";
			}

		}else{
			$r = "All values > 'New password','Phone number','New Password Again' required for changing password.";
		}
		header("Location: forgotPassword.php?msg=".$r);
		exit();

	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Forgot Password , Online Liquor Store</title>
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
			<div class="logoText">Online Liquor Store > Forgot Password</div>

			<div class="links">
				<a href="index.php">Home</a>
			</div>

		</nav>
	</div>

	<div id="bottom">
		<div class="store-element" style="text-align: center;">
			<h2 style="text-align: center;">Forgot Password</h2>
			<div class="tc small">Forgot your password, do not worry just change password from below</div>
			<br><hr><br>

			<form method="POST" action="forgotPassword.php">
				<h5>Your phone number?</h5>
			<div class="tc small">Please enter your phone number so that we can verify its your account</div><br>
				<input type="text" name="phone" placeholder="Your phone number.." class="all">
				<hr><br>
				<input type="text" name="newPassword" placeholder="Enter new password">
				<input type="text" name="newPasswordAgain" placeholder="Enter new password again">
				
				<button type="submit" name="btnForgot">Update</button>
			</form>

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