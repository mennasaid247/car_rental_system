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
		//alert("Please Enter Your E-mail Address & Password.");
		//header("Location: userlog.php?error=Email and Password required.");
		//exit();
								echo "<script>
            alert('Enter E-mail and Password.');
            </script>";
						header("Refresh:0;userlogin.php");
						exit();
	}

	else if(empty($email)) {
		//header("Location: userlog.php?error=Email required.");
		//exit();
										echo "<script>
            alert('Enter E-mail.');
            </script>";
						header("Refresh:0;userlogin.php");
						exit();
	}

	else if(empty($password)) {

										echo "<script>
            alert('Enter Password.');
            </script>";
						header("Refresh:0;userlogin.php");
						exit();
	}

	else if(strpos($email,$v1) == false || strpos($email,$v2) == false) {

										echo "<script>
            alert('Invalid E-mail.');
            </script>";
						header("Refresh:0;userlogin.php");
						exit();
	}


	else{
		$password = md5($password);
		$sql="SELECT * FROM customer WHERE cust_email='$email' AND cust_password='$password'";
		$result=mysqli_query($conn,$sql);
		if(mysqli_num_rows($result)!= 1){
								echo "<script>
            alert('Login information incorrect.');
            </script>";
						header("Refresh:0;userlogin.php");
						exit();
		}
		else if(mysqli_num_rows($result)== 1){
			$row = mysqli_fetch_assoc($result);
			$_SESSION['ssid'] = $row['cust_id'];/// take caree
			/*echo "<script>
			alert('Right information.');
			</script>";*/
			//echo 'Welcome, '.$_SESSION['name'].'.';
			header("Location: user_controlled.php");//// 3adell henaaa
			exit();
		}
	}

}

?>











<?php

include "db_conn.php";
session_start();

if (isset($_POST['email']) && isset($_POST['password'])) {

    function validate($entry)
    {
        $entry = trim($entry);
        $entry = stripslashes($entry);
        $entry = htmlspecialchars($entry);
        return $entry;
    }

    function isValidEmail($email)
    {
        // Use a regular expression to check for a valid email format
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $v1 = '@';
    $v2 = '.';

    if (empty($email) && empty($password)) {
        echo "<script>
            alert('Enter E-mail and Password.');
            </script>";
        header("Refresh:0;userlogin.php");
        exit();
    } else if (empty($email)) {
        echo "<script>
            alert('Enter E-mail.');
            </script>";
        header("Refresh:0;userlogin.php");
        exit();
    } else if (!isValidEmail($email)) {
        echo "<script>
            alert('Invalid E-mail format.');
            </script>";
        header("Refresh:0;userlogin.php");
        exit();
    } else if (empty($password)) {
        echo "<script>
            alert('Enter Password.');
            </script>";
        header("Refresh:0;userlogin.php");
        exit();
    } else {
        $password = md5($password);
        $sql = "SELECT * FROM customer WHERE cust_email='$email' AND cust_password='$password'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) != 1) {
            echo "<script>
                alert('Wrong information .');
                </script>";
            header("Refresh:0;userlogin.php");
            exit();
        } else if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['ssid'] = $row['customer_id'];
            header("Location: cusres.php");
            exit();
        }
    }
}

?>
