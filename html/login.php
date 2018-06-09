<!DOCTYPE html>
<!-- Add Supplier Info to Table Supplier -->
<?php
		$currentpage="Login";
		include "pages.php";

?>
<html>
	<head>
		<title>Add Supplier</title>
		<link rel="stylesheet" href="spectre.min.css">
		<!-- don't need js? -->
		<script type = "text/javascript"  src = "formVerify.js" > </script>
	</head>
<body>


<?php
	include "header.php";
	$msg = "Login with your account information: ";

// change the value of $dbuser and $dbpass to your username and password
	include 'connectvars.php';

	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if (!$conn) {
		die('Could not connect: ' . mysql_error());
	}
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

// Escape user inputs for security
		$username = mysqli_real_escape_string($conn, $_POST['username']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);

// See if username and password are in the system
		$queryIn = "SELECT Username FROM User where Username='$username' AND Password = MD5('$password')";
		$resultIn = mysqli_query($conn, $queryIn);
		if($row = mysqli_fetch_assoc($resultIn)){
			$msg = "<h2>You're Logged In $username!</h2>";
		}
		else{
			$msg = "<h2>Error</h2> Username and password combination not found";
		}

		//if (mysqli_num_rows($resultIn)> 0) {
		//	$msg ="<h2>Can't Add to Table</h2> There is already a supplier with sid $sid<p>";
		//} else {

/*/		// attempt insert query
			$query = "INSERT INTO Supplier (sid, sname, city) VALUES ('$sid', '$sname', '$city')";
			if(mysqli_query($conn, $query)){
				$msg =  "Record added successfully.<p>";
			} else{
				echo "ERROR: Could not able to execute $query. " . mysqli_error($conn);
			}
		}/*/
}
// close connection
mysqli_close($conn);

?>
	<section>
    <h2> <?php echo $msg; ?> </h2>

<form method="post" id="signUpForm">
<fieldset>
	<legend>Login Info:</legend>
    <p>
        <label for="Username">Username:</label>
        <input type="text" class="form-input" name="username" id="username">
    </p>

    <p>
        <label for="Password">Password:</label>
        <input type="text" class="form-input" name="password" id="password">
</fieldset>

      <p>
        <input type = "submit"  value = "Submit" class = "btn"/>
    <!--    <input type = "reset"  value = "Clear Form" />  -->
      </p>
</form>
</body>
</html>
