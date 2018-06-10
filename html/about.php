<!DOCTYPE html>
<?php
	include "sessionheader.php";
	$currentpage="About";
	include "pages.php";
?>
<html>
	<head>
		<title>About MemeMe</title>
		<link rel="stylesheet" href="spectre.min.css">
		<link rel="stylesheet" href="extra.css">
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

			$num = 70; //memeids for author page
			$query = "SELECT * FROM Meme WHERE MemeID = $num;";
			// Get results from query
				$result = mysqli_query($conn, $query);
				if (!$result) {
					die("Query to show fields from table failed");

				}

		?>

		<table class="aboutTable">
			<tr class="aboutRow">
				<td class="aboutEntry"><h2 class="aboutName">Matt Forsland</h2>
					<?php
							$result = mysqli_query($conn, $query);
							if (!$result) {
								die("Query to show fields from table failed");
							}$row = mysqli_fetch_assoc($result);
							$url = $row["Image_URL"];
							echo "<div><img class='memeimage' src='".$url."' alt='Cover'></div>";
							$num = $num+1;
						?>
					<p class="Question"><b>Favorite Meme:</b> Spongebob ones </p>
					<p class="Question"><b>Sprit Animal:</b> Dimensional Duck </p>
					<p class="Question"><b>How do you like your coffee:</b> Black as night, hot as hell, strong as love </p>
					<p class="Question"><b>Last time you got in a fight:</b> This morning with my hair </p>
				</td>
				<td class="aboutEntry"><h2 class="aboutName">Ben Windheim VI</h2>
					<?php
						$query = "SELECT * FROM Meme WHERE MemeID = $num;";
						$result = mysqli_query($conn, $query);
						if (!$result) {
							die("Query to show fields from table failed");
						}$row = mysqli_fetch_assoc($result);
						$url = $row["Image_URL"];
						echo "<div><img class='memeimage' src='".$url."' alt='Cover'></div>";
						$num = $num+1;
						?>
					<p class="Question"><b>Favorite Meme:</b> "Kerchoo...." </p>
					<p class="Question"><b>Sprit Animal:</b> Seahorse </p>
					<p class="Question"><b>How do you like your coffee:</b> Non-fat extra soy with room </p>
					<p class="Question"><b>Last time you got in a fight:</b> Tomorrow with the man </p>
				</td>
			</tr>
			<tr class="aboutRow">
				<td class="aboutEntry"><h2 class="aboutName">Alec Hayden</h2>
					<?php
						$query = "SELECT * FROM Meme WHERE MemeID = $num;";
						$result = mysqli_query($conn, $query);
						if (!$result) {
							die("Query to show fields from table failed");
						}$row = mysqli_fetch_assoc($result);
						$url = $row["Image_URL"];
						echo "<div><img class='memeimage' src='".$url."' alt='Cover'></div>";
						$num = $num+1;
					?>
					<p class="Question"><b>Favorite Meme:</b> <iframe src="http://onsizzle.com/embed/i/feels-woke-man-13039085" width="100" height="145" frameBorder="0" class="sizzle-embed" style="max-width:100%;" allowFullScreen></iframe></p>
					<p class="Question"><b>Sprit Animal:</b> Honey Badger </p>
					<p class="Question"><b>How do you like your coffee:</b> Tea is cozy, my guy </p>
						<p class="Question"><b>Last time you got in a fight:</b> At my son's little league baseball game. I still have the ump's tooth </p>
				</td>
				<td class="aboutEntry"><h2 class="aboutName">Burton Jaursch</h2>
					<?php
						$query = "SELECT * FROM Meme WHERE MemeID = $num;";
						$result = mysqli_query($conn, $query);
						if (!$result) {
							die("Query to show fields from table failed");
						}$row = mysqli_fetch_assoc($result);
						$url = $row["Image_URL"];
						echo "<div><img class='memeimage' src='".$url."' alt='Cover'></div>";
						$num = $num+1;

					?>
					<p class="Question"><b>Favorite Meme:</b> Like my children, I can't pick favorites </p>
					<p class="Question"><b>Sprit Animal:</b> Barbara Streisand </p>
					<p class="Question"><b>How do you like your coffee:</b> Milk and suger, nothing else </p>
					<p class="Question"><b>Last time you got in a fight:</b> I am forever in a fight with my crippling depression </p>
				</td>
			</tr>
		</table>





		<?php
			mysqli_free_result($result);
			mysqli_close($conn);
		?>
	</body>
</html>
