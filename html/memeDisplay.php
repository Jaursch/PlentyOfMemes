<?php
		include 'sessionheader.php';
?>
<!DOCTYPE html>
<?php
		$currentpage="FindMyMeme";
		include "pages.php";
?>
<html>
	<head>
		<title>Display Meme</title>
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
			$query = "SELECT M.Image_URL as Image_URL, C.Text as Text FROM Meme M, Caption C WHERE C.MemeID=M.MemeID AND M.MemeID=".$_SESSION['MemeID']." AND CaptionID=".$_SESSION['CaptionID'];
	
		// Get results from query
			$result = mysqli_query($conn, $query);
			if (!$result) {
				die("Query to show fields from table failed");
			}
	
			if($row = mysqli_fetch_assoc($result)){
				$url 		= $row["Image_URL"];
				$caption 	= $row["Text"];
				
				echo "<img src='".$url."' alt='Cover' style='max-width:25%;display:block;margin-left:auto;margin-right:auto'><div style='margin:auto;margin-top:10px;width:20%;text-align:center'>".$caption."</div>";
			}

			mysqli_free_result($result);
			mysqli_close($conn);
		?>
	</body>

</html>