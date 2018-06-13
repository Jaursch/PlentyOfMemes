<?php
	include 'sessionheader.php';

	$currentpage="Take the Quiz!";
	include "pages.php";
	include 'connectvars.php';
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 
	if (!$conn) {
		die('Could not connect: ' . mysql_error());
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Take the Quiz!</title>
		<link rel="stylesheet" href="spectre.min.css">
	<!--	<script type = "text/javascript"  src = "verify.js" > </script> -->
	</head>

<body>

	<?php
		include 'header.php';
	?>
	<section>
		<h2>Complete the questionnaire below to get your results!</h2>
		<form method='post' id='addForm' action="processQuiz.php">;
			<fieldset>
				<?php
					$queryIn = "SELECT * FROM Question";

					$result = mysqli_query($conn, $queryIn);
					if (!$result) {
						die("Query to show fields from table failed");
					}
		
				// get list of questions and put it in an array
					while($row = mysqli_fetch_assoc($result)){
					
						$question = $row['Text'];
						$queryAnswer = "SELECT * FROM Answer WHERE QID = ".$row["QID"];
						$answers = mysqli_query($conn, $queryAnswer);
						if(!$answers){
							die("Query to find answer for question ".$row["QID"]." failed");
						}
						echo '<p> '.$question;
						while($answer = mysqli_fetch_assoc($answers)){
							echo '<input type="radio" name="'.$row["QID"].'" value="'.$answer["AnswerID"].'"> ' . $answer["Text"];
						}
						echo "</p>";
						mysqli_free_result($answers);
					}
					mysqli_free_result($result);
				?>
			</fieldset><br>
			<p>
				<input type = 'submit' value = 'Submit' />
				<input type = 'reset' value = 'Clear Form' />
			</p>
		</form>
		
	<?php	
		mysqli_close($conn);
	?>
</body>
</html>	