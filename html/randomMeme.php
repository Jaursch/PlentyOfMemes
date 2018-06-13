<?php
	include 'sessionheader.php';

	$currentpage="FindMyMeme";
	include "pages.php";

	// change the value of $dbuser and $dbpass to your username and password
	include 'connectvars.php'; 
//	include 'header.php';	
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if (!$conn) {
		die('Could not connect: ' . mysql_error());
	}	
	// query to select all information from supplier table
	$query = "SELECT * FROM Meme INNER JOIN Caption USING(MemeID) ORDER BY RAND() LIMIT 1;";

	// Get results from query
	$result = mysqli_query($conn, $query);
	if (!$result) {
		die("Query to show fields from table failed");
	}

	if($row = mysqli_fetch_assoc($result)){
		$url 		= $row["Image_URL"];
		$caption 	= $row["Text"];
		$MemeID 	= $row["MemeID"];
		$CaptionID 	= $row["CaptionID"];
		
		if(isset($_SESSION["user"])){
	 		$username = $_SESSION["user"];
 			$query2 = "SELECT COUNT(*) as C FROM (SELECT * FROM Questionnaire WHERE Username = '$username') as A";
 			if($result2 = mysqli_query($conn, $query2)){
 				$resultrow = mysqli_fetch_assoc($result2);
 				$QuestionnaireID = $resultrow['C'];
	
			// Insert username, questionnaireID, memeid, captionid into questionnaire
 				$query2 = "INSERT INTO Questionnaire (Username, MemeID, CaptionID, QuestionnaireID) VALUES ('$username', '$MemeID', '$CaptionID', '$QuestionnaireID')";
				if(!mysqli_query($conn, $query2)){
					die("Error: " . $query2 . "<br>" . mysqli_error($conn));
				}
			}
			mysqli_free_result($result2);
		}
	}
	
	$_SESSION["MemeID"] = $MemeID;
	$_SESSION["CaptionID"] = $CaptionID;
	
	mysqli_free_result($result);
	mysqli_close($conn);
	header('Location: memeDisplay.php', TRUE, 302);
	exit();
?>


<html>
<head></head>
<body>
	nerd
</body>
</html>