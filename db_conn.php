<?php
require dirname(__FILE__) . "/config.php";

function getDBConn(){
	// Create connection
	$conn=mysqli_connect(AWS_RDS_HOST,AWS_RDS_NAME,AWS_RDS_PASS,AWS_RDS_DBNAME);

	// Check connection
	if (mysqli_connect_errno($conn)){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		exit();
	}else{
		return $conn;
	}
}

?>