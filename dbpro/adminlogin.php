<?php

include "connection.php";
session_start();

if(isset($_POST['email']) && isset($_POST['password'])) {

	function validate($entry) {
	    // Trim leading and trailing whitespaces, remove backslashes, and convert special characters to HTML entities
	    return htmlspecialchars(stripslashes(trim($entry)));
	}

	$email=validate($_POST['email']);
	$password=validate($_POST['password']);
	$v1='@';
	$v2='.';
	if(empty($email) && empty($password)) {
		echo "<script>
            alert('Enter Login Information');
            </script>";
			header("refresh:0; adminlogin.html");
					exit();
	}

	else if(empty($email)) {
		echo "<script>
            alert('Your Email Address is empty please fill it.');
            </script>";
			header("refresh:0; adminlogin.html");
		exit();
	}

	else if(empty($password)) {
		echo "<script>
            alert('Your Password is empty plese fill it.');
            </script>";
			header("refresh:1; adminlogin.html");
		exit();
	}

	else if(strpos($email,$v1) == false || strpos($email,$v2) == false) {
		echo "<script>
		alert('Email does not exist!');
		</script>";
		header("refresh:0; adminlogin.html");
		exit();
	}

	else{
		$password = md5($password);
		$sql="SELECT * FROM admin WHERE email='$email' AND password='$password'";
		$r=mysqli_query($conn,$sql);
		if(mysqli_num_rows($r)!= 1){
			echo "<script>
            alert('Incorrect.');
            </script>";
			header("refresh:0; adminlogin.html");
		exit();
		}
		else if(mysqli_num_rows($r)== 1){
		/*	echo "<script>
			alert('Right information.');
			</script>";*/
		header("Location: AdminMAIN.html");
		exit();
		}
	}

}

?>
