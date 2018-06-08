<!DOCTYPE html>
<!-- addParts is now signUp -->
<?php
		$currentpage="Sign Up";
		include "pages.php";

?>
<html>
	<head>
		<title>Sign Up</title>
		<link rel="stylesheet" href="spectre.min.css">
		<script type = "text/javascript"  src = "formVerify.js" > </script>
	</head>
<body>


<?php
	include "header.php";
	$msg = "Enter your information below to create an account";

// change the value of $dbuser and $dbpass to your username and password
	include 'connectvars.php';

	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if (!$conn) {
		die('Could not connect: ' . mysql_error());
	}
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

// Escape user inputs for security
		$username = mysqli_real_escape_string($conn, $_POST['username']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);

// See if username is already in the table
		$queryIn = "SELECT * FROM User where Username='$username' ";
		$resultIn = mysqli_query($conn, $queryIn);
		if (mysqli_num_rows($resultIn)> 0) {
			$msg ="<h2>Can't Add to Table</h2> There is already a username registered under $username<p>";
		} else {

		//generate salt
		//$salt = base64_encode(mcrypt_create_iv(12 , MCRYPT_DEV_URANDOM));

		// attempt insert query
			$query = "INSERT INTO User (Username, Email, Password) VALUES ('$username', '$email', MD5('$password'))";
			if(mysqli_query($conn, $query)){
				$msg =  "Record added successfully.<p>";
			} else{
				echo "ERROR: Could not able to execute $query. " . mysqli_error($conn);
			}
		}
}
// close connection
mysqli_close($conn);

?>
	<section>
    <h2> <?php echo $msg; ?> </h2>

<form method="post" id="signUpForm">
<fieldset>
	<legend>Input credentials:</legend>
    <p>
        <label for="User">Username:</label>
        <input type="text" class="required" name="username" id="username">
		</p>
  	<p>
        <label for="Email">Email:</label>
        <input type="text" class="required" name="email" id="email">
		</p>
		<p>
        <label for="Password">Password:</label>
        <input type="text" class="required" name="password" id="password1">
		</p>
		<p>
        <label for="VerifyPassword">Re-Enter Password:</label>
        <input type="text" class="required" name="verify password" id="password2">
		</p>
</fieldset>

      <p>
        <input type = "submit"  value = "Submit" />
        <input type = "reset"  value = "Clear Form" />
      </p>
</form>
</body>
</html>
