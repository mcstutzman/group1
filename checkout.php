<html>
    <head>
<!-- Bootstrap links -->
       
<?php
session_start();
include 'ProjectHeader.php';
include_once('config.php');
include_once('dbutils.php');
?>
        <title>Food.biz</title>
    </head>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <ul class="nav navbar-nav navbar-left">
        <li>
        <?php
            if (isset($_SESSION['email'])){
                echo "<a href='logout.php'>log out</a>";
            }
            else{
                echo "<a href='login.php'>log in</a>";
            }
        ?>
        </li>
        <li><a href="index.php">Home</a></li>
        <form class="navbar-form navbar-left" action="shop.php" method="Get">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search" name="search">
        </div>
        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
      </form>
        
     </ul>
     <ul class="nav navbar-nav navbar-right">
        <li><a href="myaccount.php">Account</a></li>
        <li><a href="myOrders.php">Orders</a></li>
        <li class="active"><a href="cart.php">Cart</a></li>
        
     </ul>
  </div>
</nav>
<?php
//
// Code to handle input from form
//
if (isset($_POST['checkout'])){
	$total = $_POST['total'];
	
	$db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName); 
	$insert = "UPDATE orders SET total='$total' WHERE id = ".$_SESSION['orderid'].";";
	$result = queryDB($insert, $db);
}
if (isset($_POST['submit'])) {
    // only run if the form was submitted
    
    // get data from form
    $email = $_POST['email'];
	$name = $_POST['name'];
	$address = $_POST['address'];
	$phone = $_POST['phone'];
    $DDate = $_POST['deliverydate'];
	$d = strtotime("+2 days");
    
   // connect to the database
    $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);    
    
    // check for required fields
    $isComplete = true;
    $errorMessage = "";
    
    if (!$email) {
        $errorMessage .= " Please enter your email.";
        $isComplete = false;
    } else {
        $email = makeStringSafe($db, $email);
    }
	
	if (!isset($name) || (strlen($name)==0)) {
        $errorMessage .= "Please enter your name.\n";
        $isComplete = false;
    }
	
	if (!isset($address) || (strlen($address)==0)) {
        $errorMessage .= "Please enter your address.\n";
        $isComplete = false;
    }
	
	if (!isset($phone) || (strlen($phone)==0)) {
        $errorMessage .= "Please enter your phone number.\n";
        $isComplete = false;
    }
	
	if ($DDate < $_SESSION['date'] || $DDate > date("Y-m-d", $d)) {
        $errorMessage .= "Please enter a valid delivery date.\n";
        $isComplete = false;
    }    
	
    if ($isComplete) {		
		 
		// put together sql code to insert tuple or record
		$insert = "UPDATE orders SET deliverydate='$DDate', status= 1 WHERE id = ".$_SESSION['orderid'].";";
		
		// run the insert statement
		$result = queryDB($insert, $db);
		
		header('location: myOrders.php');
		unset($_SESSION['orderid']);
		exit;
		
		
		}
	}
else{
	
	if ($_SESSION['customerid'] == 0){
		header('location: login.php');
		exit;
	}
	$db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
	$query = 'SELECT * FROM customers WHERE id ='.$_SESSION['customerid'].';';
	$result = queryDB($query, $db);
	$row = nextTuple($result);
	
	$name = $row['name'];
	$address = $row['address'];
	$email = $row['email'];
	$phone = $row['phone'];
}
?>
<div class="row">
    <div class="col-xs-12">
<?php
    if (isset($isComplete) && !$isComplete) {
        echo '<div class="alert alert-danger" role="alert">';
        echo ($errorMessage);
        echo '</div>';
    }
?>            
    </div>
</div>

<!-- form for inputting data -->
<div class="row">
    <div class="col-md-2"> </div>   
        <div class="col-md-8">
                
            <form action="checkout.php" method="post">
            <!-- email -->
                <div class="form-group">
                    <label for="email">email</label>
                    <input type="email" class="form-control" name="email" value="<?php if($email) { echo $email; } ?>"/>
                </div>
                    
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" name="name" value="<?php if($name) { echo $name; } ?>"/>
                </div>
                
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" class="form-control" name="address" value="<?php if($address) { echo $address; } ?>"/>
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" class="form-control" name="phone" value="<?php if($phone) { echo $phone; } ?>"/>
                </div>
                <div class="form-group">
                    <label for="deliverydate">Delivery Date:</label>
                    <input type="date" class="form-control" name="deliverydate"/>
                </div>
				<div class="form-group">
                    <label for="card">Credit Card:</label>
                    <input type="text" class="form-control"/>
                </div>
                
                <button type="submit" class="btn btn-default" name="submit">Submit</button>
            </form>
        </div>
            
</div>
      

<body>
    
</body>
</html>