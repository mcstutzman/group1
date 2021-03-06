<?php
	session_start();
    include_once('config.php');
    include_once('dbutils.php');
    
?>

<html>
    <head>

<title>Login</title>

<?php
include 'ProjectHeader.php';
?>
        
    </head>
    
    <body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <ul class="nav navbar-nav navbar-left">
            <li><a href="index.php">Home</a></li>
			<li><a href="AccountCreation.php">Create Account</a></li>
        </ul>
    </div>
</nav>

<!-- Visible title -->
        <div class="row">
            <div class="col-xs-12">
                <h1>Login</h1>
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
        $errorMessage .= " Please enter your password.";
        $isComplete = false;
    }	    
	
    if (!$isComplete) {
        punt($errorMessage);
    }
    
    // get the hashed password from the user with the email that got entered
    $query = "SELECT * FROM customers WHERE email='" . $email . "';";
    $result = queryDB($query, $db);
    if (nTuples($result) > 0) {
        // there is an account that corresponds to the email that the user entered
		// get the hashed password for that account
		$row = nextTuple($result);
		$pwHash = $row['passwordhash'];
		
		// compare entered password to the password on the database
		if ($pwHash == crypt($password, $pwHash)) {
			// password was entered correctly
			
			// start a session
			
				$_SESSION['email'] = $email;
				$_SESSION['customerid'] = $row['id'];
				header('Location: index.php');
				exit;
			
		} else {
			// wrong password
			punt("Password incorrect. <a href='login.php'>Please try again</a>.");
		}
    } else {
		// email entered is not in the users table
		punt("Email incorrect. <a href='login.php'>Please try again</a>.");
	}
}
?>
            </div>
        </div>

<!-- form for inputting data -->
        <div class="row">
            <div class="col-xs-12">
                
<form action="login.php" method="post">
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


    <button type="submit" class="btn btn-default" name="submit">Login</button>
</form>
                
            </div>
        </div>
            
</div>        

        
    </body>
    
</html>