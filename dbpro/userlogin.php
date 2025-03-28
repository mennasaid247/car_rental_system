<!DOCTYPE html>
<html>
	<head>
		<title>User Login</title>
		<link rel="stylesheet" href="style_user.css">

	</head>
	<script>
  function validateForm() {
    let x = document.forms["Login-Form"]["email"].value;
    let y = document.forms["Login-Form"]["password"].value;
	if (x == "" && y== "") {
      alert("Please Enter Your E-mail and Your Password ");
      return false;
    }
	else if (x == "")
	{
		alert("Please Enter Your E-mail Address.");
      return false;
	}
	else if(y== "")
	{
		alert("Please Enter Your Password.");
      return false;
	}

  }
  </script>
<body>
<div class="topnat">
 		<a href=mainpage.php>Back</a>
		</div>
	<div class="LoginForm">
		<form name="Login-Form" action="userloginconecdb.php" onsubmit="return validateForm()" method="post">
		<h2>User Login</h2>
		<label>Enter Email:</label>
		<input type="email" name="email" placeholder="Email"/><br>
		<br>
		<label>Enter Password:</label>
		<input type="password" name="password" placeholder="Password"/><br>
		<br>
		<input type="submit" name="submit" value="Login" class="btn-login"/><br>
		<div class="USERSIUP">
		<label>Don't have an account</label>
		<a href=user_signup.html>Sign Up</a>
		</div>

	</form>
		</div>
</body>
</html>
