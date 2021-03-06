<?php
	session_start();
	
    include_once('config.php');
    include_once('dbutils.php');
    
?>

<html>
    <head>

<title>My Account</title>

<?php
include 'ProjectHeader.php';
?>
        
    </head>
    
    <body>
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
<!-- Visible title -->
        <div class="row">
            <div class="col-xs-12">
                <h1>Update Account</h1>
            </div>
        </div>
        
<!-- Processing form input -->        
        <div class="row">
            <div class="col-xs-12">
<?php
//
// Code to handle input from form
//

if (isset($_POST['submit'])) {
    // only run if the form was submitted
    
    // get data from form
    $email = $_POST['email'];
	$password = $_POST['password'];
	$pwconfirm = $_POST['pwConfirm'];
	$name = $_POST['name'];
	$address = $_POST['address'];
	$phone = $_POST['phone'];
    
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
	    
	
    if ($isComplete) {
    
		$pwHash = crypt($password, getSalt());
		
		// put together sql code to insert tuple or record
		$insert = "UPDATE customers SET email= '$email', name= '$name', address= '$address', phone='$phone' WHERE id = ".$_SESSION['customerid'].";";
	
		// run the insert statement
		$result = queryDB($insert, $db);
		
		// we have successfully inserted the record
		echo ("Successfully updated " . $email . ".");
		
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
            </div>
        </div>
		
		
<!-- Showing errors, if any -->
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
            <div class="col-xs-12">
                
<form action="myaccount.php" method="post">
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
    
    <button type="submit" class="btn btn-default" name="submit">Submit</button>
</form>
                
            </div>
        </div>
      

        
    </body>
    
</html>