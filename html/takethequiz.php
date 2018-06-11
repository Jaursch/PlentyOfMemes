<?php
		include 'sessionheader.php';
?>
<!DOCTYPE html>

<?php
	$currentpage="Take the Quiz!";
	include "pages.php";
?>

<html>
	<head>
		<title>Take the Quiz!</title>
		<link rel="stylesheet" href="spectre.min.css">
	<!--	<script type = "text/javascript"  src = "verify.js" > </script> -->
	</head>
</html>	

<body>

	<?php
		include 'header.php';
		include 'connectvars.php';
		$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 
		if (!$conn) {
			die('Could not connect: ' . mysql_error());
		}

		$queryIn = "SELECT * FROM Question";

		$result = mysqli_query($conn, $queryIn);
		if (!$result) {
			die("Query to show fields from table failed");
		}
	
		// get list of questions and put it in an array
		echo "<section>	<h2>Complete the questionnaire below to get your results!</h2>";

		
				while($row = mysqli_fetch_assoc($result)){
					echo "<form method='post' id='addForm'>";
						echo "<fieldset>";
					
						//echo $row[1];
						$question = $row['Text'];
						$queryAnswer = "SELECT * FROM Answer WHERE QID = ".$row["QID"];
						$answers = mysqli_query($conn, $queryAnswer);
						if(!$answers){
							die("Query to find answer for question ".$row["QID"]." failed");
						}
						echo '<p> '.$question.':</p>';
						while($answer = mysqli_fetch_assoc($answers)){
							echo '<input type="radio" name="choice" value="'.$answer["AnswerID"].'"> ' . $answer["Text"];
						}
					
						mysqli_free_result($answers);
						echo "</fieldset><br>";
					echo "</form>";
				}
				mysqli_free_result($result);


		echo "<form method='post' id='addForm'>";		
			echo "<p>";
				echo "<input type = 'submit' value = 'Submit' />";
				echo "<input type = 'reset' value = 'Clear Form' />";
			echo "</p>";
		echo "</form>";
		mysqli_close($conn);
	?>
</body>
</html>		
			











