<!DOCTYPE html>
<?php
		$currentpage="FindMyMeme";
		include "pages.php";
?>
<html>
	<head>
		<title>Random Meme</title>
		<link rel="stylesheet" href="spectre.min.css">
	</head>
	
	<body>

		<?php
		// change the value of $dbuser and $dbpass to your username and password
			include 'connectvars.php'; 
			include 'header.php';	
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
				
		// 		$username = $_SESSION["user"];
		// 		$query2 = "SELECT COUNT() as C FROM (SELECT * FROM Questionnaire WHERE Username = $username) as A";
		// 		if($result2 = msqli_query($conn, $query)){
		// 			$resultrow = msqli_fetch_assoc($result2);
		// 			$QuestionnaireID = $resultrow["C"];
		// 			msqli_free_result($result2);
			
		// 			Insert username, questionnaireID, memeid, captionid into questionnaire
		// 			$query2 = "INSERT INTO Questionnaire (Username, MemeID, CaptionID, QuestionnaireID) VALUES ($username, $MemeID, $CaptionID, $QuestionnaireID)";
		//	} else {
		//		die("Query to insert matched meme failed");
		//	}
				
				echo "<img src='".$url."' alt='Cover' style='max-width:25%;display:block;margin-left:auto;margin-right:auto'><div style='margin:auto;margin-top:10px;width:20%;text-align:center'>".$caption."</div>";
			}

			mysqli_free_result($result);
			mysqli_close($conn);
		?>
	</body>

</html>