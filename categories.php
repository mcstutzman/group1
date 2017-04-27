<html>
    <head>
<!-- Bootstrap links -->

<?php
session_start();
include 'ProjectHeader.php';
include_once('config.php');
include_once('dbutils.php');
?>        
        
        <title>categories</title>
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

if (isset($_POST['submit'])) {
    // if we are here, it means that the form was submitted and we need to process form data
    
    // get data from form
    $name = $_POST['name'];
    $description = $_POST['description'];
    
    // variable to keep track if the form is complete (set to false if there are any issues with data)
    $isComplete = true;
    
    // error message we'll give user in case there are issues with data
    $errorMessage = "";
    
    // check each of the required variables in the table
    if (!isset($name) || (strlen($name)==0)) {
        $errorMessage .= "Please enter category name.\n";
        $isComplete = false;
    }
    
    if (!isset($description) || (strlen($description)==0)) {
        $errorMessage .= "Please enter a category description.\n";
        $isComplete = false;
    }
    
    
    // Stop execution and show error if the form is not complete
    if($isComplete) {
        // if everything required is complete
                
        //
        // first enter record into pizza table
        //
        // put together SQL statement to insert new record
        $query = "INSERT INTO prodcategories(name, description) VALUES ('$name', '$description');";
        
        // connect to the database
        $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
        
        // run the insert statement
        $result = queryDB($query, $db);
        
        
        // we have successfully entered the pizza and its toppings
        $success = "Successfully entered new category: " . $name;
        
        // reset values of variables so the form is cleared
        unset($name, $description);
    }
}

?>

<div class="row">
    <div class="col-xs-12">
        <h1>Categories</h1>        
    </div>
</div>

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



<!-- form to enter new categories -->
<div class="row">
    <div class="col-xs-12">
        
<form action="categories.php" method="post" enctype="multipart/form-data">
<!-- name -->
<div class="form-group">
    <label for="name">Name:</label>
    <input type="text" class="form-control" name="name" value="<?php if($name) { echo $name; } ?>"/>
</div>



<!-- description-->
<div class="form-group">
    <label for="description">Description:</label>
    <input type="text" class="form-control" name="description" value="<?php if($description) { echo $description; } ?>"/>
</div>

<button type="submit" class="btn btn-default" name="submit">Save</button>

</form>
        
        
    </div>
</div>

<!-- show contents of category table -->
<div class="row">
    <div class="col-xs-12">
        
<!-- set up html table to show contents -->
<table class="table table-hover">
    <!-- headers for table -->
    <thead>
        <th>Name</th>
        <th>Description</th>
    </thead>

<?php
    /*
     * List all the pizzas in the database
     *
     */
    
    // connect to the database
    $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
    
    // set up a query to get information on the pizzas from the database
    $query = 'SELECT * from prodcategories;';
    
    // run the query
    $result = queryDB($query, $db);
    
    while($row = nextTuple($result)) {
        echo "\n <tr>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['description'] . "</td>";
        
 }
?>        
    
</table>
        
    </div>
</div>

    </body>
</html>