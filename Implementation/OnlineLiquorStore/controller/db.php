<?php
global $conn;
class Connection
{
	protected $conn;
	private $host = "localhost";
	private $hostUsername = "root";
	private $hostPassword = "";
	private $dbName = "liquorstore";

	public function __construct(){
		$this->connect();
	}

	public function getConn(){
		return $this->conn;
	}

	protected function connect(){
		$this->conn = new mysqli($this->host, $this->hostUsername, $this->hostPassword, $this->dbName);
	}

}

$connection = new Connection;
$conn = $connection->getConn();

?>