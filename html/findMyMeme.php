<?php
		include 'sessionheader.php';
?>
<!DOCTYPE html>
<?php
	$currentpage="Find Meme";
	include "pages.php";
?>
<html>
	<head>
		<title>Meme Finder</title>
		<link rel="stylesheet" href="spectre.min.css">
	</head>

	<body>
		<?php
			// Connect to database
	//		include 'connectvars.php';
			include 'header.php';

	//		$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	//		if(!$conn){
	//			die('Could not connect: ' . mysql_error());
	//		}

	//		mysqli_free_result($result);
	//		mysqli_close($conn);
		?>
		<table style="width:100%"><tr>
			<td style="width:50%">
				<div class="card" style="margin:10px">
					<div class="card-header">
						<div class="card-title h5">
							Random Meme
						</div>
						<div class="card-subtitle text-gray">
							Find a completely, certifiably random meme!
						</div>
					</div>
					<div class="card-body">
						<a href="randomMeme.php"><button class="btn btn-primary" id='randomMeme'>Find my meme!</button></a>
					</div>
				</div>
			</td>
			<td style="width:50%">
				<div class="card" style="margin:10px">
					<div class="card-header">
						<div class="card-title h5">
							Questionnaire
						</div>
						<div class="card-subtitle text-gray">
							Answer a set of questions to find a meme perfect for your tastes
						</div>
					</div>
					<div class="card-body">
						<button class="btn btn-primary" id='takeQuiz' onclick="location.href='questionnaire.php';">Take the quiz!</button>
					</div>
				</div>
			</td>
		</tr></table>
	</body>
</html>

