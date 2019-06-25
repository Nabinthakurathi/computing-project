<?php 
include '../sess.php';
include 'db.php';

if ( $loggedIn ) {
	header("Location: ../index.php");
	exit();
}

class Login extends Connection{

	public function __construct(){
		$this->connect();
	}

	public function login($un,$ps){

		$r = "";
		$query = "SELECT * FROM customers WHERE username = ? AND password = ?";
		$st = $this->conn->prepare($query);
		$st->bind_param("ss",$un,$pss);
		$pss = sha1($ps);

		if ( $st->execute() ){
			$st->store_result();
			$st->bind_result($dbUid,$dbUn,$dbAddress,$phone,$dbPs,$dbEmail);

			if ( $st->num_rows < 1 ) {
				$r = " Username or password is invalid!";
			}else{
				if( $st->fetch() ){
					
					$_SESSION["userid"] = $dbUid; 
					$_SESSION["username"] = $dbUn;
					$_SESSION["email"] = $dbEmail;
					$_SESSION["phone"] = $phone;
					$_SESSION["address"] = $dbAddress;
					$_SESSION["admin"] = false;

					if ( strtolower($dbUn) == "storeadmin" ) {
						$_SESSION["admin"] = true;
					}

					$r = "success";

				}
			}

		}else{
			$r = "Error";
		}
		return $r;
	}

}


if ( isset($_POST["btnLogin"]) ) {

	$returnValue = "";

	if ( isset($_POST["username"]) && isset($_POST["password"]) ) {

		$un = $_POST["username"];
		$ps = $_POST["password"];

		if ( strlen($un) > 6 && strlen($ps) > 6 ) {
			$loginUser = new Login();
			$returnValue = $loginUser->login($un,$ps);

			if ( $returnValue == "success" ) {
				header("Location: ../index.php?msg=Logged in");
				exit();
			}

		}else{
			$returnValue = "Invalid username and password.";
		}

	}

	header("Location: ../index.php?msg=".$returnValue."#login");
	exit();

}



?>