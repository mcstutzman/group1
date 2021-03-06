<?php
session_start();
?>
<html>
    <head>
<!-- Bootstrap links -->

<?php
include 'ProjectHeader.php';
?>        
        
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
if (isset($_SESSION['admin']) == 0){
	header('location: manageorders.php');
	exit;
}

if (isset($_POST['submit'])) {
    // if we are here, it means that the form was submitted and we need to process form data
    
    // get data from form;
    $name = $_POST['name'];
    $password = $_POST['password'];
	$pwconfirm = $_POST['pwConfirm'];
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
        $pwHash = crypt($password, getSalt());       
        //
        // first enter record into pizza table
        //
        // put together SQL statement to insert new record
        $query = "INSERT INTO employees(grocerid, email, passwordhash, name, phone, administrator) VALUES (".$_SESSION['grocerid'].", '$email', '".$pwHash."', '".$name."','".$phone."','$admin');";
        
        // connect to the database
        $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
        
        // run the insert statement
        $result = queryDB($query, $db);
        
        
                



        // we have successfully entered the pizza and its toppings
        $success = "Successfully entered employee: " . $name;
        
        // reset values of variables so the form is cleared
        unset($grocerid, $name, $email, $phone);
    }
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
        <li><a href="grocerhome.php">Home</a></li>
        <form class="navbar-form navbar-left" action="grocerhome.php" method="Get">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search" name="search">
        </div>
        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
      </form>
        
     </ul>
     <ul class="nav navbar-nav navbar-right">
        <li class="active"><a href="employees.php">Add/edit Employees</a></li>
        <li><a href="manageorders.php">Manage Orders</a></li>
        <li><a href="productEntry.php">Enter Products</a></li>
        
     </ul>
  </div>
</nav>
        
<!-- Title -->
<div class="row">
    <div class="col-xs-12">
        <h1>Enter Employee</h1>        
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
        
<form action="employees.php" method="post" enctype="multipart/form-data">
<!-- name -->
<div class="form-group">
    <label for="name">Name:</label>
    <input type="text" class="form-control" name="name" value="<?php if($name) {echo $name;} ?>"/>
</div>


<div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" name="email" value="<?php if($email) {echo $email;} ?>"/>
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


<!-- show contents of pizza table -->
<div class="row">
    <div class="col-xs-12">
        
<!-- set up html table to show contents -->
<h2>Employees</h2>
<table class="table table-hover">
    <!-- headers for table -->
    <thead>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Administrator</th>
        <th></th>
        <th></th>
    </thead>

<?php
       
    
    // connect to the database
    $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
    
    
    // set up a query to get information on the pizzas from the database
    $query = 'SELECT * from employees where grocerid = '.$_SESSION['grocerid'].';' ;
    
    
    // run the query
    $result = queryDB($query, $db);
    
    
    
    while($row = nextTuple($result)) {
        echo "\n <tr>";
        // picture
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['phone'] . "</td>";
        if ($row['administrator']) {
            $admin = 'Yes';
        } else {
            $admin = 'No';
        }
        echo "<td>" . $admin . "</td>";
        
        echo "<td><a href='updateemployee.php?id=" . $row['id']  .  "'>edit</a></td>";
        
        echo "<td><a href='deleteemployee.php?id=" . $row['id']  .  "'>delete</a></td>";
               
        echo "</tr> \n";
    }
?>        
    
</table>
        
    </div>
</div>

    </body>
</html>