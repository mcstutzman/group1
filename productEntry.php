<html>
    <head>
<!-- Bootstrap links -->

<?php
session_start();
include 'ProjectHeader.php';
?>        
        
        <title>Enter Products</title>
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
    
    // get data from form
    $categoryid = $_POST['category-id'];
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_POST['image'];
    $thumbnail = $_POST['thumb'];
        
    // variable to keep track if the form is complete (set to false if there are any issues with data)
    $isComplete = true;
    
    // error message we'll give user in case there are issues with data
    $errorMessage = "";
    
    // check each of the required variables in the table
    if (!isset($categoryid)) {
        $errorMessage .= "Please enter a category.\n";
        $isComplete = false;
    }
    
    if (!isset($name) || (strlen($name)==0)) {
        $errorMessage .= "Please enter a product name.\n";
        $isComplete = false;
    }
    
    if (!isset($price) || (strlen($price)==0)) {
        $errorMessage .= "Please enter the cost of the product.\n";
        $isComplete = false;
    }
    
    
    if (!isset($description) || (strlen($description)==0)) {
        $errorMessage .= "Please enter product description.\n";
        $isComplete = false;
    }
    
    // Stop execution and show error if the form is not complete
    if($isComplete) {
        // if everything required is complete
                
        //
        // first enter record into pizza table
        //
        // put together SQL statement to insert new record
        $query = "INSERT INTO pizza(categoryid, name, brand, price, description) VALUES ('$categoryid', '$name', '$brand', $price, '$description');";
        
        // connect to the database
        $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
        
        // run the insert statement
        $result = queryDB($query, $db);
        
        
                



        // we have successfully entered the pizza and its toppings
        $success = "Successfully entered new product: " . $name;
        
        // reset values of variables so the form is cleared
        unset($categoryid, $name, $price, $description);
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
        <h1>Enter New Product</h1>        
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
        
<form action="productEntry.php" method="post" enctype="multipart/form-data">
<!-- name -->
<div class="form-group">
    <label for="name">Name:</label>
    <input type="text" class="form-control" name="name" value="<?php if($name) { echo $name; } ?>"/>
</div>

<!-- shape -->
<div class="form-group">
    <label for="category-id">Category:</label>
    <?php
    // connect to the database
    if (!isset($db)) {
        $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
    }
    echo (categoryDropdown($db, "prodcategories", "name", "id", $categoryid, $_SESSION['grocerid']));        
    ?>
</div>


<div class="form-group">
    <label for="brand">Brand:</label>
    <input type="text" class="form-control" name="brand" value="<?php if($brand) { echo $brand; } ?>"/>
</div>


<div class="form-group">
    <label for="price">Cost per Unit:</label>
    <input type="number" class="form-control" name="price" value="<?php if($price) { echo $price; } ?>"/>
</div>

<div class="form-group">
    <label for="saleprice">Sale Price:</label>
    <input type="number" class="form-control" name="saleprice" value="<?php if($saleprice) { echo $saleprice; } ?>"/>
</div>

<div class="form-group">
    <label for="stock">Amount in Stock:</label>
    <input type="number" class="form-control" name="stock" value="<?php if($stock) { echo $stock; } ?>"/>
</div>

<div class="form-group">
    <label for="description">Description:</label>
    <textarea class="form-control" rows="3" id="description"></textarea> 
</div>

<button type="submit" class="btn btn-default" name="submit">Save</button>

</form>
        
        
    </div>
</div>



        
    </div>
</div>

    </body>
</html>