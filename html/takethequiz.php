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
		$msg = "Complete the questionnaire below to get your results!";
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
		$questionList = array();
		$i = 0;
		while($row = mysqli_fetch_array($result)){
			//echo $row[1];
			$questionList[] = $row['1'];
			$iterator = $i+1;
			$i++;
		}
		$num = 0;
		$answerList = array();
		// loop over question list
		for($k = 1; $k <= $i; $k++){
			$queryIn = "SELECT * FROM Answer WHERE QID = $k";	// execute query to get list of answers
			$result = mysqli_query($conn, $queryIn);
			while ($row = mysqli_fetch_array($result)) { // loop over query results to put 
   				$answerList[] =  $row;  	// trying to fill 2d array where the rows correspond to the questions in order and the cols correspond to the individual answers. This is clearly not working
   				$num++;
			}
			mysql_free_result($result);

		}	

		mysqli_close($conn);
	?>


	<section>
		<h2> <?php echo $msg; ?> </h2>
	<form method="post" id="addForm">
		<fieldset>
			<legend>Quiz</legend>	
			<?php
				for($x = 0; $x < $i; $x++){
					echo '<p> ' . $questionList[$x] . ':</p>';
					// echo '<p>' . count($answer[$x]) . '</p>';
					for($j = 0; $j < $num; $j++){
						echo '<input type="radio" name="choice" value="' . $answer[$x][$j] . '"> ' . $answer[$x][$j];
						// echo '<p> FUCK </p>';
					
					}
				}
				// echo '</p>';
			?>
		</fieldset>
		<p>
			<input type = "submit" value = "Submit" />
			<input type = "reset" value = "Clear Form" />
		</p>
	</form>
</body>
</html>		
			











