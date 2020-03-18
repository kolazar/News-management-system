<!DOCTYPE html>
<html lang="en">
<head>
	<title>Sign in</title>
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
					Login or password is incorrect!
					</div>
					<div class="modal-footer">
				<button type="button" class="btn-danger" onclick="closeModal1()">Ok</button>
					</div>
			</div>
		</div>
	</div>
	<script>
function closeModal1() {
  document.getElementById("id01").style.display = "none";
}
</script>
<?php
 require('connection.php');
			
			
			session_start();
// If form submitted, insert values into the database.
if (isset($_POST['submit'])){
        // removes backslashes
	$login = stripslashes($_POST['login']);
        //escapes special characters in a string
	$login = mysqli_real_escape_string($conn,$login); 
	$password = stripslashes($_POST['psw']);
	$password = mysqli_real_escape_string($conn,$password);
	$trn_date = date("Y-m-d H:i:s");
         $query = "SELECT * FROM `users` WHERE username='$login'
and password='".md5($password)."'";
	$result = mysqli_query($conn,$query) or die(mysql_error());
	$rows = mysqli_num_rows($result);
        if($rows==1){
	    $_SESSION['username'] = $login;
	    header("Location: Home.php");
        } else{
 echo '<script>';
echo 'document.getElementById("id01").style.display="block"';
echo '</script>';
}}
    
$conn->close();

?>

<form  method = "post">
  <div class="container">
    <h1>Sign in</h1>
    <p>Please fill in this form to sign in.</p>
    <hr>

    <label for="login"><b>Login</b></label>
    <input type="text" placeholder="Enter login" id="login "name="login" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" id="psw" name="psw" required>
    <button type="submit" name="submit" class="registerbtn">Sign in</button>
  </div>
<div class="container signin">
    <p>Don't you have an account? <a href="Registration.php">Sign up</a>.</p>
  </div>
</form>

</body>
</html>