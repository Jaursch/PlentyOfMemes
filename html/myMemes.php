<!DOCTYPE html>
<?php
		include 'sessionheader.php';
		$currentpage="Home";
		include "pages.php";
?>
<html>
	<head>
		<title>MemeMe Home</title>
		<?php include "stylesheet.html"; ?>
	</head>

	<body>

		<?php
      //find the username to find the user's memes
      $username = $_SESSION["user"];

		// change the value of $dbuser and $dbpass to your username and password
			include 'connectvars.php';
			include 'header.php';

			$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
			if (!$conn) {
				die('Could not connect: ' . mysql_error());
			}

		// query to select all information from supplier table
			$query = "SELECT DISTINCT Image_URL, Questionnaire.CaptionID, Questionnaire.MemeID, Text, username FROM Meme INNER JOIN Caption INNER JOIN Questionnaire On Meme.MemeID = Questionnaire.MemeID AND Caption.CaptionID = Questionnaire.CaptionID WHERE username = '".$username."';";

		// Get results from query
			$result = mysqli_query($conn, $query);
			if (!$result) {
				die("Query to show fields from table failed");
			}

		// get number of columns in table
			$fields_num = mysqli_num_rows($result);
			echo $fields_num;
			if(isset($_SESSION["user"])){
				if ($fields_num == 0) {
					echo "<h2 style='text-align: center; padding-top: 20px;'>You have no memes, <em>$username!</em></h2>";
				}else{
				echo "<h1 style='text-align: center'>$username's Memes:</h1>";
				}
			}else{
				echo "<h2 style='text-align: center; padding-top: 20px;'>You aren't logged in. You have no memes!</h2>";
			}
			echo "<table class='table'><tr>";

		// printing table headers
			for($i=0; $i < $fields_num/4; $i++){
				echo "<tr>";
				for($j=0; $j < 4; $j++){
					if($row = mysqli_fetch_assoc($result)){
						$url=$row["Image_URL"];
						$caption=$row["Text"];
						echo "<td style='width:25%'><div style='max-width: 100%; display: block; margin-left: auto; margin-right: auto;'><img src='".$url."' alt='Cover' style='width:100%; max-width: 500px; display: block; margin-left: auto; margin-right: auto;'></div><div style='text-align:center;'>".$caption."</div></td>";
					}
				}
				echo "</tr>\n";
			}

			mysqli_free_result($result);
			mysqli_close($conn);
		?>
	</body>

</html>
