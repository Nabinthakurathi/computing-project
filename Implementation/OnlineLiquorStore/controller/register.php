<?php 
include '../sess.php';
include 'db.php';
include '../models/customer.php';

if ( $loggedIn ) {
	header("Location: ../index.php");
	exit();
}
class Register extends Connection{

	public function __construct(){
		$this->connect();
	}

	public function register($customer){

		$query = "INSERT INTO `customers`(`username`, `password`, `email`, `phone`, `address`) VALUES (?,?,?,?,?)";
		$st = $this->conn->prepare($query);
		$st->bind_param("sssss",$a,$b,$c,$d,$e);

		$a = $customer->getUsername();
		$b = $customer->getPassword();
		$c = $customer->getEmail();
		$d = $customer->getPhone();
		$e = $customer->getAddress();

		if ( $st->execute() ){
			$rt = "ok";
		}else{
			$rt = "error";
		}

		return $rt;

	}

}

	
if ( isset($_POST["btnRegister"]) ) {

	$returnValue = "";

	if ( isset($_POST["username"]) && isset($_POST["password"]) &&
		 isset($_POST["phone"]) && isset($_POST["email"]) && isset($_POST["address"])
		) {

		$phone = $_POST["phone"];
		$emailAddress = $_POST["email"];
		$un = $_POST["username"];
		$ps = $_POST["password"];
		$address = $_POST["address"];

		if ( strlen($phone) > 0 
			 && strlen($emailAddress) > 0 
			 && strlen($un) > 0 
			 && strlen($ps) > 0
			 && strlen($address) > 0
			) {
			
				$newCustomer = new Customer;

				$newCustomer->setEmail($emailAddress);
				$newCustomer->setPhone($phone);
				$newCustomer->setUsername($un);
				$newCustomer->setPassword(sha1($ps));
				$newCustomer->setAddress($address);

				$addMember = new Register();
				$returnValue = $addMember->register($newCustomer);

				if ( $returnValue == "ok" ) {
					$returnValue = "Registration success.";
				}
				if ( $returnValue == "error" ) {
					$returnValue = "Registration error.";
				}

		}else{
			$returnValue = "Please enter all the fields.";
		}

	}

	header("Location: ../index.php?msg=".$returnValue."#register");
	exit();

}

?>