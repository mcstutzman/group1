<?php
    include_once('config.php');
    include_once('dbutils.php');
    
?>

<html>
    <head>

<title>Enter Users</title>

<!-- This is the code from bootstrap -->        
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        
    </head>
    
    <body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
     <ul class="nav navbar-nav navbar-left">
        <li><a href="index.php">home</a></li>
     </ul>
     <ul class="nav navbar-nav navbar-right">
        <li><a href="login.php">log in</a></li>
     </ul>
  </div>
</nav>
<!-- Visible title -->
        <div class="row">
            <div class="col-xs-12">
                <h1>Create Account</h1>
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

    if (!$password) {
        $errorMessage .= " Please enter a password.";
        $isComplete = false;
    }
	
	if (!$pwconfirm) {
        $errorMessage .= " Please re-enter your password.";
        $isComplete = false;
    }
	
	if ($password != $pwconfirm) {
		$errorMessage .= " Your passwords are not the same.  Please try again.";
		$isComplete = false;
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
    
		// check if there's a user with the same email
		$query = "SELECT * FROM customers WHERE email='" . $email . "';";
		$result = queryDB($query, $db);
		if (nTuples($result) == 0) {
			// if we're here it means there's already a user with the same email
			
			// generate the hashed version of the password
			$pwHash = crypt($password, getSalt());
			
			// put together sql code to insert tuple or record
			$insert = "INSERT INTO customers(email, passwordhash, name, address, phone) VALUES ('".$email."', '".$pwHash."', '".$name."', '".$address."', '".$phone."');";
		
			// run the insert statement
			$result = queryDB($insert, $db);
			
			// we have successfully inserted the record
			echo ("Successfully entered " . $email . " into the database.");
		} else {
			$isComplete = false;
			$errorMessage = "Sorry. " . $email . " is already being used";
		}
	}
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
                
<form action="AccountCreation.php" method="post">
<!-- email -->
    <div class="form-group">
        <label for="email">email</label>
        <input type="email" class="form-control" name="email"/>
    </div>

<!-- password1 -->
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password"/>
    </div>

<!-- password2 -->
    <div class="form-group">
        <label for="pwConfirm">Enter password again</label>
        <input type="password" class="form-control" name="pwConfirm"/>
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