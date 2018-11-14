<?php

class User {

	/*

CREATE TABLE users (
id int(11) unsigned PRIMARY KEY AUTO_INCREMENT,
userAgent varchar(255) DEFAULT NULL,
accept varchar(255) DEFAULT NULL,
acceptLang varchar(255) DEFAULT NULL,
acceptEncoding varchar(255) DEFAULT NULL,
ipAddress varchar(255) DEFAULT NULL
);

	*/

	public function __construct($conn = NULL)
	{
		$this->connection = $conn;
	}

	private $connection;

	public $userAgent;
	public $accept;
	public $acceptLang;
	public $acceptEncoding;
	public $ipAddress;
	public $visits;

	public function getAllHeaders()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		    $this->ipAddress = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		    $this->ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
		    $this->ipAddress = $_SERVER['REMOTE_ADDR'];
		}

		foreach (getallheaders() as $name => $value) {
		    switch ($name) {
		    	case 'User-Agent':
		    		$this->userAgent = $value;
		    		break;	
	    		case 'Accept':
		    		$this->accept = $value;
		    		break;	
	    		case 'Accept-Language':
		    		$this->acceptLang = $value;
		    		break;	
	    		case 'Accept-Encoding':
		    		$this->acceptEncoding = $value;
		    		break;	
		    	default:
		    			echo "Note: $name is unsupported with value $value <br>";
		    		break;
		    }
		}
	}

	public function saveToDatabase()
	{
		$sql = "INSERT INTO users (userAgent, accept, acceptLang, acceptEncoding, ipAddress) VALUES ('{$this->userAgent}', '{$this->accept}', '{$this->acceptLang}', '{$this->acceptEncoding}', '{$this->ipAddress}')";

		if ($this->connection->query($sql) === TRUE) {
		    echo "New record created successfully";
		} else {
		    echo "Error: " . $sql . "<br>" . $this->connection->error;
		}

	}

	public static function getAllUsers($conn)
	{
		
		$sql = "SELECT *, COUNT(userAgent) as visits FROM users GROUP BY userAgent";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
		    $userList = [];
		    while($row = $result->fetch_assoc()) 
		    {
			$u = new User();			
			$u->userAgent = $row["userAgent"];
			$u->accept = $row["accept"];
			$u->acceptLang = $row["acceptLang"];
			$u->acceptEncoding = $row["acceptEncoding"];
			$u->ipAddress = $row["ipAddress"];
			$u->visits = $row["visits"];			
			$userList[] = $u;
		    }
		    return $userList;
		} else {
		    return FALSE;
		}
	}
}
