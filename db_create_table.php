<?php
require dirname(__FILE__) . "/db_conn.php";

$conn = getDBConn();
//create database if not exist
$sql = "CREATE TABLE IMAGES 
	(
		ID INT NOT NULL AUTO_INCREMENT, 
		PRIMARY KEY(ID),
		HASHCODE CHAR(50),
		URL CHAR(200),
		CREATE_DATE DATETIME,
		UNIQUE(HASHCODE)
	)";

// Execute query
if (mysqli_query($conn,$sql)){
		echo "Table created successfully";
	}else{
	echo "Error creating table: " . mysqli_error($conn);
}
$conn->close();
?>