<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SEARCH PAGE</title>
<link rel="stylesheet" href="styleadmin.css">
<link rel="stylesheet" href="sidemenu.css">

</head>
<body >
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a class="active" href=adminsearch.php>Search</a>
  <a href=manageres.php> Manage Resrvations</a>
  <a href=managecar.php>Manage Cars</a>
  <a href=managecust.php>Manage Customers</a>
  <a href=managepay.php>Manage Payments</a>
  <a href=manageoffice.php>Manage Offices</a>
  <a class="logout" href=mainpage.php>LOG-OUT</a>
</div>
<span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span>
<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}
function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
</script>

<div class="SearchBox">
<h3>ADMIN SEARCH</h3>
<form name="SForm" onsubmit="return validateForm()" method ="post">
<h4>Search By Reservation</h4>
<label>Reservation ID:</label>
<input type="text" name="res_id" placeholder="Reservation ID"/></br>
<label>Office ID:</label>
<input type="text" name="off_id" placeholder="Office ID"/></br>
<label>Enter Reservation Payment:</label>
<input type="text" name="res_pay" placeholder="Reservation Payment"/></br>
<label>Reservation Date:</label>
<input type="date" name="res_date" placeholder="Reservation Date"/></br>
<label>Pickup Date:</label>
<input type="date" name="p_date" placeholder="Pickup Date"/><br>
<label>Reservation Return Date:</label>
<input type="date" name="r_date" placeholder="Return Date"/>

<h4>Search By Customer</h4>
<label>Customer ID:</label>
<input type="text" name="c_id" placeholder="Customer ID"/></br>
<label>Customer Name:</label>
<input type="text" name="c_name" placeholder="Customer Name"/></br>
<label>Customer Email:</label>
<input type="email" name="c_email" placeholder="Customer Email"/></br>
<label>Customer Phone:</label>
<input type="text" name="c_pn" placeholder="Customer Phone"/></br>
<label>Customer City:</label>
<input type="text" name="cust_city" placeholder="Customer City"/>


<h4>Search By Car</h4>
<label>Car Plate ID:</label>
<input type="text" name="car_id" placeholder="Plate ID"/></br>
<label>Car Type:</label>
<input type="text" name="car_type" placeholder="Car Type"/></br>
<label>Car Model:</label>
<input type="text" name="car_mod" placeholder="Car Model"/></br>
<label>Car Year:</label>
<input type="text" name="car_year" placeholder="Car Year"/></br>

<p><tr><center><button type="submit" name="search" value="Search" class="btn btn-primary"> Search </button><center>
</form>
<?php
include "connection.php";
//session_start();
if(isset($_POST['c_id']) || isset($_POST['c_name']) || isset($_POST['c_email']) || isset($_POST['c_pn']) || isset($_POST['cust_city']) || isset($_POST['car_id']) || isset($_POST['car_type']) || isset($_POST['car_mod'])
|| isset($_POST['car_year']) || isset($_POST['res_id'])
|| isset($_POST['off_id']) || isset($_POST['res_pay'])
|| isset($_POST['res_date']) || isset($_POST['p_date'])
|| isset($_POST['r_date'])){
  function validate($entry) {
	    // Trim leading and trailing whitespaces, remove backslashes, and convert special characters to HTML entities
	    return htmlspecialchars(stripslashes(trim($entry)));
	}

$custid=$_POST['c_id'];
$cname=$_POST['c_name'];
$ce=validate($_POST['c_email']);
$cpn=$_POST['c_pn'];
$l=$_POST['cust_city'];
$pid=$_POST['car_id'];
$ct=$_POST['car_type'];
$mod=$_POST['car_mod'];
$y=$_POST['car_year'];
$rid=$_POST['res_id'];
$oid=$_POST['off_id'];
$p=$_POST['res_pay'];
$rd=$_POST['res_date'];
$pd=$_POST['p_date'];
$retd=$_POST['r_date'];

if(empty($custid) && empty($cname)
&& empty($ce) && empty($cpn)
&& empty($l) && empty($pid)
&& empty($ct) && empty($mod)
&& empty($y) && empty($rid)
&& empty($oid) && empty($p)
&& empty($rd) && empty($pd)
&& empty($retd)) {
      echo "<script>
        alert('Please enter search information!');
        </script>";
        header("Refresh:0");
        exit();
}

$q1 = "(SELECT reservation.reservation_id,reservation.reservation_date,reservation.reservation_pickup_date,reservation.reservation_return_date,
reservation.reservation_payment,reservation.office_id,customer.cust_id,customer.cust_name,customer.cust_email,
customer.cust_pn,customer.customer_address_city,car.car_id,car.car_type,car.car_model,car.car_year FROM car
LEFT JOIN reservation ON reservation.car_id=car.car_id
LEFT JOIN customer ON reservation.cust_id=customer.cust_id WHERE 1" ;

if(!empty($custid)){
$q1.=" AND customer.cust_id='$custid'";
}
if(!empty($cname)){
$q1.=" AND customer.cust_name='$cname'";
}
if(!empty($ce)){
$q1.=" AND customer.cust_email='$ce'";
}
if(!empty($cpn)){
$q1.=" AND customer.cust_pn='$cpn'";
  }
if(!empty($l)){
$q1.=" AND customer.customer_address_city='$l'";
}
if(!empty($pid)){
$q1.=" AND car.car_id='$pid'";
}
if(!empty($ct)){
$q1.=" AND car.car_type='$ct'";
}
if(!empty($mod)){
$q1.=" AND car.car_model='$mod'";
  }
if(!empty($y)){
$q1.=" AND car.car_year='$y'";
}
if(!empty($rid)){
$q1.=" AND reservation.reservation_id='$rid'";
}
if(!empty($oid)){
$q1.=" AND reservation.office_id='$oid'";
}
if(!empty($p)){
$q1.=" AND reservation.reservation_payment='$p'";
  }
if(!empty($rd)){
$q1.=" AND reservation.reservation_date='$rd'";
}
if(!empty($pd)){
$q1.=" AND reservation.reservation_pickup_date='$pd'";
}
if(!empty($retd)){
$q1.=" AND reservation.reservation_return_date='$retd'";
}

$q1.=")";
///////// rewrite this part differentlyyy/////////////
$q2 = "(SELECT reservation.reservation_id,reservation.reservation_date,reservation.reservation_pickup_date,reservation.reservation_return_date,
reservation.reservation_payment,reservation.office_id,customer.cust_id,customer.cust_name,customer.cust_email,
customer.cust_pn,customer.customer_address_city,car.car_id,car.car_type,car.car_model,car.car_year FROM customer
LEFT JOIN reservation ON reservation.cust_id=customer.cust_id
LEFT JOIN car ON reservation.car_id=car.car_id
WHERE 1";

if(!empty($custid)){
$q2.=" AND customer.cust_id='$custid'";
}
if(!empty($cname)){
$q2.=" AND customer.cust_name='$cname'";
}
if(!empty($ce)){
$q2.=" AND customer.cust_email='$ce'";
}
if(!empty($cpn)){
$q2.=" AND customer.cust_pn='$cpn'";
  }
if(!empty($l)){
$q2.=" AND customer.customer_address_city='$l'";
}
if(!empty($pid)){
$q2.=" AND car.car_id='$pid'";
}
if(!empty($ct)){
$q2.=" AND car.car_type='$ct'";
}
if(!empty($mod)){
$q2.=" AND car.car_model='$mod'";
  }
if(!empty($y)){
$q2.=" AND car.car_year='$y'";
}
if(!empty($rid)){
$q2.=" AND reservation.reservation_id='$rid'";
}
if(!empty($oid)){
$q2.=" AND reservation.office_id='$oid'";
}
if(!empty($p)){
$q2.=" AND reservation.reservation_payment='$p'";
  }
if(!empty($rd)){
$q2.=" AND reservation.reservation_date='$rd'";
}
if(!empty($pd)){
$q2.=" AND reservation.reservation_pickup_date='$pd'";
}
if(!empty($retd)){
$q2.=" AND reservation.reservation_return_date='$retd'";
}

$q2.=")";

$q1.=" UNION ";
$q1.=$q2;

$result= mysqli_query($conn, $q1);

if(mysqli_num_rows($result)== 0){

  echo "<script>
        alert('Information not found.');
        </script>";
        header("Refresh:0");
        exit();
  }
echo "<table border='1'>";
echo "<tr><td>ReservationID</td><td>ReservationDate</td><td>PickupDate</td><td>ReturnDate</td><td>Payment</td><td>OfficeID</td><td>CustomerID</td><td>Name</td><td>Email</td><td>Phone</td><td>City</td><td>CarPlate|</td><td>CarMake</td><td>CarModel</td><td>CarYear</td><tr>";
while($row = mysqli_fetch_assoc($result))
{

   echo "<tr><td>{$row['reservation_id']}</td><td>{$row['reservation_date']}</td><td>{$row['reservation_pickup_date']}</td><td>{$row['reservation_return_date']}</td><td>{$row['reservation_payment']}</td><td>{$row['office_id']}</td><td>{$row['cust_id']}</td><td>{$row['cust_name']}</td><td>{$row['cust_email']}</td><td>{$row['cust_pn']}</td><td>{$row['customer_address_city']}</td><td>{$row['car_id']}</td><td>{$row['car_type']}</td><td>{$row['car_model']}</td><td>{$row['car_year']}</td><tr>";


}
echo"</table>";
}
?>
</div>






</body>
</html>
