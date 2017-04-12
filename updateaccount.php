<?php
    include_once('config.php');
    include_once('dbutils.php');
    
?>

<html>
    <head>

<title>Create Account</title>

<!-- This is the code from bootstrap -->        
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        
    </head>
    
    <body>


        
<!-- Processing form input -->        
        <div class="row">
            <div class="col-xs-12">
<?php
if (isset($_POST['submit'])) {
    // only run if the form was submitted
    
    // get data from form
    $email = $_POST['email'];
	$password = $_POST['password'];
    
   // connect to the database
    $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);    
    
    // check for required fields
    $isComplete = true;
    $errorMessage = "";
    
    if (!$email) {
        $errorMessage .= " Email";
        $isComplete = false;
    } else {
        $email = makeStringSafe($db, $email);
    }
	if (!$firstName) {
        $errorMessage .= " First Name";
        $isComplete = false;
	}
		
	if (!$lastName) {
        $errorMessage .= " Last Name";
        $isComplete = false;
	}
	
	if (!$address) {
        $errorMessage .= " Street address.";
        $isComplete = false;
	}
	
	if (!$lastName) {
        $errorMessage .= " City";
        $isComplete = false;
	}
	
	if (!$province) {
        $errorMessage .= " State";
        $isComplete = false;
	}
	
	if (!$email) {
        $errorMessage .= " Please enter an email.";
        $isComplete = false;
	}

    if (!$password) {
        $errorMessage .= " Please enter a password.";
        $isComplete = false;
    }	    
	
    if (!$isComplete) {
        punt($errorMessage);
    }
    
    // get the hashed password from the user with the email that got entered
    $query = "SELECT hashpass FROM account WHERE email='" . $email . "';";
    $result = queryDB($query, $db);
    if (nTuples($result) > 0) {
        // there is an account that corresponds to the email that the user entered
		// get the hashed password for that account
		$row = nextTuple($result);
		$hashpass = $row['hashpass'];
		
		// compare entered password to the password on the database
		if ($hashpass == crypt($password, $hashpass)) {
			// password was entered correctly
			
			// start a session
			if (session_start()) {
				$_SESSION['email'] = $email;
				header('Location: cars.php');
				exit;
			} else {
				// if we can't start a session
				punt("Unable to start session.");
			}
		} else {
			// wrong password
			punt("Wrong password. <a href='login.php'>Try again</a>.");
		}
    } else {
		// email entered is not in the users table
		punt("This email is not in our system or is incorrect. <a href='login.php'>Try again</a>.");
	}
}
?>
            </div>
        </div>

      

        
    </body>
    
</html>

<!-- Title -->
<div class="row">
    <div class="col-xs-12">
        <h1>Update account <?php echo $firstName ?> <?php echo $lastName ?></h1>        
    </div>
</div>


<!-- Showing errors, if any -->
<div class="row">
    <div class="col-xs-12">
<?php
    if (isset($isComplete) && !$isComplete) {
        // executes only if form was previously submitted (and therefore $isComplete is set) and isComplete was set to false
        // you'll never be here if the form wasn't submitted (the first time you get in)
        
        echo '<div class="alert alert-danger" role="alert">';
        echo ($errorMessage);
        echo '</div>';
    }
?>            
    </div>
</div>



<!-- form to update account -->
<div class="row">
    <div class="col-xs-12">
        
<form action="updateaccount.php" method="post">
    
<!-- email -->
<div class="form-group">
    <label for="name">Email:</label>
    <input type="text" class="form-control" name="email" value="<?php if($email) { echo $email; } ?>"/>
</div>

<!-- First Name -->
<div class="form-group">
    <label for="name">First Name:</label>
    <input type="text" class="form-control" name="firstName" value="<?php if($firstName) { echo $firstName; } ?>"/>
</div>


<!-- Last Name -->
<div class="form-group">
    <label for="name">Last Name:</label>
    <input type="text" class="form-control" name="lastName" value="<?php if($lastName) { echo $lastName; } ?>"/>
</div>


<!-- Last Name -->
<div class="form-group">
    <label for="name">Address:</label>
    <input type="text" class="form-control" name="address" value="<?php if($address) { echo $address; } ?>"/>
</div>


<!-- State -->
<div class="form-group">
    <label for="name">State:</label>
    <input type="text" class="form-control" name="province" value="<?php if($province) { echo $province; } ?>"/>
</div>

<!-- Password -->
<div class="form-group">
    <label for="name">Password:</label>
    <input type="text" class="form-control" name="password" value="<?php if($password) { echo $password; } ?>"/>
</div>

<!-- hidden id (not visible to user, but need to be part of form submission so we know which pizza we are updating -->
<input type="hidden" name="email" value="<?php echo $email; ?>"/>

<button type="submit" class="btn btn-default" name="submit">Update</button>

</form>
        
        
    </div>
</div>

       
       
        
    </body>
</html>