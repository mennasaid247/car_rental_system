<!DOCTYPE html>
<html>
	<head>
		<title>User PAGE</title>
		<link rel="stylesheet" href="style_user.css">
	</head>
<body>
		<div class="topnav">
 		<a class="active" href=user_controlled.php>Make Reservation</a>
		<a href=cars.php>Cars</a>
		<a href=user_res.php>View Reservations</a>
		<a class="logout" href=mainpage.php>LOGOUT</a>
		</div>
	<div class="CRes">
		<br><h3>MAKE A RESERVATION</h3>
		<form method ="post">
		<label>Car Plate ID:</label>
		<input type="text" name="car_id" placeholder="Plate ID"/>
		<label>Pickup Date:</label>
		<input type="date" name="pick_date" placeholder="Pickup Date"/>
		<label>Return Date:</label>
		<input type="date" name="ret_date" placeholder="Return Date"/><br><br>
		<button type="submit" name="Reserve" value="Make Reservation" class="btn btn-primary"> Reserve </button>
		</form>
	</div>
	<?php
	  include "connection.php";
	  session_start();
		if( isset($_POST['car_id']) && isset($_POST['pick_date']) && isset($_POST['ret_date'])){
		/*	function validate($entry){
			$entry=trim($entry);
			$entry=stripslashes($entry);
			$entry=htmlspecialchars($entry);
			return $entry;
			}
		*/

    $cid=$_POST['car_id'];
		$p=$_POST['pick_date'];
		$r=$_POST['ret_date'];
		$sid=$_SESSION['ssid'];
		if(empty($p) && empty($r) && empty($cid)) {
       echo "<script>
            alert('Reservation Information Required.');
            </script>";
						header("Refresh:0");
						exit();
		}

		if(empty($cid)) {

						echo "<script>
            alert('Car plate id required.');
            </script>";
						header("Refresh:0");
						exit();
		}


	if(empty($p)) {

					echo "<script>
		            alert('Pickup date required.');
		            </script>";
								header("Refresh:0");
								exit();
				}

		if(empty($r)) {

						echo "<script>
            alert('Return date required.');
            </script>";
						header("Refresh:0");
						exit();

		}
//////////////////////////////////////////////////////////////////////////stoppedd hereee////////////////////////////////////////
		$queryy = "SELECT reservation.car_id FROM reservation
		WHERE reservation.car_id='$cid' AND (reservation.reservation_return_date>'$p'
		OR reservation.reservation_pickup_date<'$r' AND reservation.reservation_return_date>'$r')";
    //to check that the car being inserted is not already reserved
   $resultt= mysqli_query($conn, $queryy);
		echo mysqli_num_rows($resultt);///////////////////////
		if(mysqli_num_rows($resultt)!= 0){
      echo "<script>
            alert('Car is reserved during this period!');
            </script>";
						header("Refresh:0");
						exit();
	    }
   $q_office="SELECT office_id FROM office WHERE office_location_city IN (SELECT cust_address_city FROM customer WHERE cust_id='$sid')";
	  $resultoffice=mysqli_query($conn,$q_office);
			if(mysqli_num_rows($resultoffice)== 0){
	      echo "<script>
	            alert('No office in your city.');
	            </script>";
							header("Refresh:0");
							exit();
		    }
			else{
				$rowoff = mysqli_fetch_assoc($resultoffice);
				$o = $rowoff['office_id'];
		    }

		$q_price="SELECT car_price FROM car WHERE car_id='$cid'";
		$resultprice=mysqli_query($conn,$q_price);
		if(mysqli_num_rows($resultprice)== 1){
			$rowp = mysqli_fetch_assoc($resultprice);
			$price = $rowp['car_price'];
	    }
		$pd = new DateTime($p);
		$rd = new DateTime($r);
		$daysReserved = $pd->diff($rd)->format("%a"); // calculate how many days the car is reserved to get the total paid price
		$totalPrice=$daysReserved*($price);
		$d=date('Y-m-d');

		$q="INSERT INTO reservation(cust_id,car_id,reservation_date,office_id,reservation_payment,reservation_pickup_date,reservation_return_date)
		 VALUES ('$sid','$cid','$d','$o','$totalPrice','$p','$r')";
		 $result=mysqli_query($conn,$q);
		 /////// add  update car status hereee MISSIING//////////
    ///////////////////////////////////////////////////----->>>>>>>
		$q1="SELECT reservation_payment FROM reservation WHERE reservation.car_id='$cid' AND reservation.cust_id='$sid' AND reservation_date='$d'
		AND reservation.office_id='$o' AND reservation_payment='$totalPrice' AND reservation_pickup_date='$p' AND reservation_return_date='$r'";
		$result1=mysqli_query($conn,$q1);
		if(mysqli_num_rows($result1)== 1){
     $paid =  mysqli_fetch_assoc($result1);

			echo '<script type="text/javascript">alert("YOUR CAR IS RESERVED SUCCESSFULLY!, your payment is '.$paid['reservation_payment'].' $");</script>';
						header("Refresh:0");
						exit();
	    }
		}
		?>
</body>
</html>
