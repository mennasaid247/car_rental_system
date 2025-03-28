<?php

include "connection.php";
session_start();

if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirmpassword']) && isset($_POST['phone'])&& isset($_POST['city'])) {
	function validate($entry) {
			// Trim leading and trailing whitespaces, remove backslashes, and convert special characters to HTML entities
			return htmlspecialchars(stripslashes(trim($entry)));
	}

	$name=validate($_POST['name']);
	$email=validate($_POST['email']);
	$password=validate($_POST['password']);
	$confirmpassword=validate($_POST['confirmpassword']);
	$phone=validate($_POST['phone']);
	$city=validate($_POST['city']);
	$v1='@';
	$v2='.';

	if(empty($name) && empty($email) && empty($password)) {
          echo "<script>
            alert('E-mail , Name & password Empty!');
            </script>";
						header("Refresh:0;user_signup.html");
						exit();
	}

	else if(empty($email) && empty($password)) {
         echo "<script>
            alert('E-mail and Password Empty!');
            </script>";
						header("Refresh:0;user_signup.html");
						exit();
	}

	else if(empty($name)) {
		//alert("Name Missing.");
		//header("Location: usersign.php?error=Name required.");
		//exit();
					echo "<script>
            alert('Name required.');
            </script>";
						header("Refresh:0;user_signup.html");
						exit();
	}

	else if(empty($email)) {
		//alert("E-mail Missing.");
		//header("Location: usersign.php?error=Email required.");
		//exit();
					echo "<script>
            alert('E-mail required.');
            </script>";
						header("Refresh:0;user_signup.html");
						exit();
	}

		else if(strpos($email,$v1) == false || strpos($email,$v2) == false) {
		//	alert("E-mail is invalid. Please Re-enter E-mail.");
		//header("Location: usersign.php?error=Email invalid.");
		//exit();
					echo "<script>
            alert('E-mail invalid.');
            </script>";
						header("Refresh:0;user_signup.html");
						exit();
	}

	else if(empty($password)) {
		//alert("Password Field required.");
		//header("Location: usersign.php?error=Password required.");
		//exit();
					echo "<script>
            alert('Password required.');
            </script>";
						header("Refresh:0;user_signup.html");
						exit();
	}

	else if(empty($confirmpassword)) {
		//alert("Password confirmation required.");
		//header("Location: usersign.php?error=Password confirmation required.");
		//exit();
					echo "<script>
            alert('Password confirmation required.');
            </script>";
						header("Refresh:0;user_signup.html");
						exit();
	}

	else if(empty($phone)) {
	//	alert("Phone number required.");
	//header("Location: usersign.php?error=Phone required.");
	//exit();
				echo "<script>
            alert('Phone required.');
            </script>";
						header("Refresh:0;user_signup.html");
						exit();
	}

	else if(empty($city)) {
	//	alert("City Required to be entered.");
	//header("Location: usersign.php?error=City required.");
	//exit();
				echo "<script>
            alert('City required.');
            </script>";
						header("Refresh:0;user_signup.html");
						exit();
	}

	else if($password !== $confirmpassword) {
		//alert("Passwords Do not match please try again.");
		//header("Location: usersign.php?error=Password confirmation incorrect.");
		//exit();
					echo "<script>
            alert('Password and confirmation do not match.');
            </script>";
						header("Refresh:0;user_signup.html");
						exit();
	}

	else{
		$password = md5($password);
		$sql1="SELECT * FROM customer WHERE cust_email='$email'";
		$result=mysqli_query($conn,$sql1);
    $sql11="SELECT * FROM customer WHERE cust_password='$password'";
		$result1=mysqli_query($conn,$sql11);
    $sql12="SELECT * FROM customer WHERE cust_pn='$phone'";
		$result12=mysqli_query($conn,$sql12);

    if(mysqli_num_rows($result1) > 0)
    {
      echo "<script>
         alert('Password already used!');
         </script>";
         header("Refresh:0;user_signup.html");
         exit();
    }
    if(mysqli_num_rows($result12) > 0)
    {
      echo "<script>
         alert('Phone number already exists!');
         </script>";
         header("Refresh:0;user_signup.html");
         exit();
    }
		if(mysqli_num_rows($result) > 0){
         echo "<script>
            alert('E-mail already used!');
            </script>";
						header("Refresh:0;user_signup.html");
						exit();
		}
		else if(mysqli_num_rows($result) == 0){
			$sql2="INSERT INTO customer(cust_name,cust_email,cust_password,cust_pn,cust_address_city) VALUES('$name','$email','$password','$phone','$city')";
			$result2=mysqli_query($conn,$sql2);
			$sql3="SELECT * FROM customer WHERE cust_email='$email' AND cust_password='$password'";
			$result3=mysqli_query($conn,$sql3);
			if(mysqli_num_rows($result3)== 1){
			$row = mysqli_fetch_assoc($result3);
			$_SESSION['ssid'] = $row['cust_id'];

			header("Location:user_controlled.php");

		    }
	    }
    }
}
?>
