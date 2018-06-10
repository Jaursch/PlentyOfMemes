<!DOCTYPE html>
<?php
		include 'sessionheader.php';
		$currentpage="Home";
		include "pages.php";
?>
<html>
	<head>
		<title>MemeMe Home</title>
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
			$query = "SELECT * FROM Meme INNER JOIN Caption USING(MemeID) ORDER BY RAND() LIMIT 16;";

		// Get results from query
			$result = mysqli_query($conn, $query);
			if (!$result) {
				die("Query to show fields from table failed");
			}

		// get number of columns in table
			$fields_num = mysqli_num_fields($result);
			echo "<h1>Daily Memes:</h1>";
			echo "<table class='table'><tr>";

		// printing table headers
			for($i=0; $i < 4; $i++){
				echo "<tr>";
				for($j=0; $j < 4; $j++){
					if($row = mysqli_fetch_assoc($result)){
						$url=$row["Image_URL"];
						$caption=$row["Text"];
						echo "<td style='max-width:25%'><div style='max-width:25%'><img src='".$url."' alt='Cover' style='width:400%'></div><div>".$caption."</div></td>";
					}
				}
				echo "</tr>\n";
			}

			mysqli_free_result($result);
			mysqli_close($conn);
		?>
	</body>

</html>
