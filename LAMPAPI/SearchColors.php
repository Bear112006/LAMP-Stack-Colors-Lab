<?php
	require "database_config.php";

	$inData = getRequestInfo();
	
	$searchResults = "";
	$searchCount = 0;

	$conn = new mysqli(host, username, password, database);
	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	else
	{
		if(
			!isset($inData["search"]) ||
			!is_string($inData["search"]) ||
			trim($inData["search"]) === "" ||
			!isset($inData["userId"]) ||
			!is_numeric($inData["userId"])
		)
		{
			$conn->close();
			returnWithError( "Invalid search request" );
			return;
		}

		$stmt = $conn->prepare("select Name from Colors where Name like ? and UserID=?");
		if( !$stmt )
		{
			error_log( "SearchColors prepare failed: " . $conn->error );
			returnWithError( "Database error" );
			$conn->close();
			return;
		}

		$colorName = "%" . trim($inData["search"]) . "%";
		$userId = (int)$inData["userId"];
		$stmt->bind_param("si", $colorName, $userId);
		$didExecute = $stmt->execute();

		if( !$didExecute )
		{
			$error = $stmt->error ?: $conn->error;
			error_log( "SearchColors execute failed: " . $error );
			$stmt->close();
			$conn->close();
			returnWithError( "Database error" );
			return;
		}
		
		$result = $stmt->get_result();
		
		while($row = $result->fetch_assoc())
		{
			if( $searchCount > 0 )
			{
				$searchResults .= ",";
			}
			$searchCount++;
			$searchResults .= '"' . $row["Name"] . '"';
		}
		
		if( $searchCount == 0 )
		{
			returnWithError( "No Records Found" );
		}
		else
		{
			returnWithInfo( $searchResults );
		}
		
		$stmt->close();
		$conn->close();
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
		$retValue = '{"id":0,"firstName":"","lastName":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
	function returnWithInfo( $searchResults )
	{
		$retValue = '{"results":[' . $searchResults . '],"error":""}';
		sendResultInfoAsJson( $retValue );
	}
	
?>
