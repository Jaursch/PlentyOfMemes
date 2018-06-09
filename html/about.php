<!DOCTYPE html>
<?php
	$currentpage="About";
	include "pages.php";
?>
<html>
	<head>
		<title>About MemeMe</title>
		<link rel="stylesheet" href="spectre.min.css">
	</head>

	<body>
		<?php
			// Connect to database
			include 'connectvars.php';
			include 'header.php';

			$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
			if(!$conn){
				die('Could not connect: ' . mysql_error());
			}











			mysqli_free_result($result);
			mysqli_close($conn);
		?>
	</body>
</html>

