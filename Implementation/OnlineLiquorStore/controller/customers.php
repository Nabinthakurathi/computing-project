<?php 

class Customer extends Connection{

	public function __construct(){
		$this->connect();
	}

	public function editProfile($username,$email,$phone,$address){
		$q = "UPDATE `customers` SET `username` = ?, email = ?,phone = ?,address = ? WHERE id = ?";
		$qs = $this->conn->prepare($q);
		$qs->bind_param("ssssi",$username,$email,$phone,$address,$_SESSION["userid"]);
		$r = $qs->execute();
		$qs->close();
		return $this->conn->affected_rows;
	}

	public function forgotPassword($newPassword,$phone){
		$q = "UPDATE `customers` SET `password` = ? WHERE phone = ?";
		$qs = $this->conn->prepare($q);
		$qs->bind_param("ss",sha1($newPassword),$phone);
		$r = $qs->execute();
		$affectedRows = $this->conn->affected_rows;
		$qs->close();
		return $affectedRows;
	}

	public function deleteAccount($id){
		$q = "DELETE FROM `customers` WHERE `id` = ?";
		$qs = $this->conn->prepare($q);
		$qs->bind_param("i",$id);
		$r = $qs->execute();
		$qs->close();
		return $this->conn->affected_rows;
	}

	public function getAllCustomers(){
		$r = array();
		$query = "SELECT * FROM customers";
		$st = $this->conn->prepare($query);

		if ( $st->execute() ){
			$st->store_result();
			$st->bind_result($dbUid,$dbUn,$dbAddress,$phone,$dbPs,$dbEmail);

			if ( $st->num_rows < 1 ) {
				$r[0] = "no";
			}else{
				$r[0] = "ok";
				$r[1] = array();
				while( $st->fetch() ){
					array_push($r[1],array($dbUid,$dbUn,$dbAddress,$phone,$dbPs,$dbEmail));
				}
			}

		}else{
			$r[0] = "Error";
		}
		$st->close();
		return $r;
	}

}

?>