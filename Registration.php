<!DOCTYPE html>
<html lang="en">
<head>
<title>Registration</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="registration.css">
 
 <style>
  button {
  background-color: #B796AC;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}
  </style>
  
</head>
<body>

<div  id="id01" class="modal">
	 	<div class="modal-dialog">
			<div class="modal-content"> 
				<div class="modal-header">
				<h4 class="modal-title">Notification</h4>
				</div>
					<div class="modal-body">
					You are registered successfully!
					Click here to <a href='Login.php'>sign in</a>
					</div>
					<div class="modal-footer">
				<button type="button" class="btn" onclick="closeModal()">Ok</button>
					</div>
			</div>
		</div>
	</div>
	<script>
function closeModal() {
  document.getElementById("id01").style.display = "none";
}
</script>


<?php
 mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$servername = "localhost";
			$username = "root";
			$password = "fgfyfctyrj";
			$dbname = "news";

			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			} 
// If form submitted, insert values into the database.
if (isset($_POST['submit'])){
        // removes backslashes
	$login = stripslashes($_POST['login']);
        //escapes special characters in a string
	$login = mysqli_real_escape_string($conn,$login); 
	$password = stripslashes($_POST['psw']);
	$password = mysqli_real_escape_string($conn,$password);
	date_default_timezone_set('Europe/Ljubljana');
	$trn_date = date("Y-m-d H:i:s");
        $query = "INSERT into `users` (username, password, trn_date)
VALUES ('$login', '".md5($password)."','$trn_date')";
        $result = mysqli_query($conn,$query);
        if($result){
             echo '<script>';
echo 'document.getElementById("id01").style.display="block"';
echo '</script>';
        }
    else{echo 'Error' . $query . "<br>" . $conn->error;
}}
$conn->close();

?>

<form onsubmit="return validate_form();"  method="post" >
  <div class="container">
    <h1>Sign up</h1>
    <p>Please fill in this form to create an account.</p>
    <hr>

    <label for="email"><b>Login</b></label>
    <input type="text" placeholder="Enter login" id="email" name="login" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" id ="psw" name="psw" required>

    <label for="psw-repeat"><b>Repeat Password</b></label>
    <input type="password" placeholder="Repeat Password" id="psw-repeat" name="psw-repeat" onchange="validate_repeat_password();" required>
	<input type ="hidden" id="repeat_password_error"></input>
    <hr>
    

    <button type="submit" class="registerbtn" name="submit">Sign up</button>
  </div>
 <script>
			function validate_repeat_password(){
			let input_field = document.getElementById("psw");
			let input_value = input_field.value;
			let input_field_repeat = document.getElementById("psw-repeat");
			let input_value_repeat = input_field_repeat.value;
			if(input_value_repeat != input_value ){
				document.getElementById("repeat_password_error").value = "Passwords do not match";
				document.getElementById("id02").style.display="block";
			}
			else {
				document.getElementById("repeat_password_error").value = "";
			}
		}
		function validate_form(){
			validate_repeat_password();
			if(document.getElementById("repeat_password_error").value != ""){
				return false;
			}
			return true;
		}
			</script>
			
			<div  id="id02" class="modal">
	 	<div class="modal-dialog">
			<div class="modal-content"> 
				<div class="modal-header">
				<h4 class="modal-title">Notification</h4>
				</div>
					<div class="modal-body">
					Password do not match!
					</div>
					<div class="modal-footer">
				<button type="button" class="btn-danger" onclick="closeModal1()">Ok</button>
					</div>
			</div>
		</div>
	</div>
	<script>
function closeModal1() {
  document.getElementById("id02").style.display = "none";
}
</script>
  <div class="container signin">
    <p>Already have an account? <a href="Login.php">Sign in</a>.</p>
  </div>
</form>

</body>
</html>
