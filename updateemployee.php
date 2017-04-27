<?php
session_start();
?>
<html>
    <head>
<!-- Bootstrap links -->

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>        
        
        <title>Employees</title>
    </head>
    
    <body>
<!--

This is the php code to manage the data submitted by the form
-->

<?php

// check if form data needs to be processed

// include config and utils files
include_once('config.php');
include_once('dbutils.php');

if (!isset($_SESSION['employeeid'])){
	header('location: grocerlogin.php');
	exit;
	}

if (isset($_POST['submit'])) {
    // if we are here, it means that the form was submitted and we need to process form data
    
    // get data from form;
    $name = $_POST['name'];
    
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $admin = $_POST['admin'];
    
        
    // variable to keep track if the form is complete (set to false if there are any issues with data)
    $isComplete = true;
    
    // error message we'll give user in case there are issues with data
    $errorMessage = "";
    
	$db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
    // check each of the required variables in the table
    /*if (!isset($grocerid)) {
        $errorMessage .= "Please enter an employer.\n";
        $isComplete = false;
    }*/
    
    if (!isset($name) || (strlen($name)==0)) {
        $errorMessage .= "Please enter employee name.\n";
        $isComplete = false;
    }
    
	
	
    if (!$email) {
        $errorMessage .= " Please enter employee email.";
        $isComplete = false;
    } else {
        $email = makeStringSafe($db, $email);
    }
    
    
    if (!isset($phone) || (strlen($phone)==0)) {
        $errorMessage .= "Please enter a contact number.\n";
        $isComplete = false;
    }
    
    // Stop execution and show error if the form is not complete
    if($isComplete) {
        // if everything required is complete       
        //
        // first enter record into pizza table
        //
        // put together SQL statement to insert new record
        $query = "UPDATE employees SET email = '$email', name = '$name', phone = '$phone', administrator = '$admin' ;";
        
        // connect to the database
        $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
        
        // run the insert statement
        $result = queryDB($query, $db);   
        
        // we have successfully entered the pizza and its toppings
        $success = "Successfully updated employee: " . $name;
        
        // reset values of variables so the form is cleared
        unset($grocerid, $name, $email, $phone);
        
    }
}
if (isset($_GET['id'])){
	$db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
        
	// set up a query
	$id = $_GET['id'];
	$query = "SELECT * FROM employees WHERE id=$id;";
	
	// run the query
	$result = queryDB($query, $db);
	$row = nextTuple($result);
	
	$name = $row['name'];
	$email = $row['email'];
	$phone = $row['phone'];
	$admin = $row['admin'];
	
		
}

?>

<!-- Menu bar -->


<nav class="navbar navbar-default">
  <div class="container-fluid">
    <ul class="nav navbar-nav navbar-left">
        <li>
        <?php
            if (isset($_SESSION['employeeid'])){
                echo "<a href='logout.php'>log out</a>";
            }
            else{
                echo "<a href='login.php'>log in</a>";
            }
        ?>
        </li>
        <li class="active"><a href="grocerhome.php">Home</a></li>
        <form class="navbar-form navbar-left" action="grocerhome.php" method="Get">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search" name="search">
        </div>
        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
      </form>
        
     </ul>
     <ul class="nav navbar-nav navbar-right">
        <li><a href="employees.php">Add/edit Employees</a></li>
        <li><a href="manageorders.php">Manage Orders</a></li>
        <li><a href="productEntry.php">Enter Products</a></li>
        
     </ul>
  </div>
</nav>
        
<!-- Title -->
<div class="row">
    <div class="col-xs-12">
        <h1>Update Employee</h1>        
    </div>
</div>


<!-- Showing successfully entering pizza, if that actually happened -->
<div class="row">
    <div class="col-xs-12">
<?php
    if (isset($success)) {
        // for successes after the form was submitted
        echo '<div class="alert alert-success" role="alert">';
        echo ($success);
        echo '</div>';
    } elseif (isset($_GET['successmessage'])) {
        // for successes from another form that redirects users to this page
        echo '<div class="alert alert-success" role="alert">';
        echo ($_GET['successmessage']);
        echo '</div>';        
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



<!-- form to enter new pizzas -->
<div class="row">
    <div class="col-xs-12">
        
<form action="updateemployee.php" method="post" enctype="multipart/form-data">
<!-- name -->
<div class="form-group">
    <label for="name">Name:</label>
    <input type="text" class="form-control" name="name" value="<?php if($name) {echo $name;} ?>"/>
</div>


<div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" name="email" value="<?php if($email) {echo $email;} ?>"/>
    </div>
	

<!-- size -->
<div class="form-group">
    <label for="phone">Phone:</label>
    <input type="text" class="form-control" name="phone" value="<?php if($phone) { echo $phone; } ?>"/>
</div>


<div class="form-group">
    <label for="admin">Administrator:</label>
    <label class="radio-inline">
        <input type="radio" name="admin" value="1" <?php if($admin || !isset($admin)) { echo 'checked'; } ?>> Yes
    </label>    
    <label class="radio-inline">
        <input type="radio" name="admin" value="0" <?php if(!$admin && isset($admin)) { echo 'checked'; } ?>> No
    </label>    
</div>

<button type="submit" class="btn btn-default" name="submit">Save</button>

</form>
        
        
    </div>
</div>




    </body>
</html>