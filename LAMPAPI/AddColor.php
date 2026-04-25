<?php
	require "database_config.php";

	$inData = getRequestInfo();
	
	$color = $inData["color"];
	$userId = $inData["userId"];

	$conn = new mysqli(host, username, password, database);
	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	else
	{
		$stmt = $conn->prepare("INSERT into Colors (UserId,Name) VALUES(?,?)");
		if( !$stmt )
		{
			returnWithError( $conn->error );
			$conn->close();
			return;
		}

		$userId = (int)$userId;
		$stmt->bind_param("is", $userId, $color);
		$stmt->execute();
		$stmt->close();
		$conn->close();
		returnWithError("");
	}

	function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}
	
	function returnWithError( $err )
	{
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
?>
