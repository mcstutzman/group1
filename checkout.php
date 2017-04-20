<html>
    <head>
<!-- Bootstrap links -->

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>        
<?php
session_start();
echo var_dump($_SESSION);
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
        <li class="active"><a href="index.php">Home</a></li>
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
        <li><a href="cart.php">Cart</a></li>
        
     </ul>
  </div>
</nav>
<?php
//
// Code to handle input from form
//

if (isset($_POST['submit'])) {
    // only run if the form was submitted
    
    // get data from form
    $email = $_POST['email'];
	$name = $_POST['name'];
	$address = $_POST['address'];
	$phone = $_POST['phone'];
    $DDate = $_POST['deliverydate'];
    
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
	if (!isset($DDate)) {
        $errorMessage .= "Please enter a delivery date.\n";
        $isComplete = false;
    }    
	
    if ($isComplete) {		
		
		// put together sql code to insert tuple or record
		$insert = "UPDATE orders SET deliverydate='$DDate' WHERE id = ".$_SESSION['orderid'].";";
	
		// run the insert statement
		$result = queryDB($insert, $db);
		
		
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
                
                <button type="submit" class="btn btn-default" name="submit">Submit</button>
            </form>
        </div>
            
</div>
      

<body>
    
</body>
</html>