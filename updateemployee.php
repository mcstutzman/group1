<?php
/*
 * This php file enables users to edit a particular pizza
 * It obtains the id for the pizza to update from an id variable passed using the GET method (in the url)
 *
 */
    include_once('config.php');
    include_once('dbutils.php');
    
    /*
     * If the user submitted the form with updates, we process the form with this block of code
     *
     */
    if (isset($_POST['submit'])) {
        // process the update if the form was submitted
        
        // get data from form
        $id = $_POST['id'];
        if (!isset($id)) {
            // if for some reason the id didn't post, kick them back to pizza.php
            header('Location: employees.php');
            exit;
        }

        // get data from form
        $grocerid = $_POST['grocerid'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $admin = $_POST['admin'];
        $name = $_POST['name'];
        
       
        
        // variable to keep track if the form is complete (set to false if there are any issues with data)
        $isComplete = true;
        
        // error message we'll give user in case there are issues with data
        $errorMessage = "";
        
        
        // check each of the required variables in the table        
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
        
        // If there's an error, they'll go back to the form so they can fix it
        
        if($isComplete) {
            // if there's no error, then we need to update
            
            //
            // first update pizza record
            //
            // put together SQL statement to update pizza
            $query = "UPDATE employees SET email=$email, phone='$phone', admin='$admin', name='$name' WHERE id=$id;";
            
            // connect to the database
            $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
            
            // run the update
            $result = queryDB($query, $db);        
                    
                      
            // now that we are done, send user back to pizza.php and exit 
            header("Location: employees.php?successmessage=Successfully updated employee $name");
            exit;
        }        
    } else {
        //
        // if the form was not submitted (first time in)
        //
    
        /*
         * Check if a GET variable was passed with the id for the pizza
         *
         */
        if(!isset($_GET['id'])) {
            // if the id was not passed through the url
            
            // send them out to pizza.php and stop executing code in this page
            header('Location: employees.php');
            exit;
        }
        
        /*
         * Now we'll check to make sure the id passed through the GET variable matches the id of a pizza in the database
         */
        
        // connect to the database
        $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
        
        // set up a query
        $id = $_GET['id'];
        $query = "SELECT * FROM pizza WHERE id=$id;";
        
        // run the query
        $result = queryDB($query, $db);
        
        // if the id is not in the pizza table, then we need to send the user back to pizza.php
        if (nTuples($result) == 0) {
            // send them out to pizza.php and stop executing code in this page
            header('Location: employees.php');
            exit;
        }
        
        /*
         * Now we know we got a valid pizza id through the GET variable
         */
        
        // get data on pizza to fill out form with existing values
        $row = nextTuple($result);
        
        $name = $row['name'];
        $grocerid = $row['grocerid'];
        $email = $row['email'];
        $phone = $row['phone'];
        $admin = $row['admin'];
        

    }
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
        
 <nav class="navbar navbar-default">
  <div class="container-fluid">
    <ul class="nav navbar-nav navbar-left">
        <li><a href="productEntry.php">Product Entry</a></li>
        <li class="active"><a href="employees.php">Employees</a></li>
        <li><a href="orderManager.php">Open Orders</a></li>
     </ul>
     <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php">log out</a></li>
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
    <input type="text" class="form-control" name="name" value="<?php if($name) { echo $name; } ?>"/>
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
        <input type="radio" name="admin" value="1" <?php if($admin && isset($admin)) { echo 'checked'; } ?>> Yes
    </label>    
    <label class="radio-inline">
        <input type="radio" name="admin" value="0" <?php if(!$admin || !isset($admin)) { echo 'checked'; } ?>> No
    </label>    
</div>

<button type="submit" class="btn btn-default" name="submit">Save</button>

</form>
        
        
    </div>
</div>

       
       
        
    </body>
</html>