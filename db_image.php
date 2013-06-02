<?php
require dirname(__FILE__) . "/db_conn.php";


function getImageURLByHashcode($hashcode){
	// Create connection
	$conn = getDBConn();

	//check photo alrady exist ?
	$sql = "SELECT URL FROM IMAGES WHERE HASHCODE = ? ";
	if ($stmt = $conn->prepare($sql)) {
    	/* bind parameters for markers */
		$stmt->bind_param("s", $hashcode);
    	$stmt->execute();
	    $stmt->bind_result($result);
	    $stmt->fetch();
	    $stmt->close();

	    if($result){
	    	return $result;
	    }else{
	    	//insert to db
	    	return false;
	    }
	}
	$conn->close();
}


function saveImage($hashcode, $url){
	// Create connection
	$conn = getDBConn();

	// Check connection
	$sql = 'INSERT INTO IMAGES ( HASHCODE, URL, CREATE_DATE) VALUES ( "'. $hashcode . '", "'. $url . '", NOW() )';
	if (!$conn->query($sql)) {
		echo 'Error: '. $conn->error;
	}
	$conn->close();
}

?>