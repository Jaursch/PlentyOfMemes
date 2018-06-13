<?php
	include 'sessionheader.php';
	include 'connectvars.php'; 

	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 
	if (!$conn) {
		die('Could not connect: ' . mysql_error());
	}
	
	// Receive and process answers
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
			
		// Assemble a list of the answers submitted
		$answerIDs = array();
		$questionlenQuery = "Select * FROM Question"; // Need the QID of each question
		$result = mysqli_query($conn, $questionlenQuery);
		if (!$result) {
			die("Query to find number of entries in Question failed");
		}
		
		// Push each answer ID onto the array
		while($questionlen = mysqli_fetch_assoc($result)){
			$answerIDs[$questionlen["QID"]] = $_POST[$questionlen["QID"]];
		}
//		print_r($_POST);
		$selectedAnswer = $answerIDs[array_rand($answerIDs)];// Random element
		if(!$selectedAnswer){
			header('Location: takethequiz.php');
			exit();
		}
		
		$answerQuery = "Select Mood, Style, Humor, Woke, Crazy from Answer WHERE answerID = $selectedAnswer";
		$answerResult = mysqli_query($conn, $answerQuery);
		if (!$answerResult) {
			die("Error: " . $answerQuery . "<br>" . mysqli_error($conn));
		}
			
		$answerParams = mysqli_fetch_assoc($answerResult);
		$selectedParam = array_rand($answerParams); // We operate on a random parameter
		
//		echo "<br>Target param: $selectedParam <br> Target value:".$answerParams[$selectedParam]."<br>";
		
		// Select all captions where the caption's param + the meme's param is equal to the selected parameter of the selected answer
		$memeQuery = "SELECT C.* FROM Caption C, Meme M WHERE C.MemeID=M.MemeID AND ".$answerParams[$selectedParam]."=(C.".$selectedParam."+M.".$selectedParam.")";
		$memeResult = mysqli_query($conn, $memeQuery);
		if (!$memeResult) {
			die("Error: " . $memeResult . "<br>" . mysqli_error($conn));
		}
			
		// Assemble the list of candidate memes into an array containing captionIDs and memeIDs
		$possMemes = array();
		while($candidate = mysqli_fetch_assoc($memeResult)){
			array_push($possMemes, array($candidate["CaptionID"], $candidate["MemeID"]));
		}
		
		// If we didn't get any matches, check a different parameter and answer
		if(!count($possMemes)){
			header('Location: takethequiz.php');
			exit();
		}
		
//		print_r($possMemes);
		// Move a random candidate to the front of the array
		shuffle($possMemes);
		$selectedMeme = $possMemes[0];
		$CaptionID = $selectedMeme[0];
		$MemeID = $selectedMeme[1];
			
//		echo "<br>Caption ID: $CaptionID <br>Meme ID: $MemeID <br>";
			
		// Insert matched meme into Questionnaire
		$QuestionnaireID = -1; // Need it declared in this scope. If we see negative values we'll know something borked
		if(isset($_SESSION["user"])){
			$username = $_SESSION["user"];
			$questionnaireIDQuery = "SELECT COUNT(*) as C FROM (SELECT * FROM Questionnaire WHERE Username = '$username') as A";
			if($quIDresult = mysqli_query($conn, $questionnaireIDQuery)){
				$resultrow = mysqli_fetch_assoc($quIDresult);
				$QuestionnaireID = $resultrow['C'];
		
				// Insert username, questionnaireID, memeid, captionid into questionnaire
				$quInsertQuery= "INSERT INTO Questionnaire (Username, MemeID, CaptionID, QuestionnaireID) VALUES ('$username', $MemeID, $CaptionID, $QuestionnaireID)";
				if(!mysqli_query($conn, $quInsertQuery)){
					echo "Error: " . $quInsertQuery . "<br>" . mysqli_error($conn);
				}
			}
			
			if($QuestionnaireID != -1){
				// Insert answers into QuestionList -- MUST COME AFTER QUESTIONNAIRE
				foreach($answerIDs as $QID => $aID){
					$quListInsertQuery = "INSERT INTO QuestionList (Username, QID, AnswerID, QuestionnaireID) VALUES ('$username', $QID, $aID, $QuestionnaireID)";
					if(!mysqli_query($conn, $quListInsertQuery)){
						echo "Error: " . $quListInsertQuery . "<br>" . mysqli_error($conn);
					}
				}
			}
			mysqli_free_result($quIDresult);
		}
		
		// Display meme
		$_SESSION["CaptionID"] = $CaptionID;
		$_SESSION["MemeID"] = $MemeID;
		
		mysqli_free_result($result);
		mysqli_free_result($answerResult);
		mysqli_free_result($memeResult);
		
		mysqli_close($conn);
		header('Location: memeDisplay.php', TRUE, 302); // Redirect to the display page
		exit();
	}
?>