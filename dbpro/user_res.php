<!DOCTYPE html>
<html>
	<head>
		<title>User PAGE</title>
		<link rel="stylesheet" href="style_user.css">
	</head>
<body>
   <div class="topnav">
    <a href=user_controlled.php> Make Reservation</a>
		<a href=cars.php>Cars</a>
    <a class="active" href=user_res.php>View Reservations</a>
		<a class="logout" href=mainpage.php>LOGOUT</a>
		</div>
  <div class="CRes">
  <br><h3>MY RESERVATIONS:</h3>
  <br>
  <?php
  include "connection.php";
  session_start();
  $sid=$_SESSION['ssid'];
  ////revise this QUERYYYYY
  $query = "SELECT reservation.reservation_date,reservation.reservation_pickup_date,reservation.reservation_return_date,reservation.reservation_payment,customer.cust_address_city,reservation.car_id,car.car_type,car.car_model,car.car_year,car.car_price
  FROM reservation INNER JOIN customer ON reservation.cust_id=customer.cust_id INNER JOIN car ON reservation.car_id=car.car_id WHERE reservation.cust_id='$sid'";
  $result= mysqli_query($conn, $query);
  echo "<table border='4'>";
  echo "<tr><td>ReservationDate</td><td>PickupDate</td><td>ReturnDate</td><td>Payment</td><td>City</td><td>CarPlate</td><td>CarManfacturer</td><td>CarModel</td><td>CarYear</td><td>Price</td><tr>";
  while($row = mysqli_fetch_assoc($result))
  {

     echo "<tr><td>{$row['reservation_date']}</td><td>{$row['reservation_pickup_date']}</td><td>{$row['reservation_return_date']}</td><td>{$row['reservation_payment']}</td><td>{$row['cust_address_city']}|</td><td>{$row['car_id']}</td><td>{$row['car_type']}</td><td>{$row['car_model']}</td><td>{$row['car_year']}</td><td>{$row['car_price']}</td><tr>";


  }
  echo"</table>";


?>
 </div>
</body>
