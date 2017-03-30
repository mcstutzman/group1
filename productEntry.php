<html>
    <head>
<!-- Bootstrap links -->

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>        
        
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

if (isset($_POST['submit'])) {
    // if we are here, it means that the form was submitted and we need to process form data
    
    // get data from form
    $categoryid = $_POST['category-id'];
    $name = $_POST['name'];
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
        $query = "INSERT INTO pizza(categoryid, name, price, description) VALUES ('$categoryid', '$name', $price, $description);";
        
        // connect to the database
        $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
        
        // run the insert statement
        $result = queryDB($query, $db);
        
        
                
        //
        // now we need to connect the new pizza record to its toppings        
        //
    $productid = mysqli_insert_id($db);
    // get the id for the pizza we just entered
    // check if there's a picture
    if ($_FILES['picture']['size'] > 0) {
        // if there is a picture
        
        // copy image to images directory
        $tmpName = $_FILES['picture']['tmp_name'];
        $fileName = $_FILES['picture']['name'];
        
        $newFileName = $imagesDir . $productid . $fileName;
        
        // we create a filename that includes the pizza id, followed by the filename ($imagesDir comes from config.php)
        if (move_uploaded_file($tmpName, $newFileName)) {
            // since we successfully copied the file, we now enter its filename in the pizza table
            $query = "UPDATE products SET picture = '$newFileName' WHERE id=$productid;";
        
            // run insert query
            queryDB($query, $db);
        } else {
            echo "error copying image";
        }
    }


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
        <li class="active"><a href="productEntry.php">Product Entry</a></li>
        <li><a href="topping.php">toppings</a></li>
     </ul>
     <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php">log out</a></li>
     </ul>
  </div>
</nav>

        
<!-- Title -->
<div class="row">
    <div class="col-xs-12">
        <h1>Enter New Product</h1>        
    </div>
</div>

<


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
    <label for="category-id">Shape:</label>
    <?php
    // connect to the database
    if (!isset($db)) {
        $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
    }
    echo (generateDropdown($db, "prodcategories", "name", "id", $categoryid));        
    ?>
</div>


<!-- crust -->
<div class="form-group">
    <label for="name">Name:</label>
    <input type="text" class="form-control" name="name" value="<?php if($name) { echo $name; } ?>"/>
</div>


<!-- size -->
<div class="form-group">
    <label for="price">Price per Unit:</label>
    <input type="number" class="form-control" name="price" value="<?php if($price) { echo $price; } ?>"/>
</div>


<!-- cheese -->
<div class="form-group">
    <label for="description">Description:</label>
    <textarea class="form-control" rows="3" id="description"></textarea> 
</div>

<button type="submit" class="btn btn-default" name="submit">Save</button>

</form>
        
        
    </div>
</div>



<!-- show contents of pizza table -->
<div class="row">
    <div class="col-xs-12">
        
<!-- set up html table to show contents -->
<table class="table table-hover">
    <!-- headers for table -->
    <thead>
        <th>Image</th>
        <th>Name</th>
        <th>Category</th>
        <th>Unit Price</th>
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
    $query = 'SELECT products.name, category.name as category, price, description, thumbnail FROM products, prodcategories WHERE products.categoryid = prodcategories.id;';
    
    // run the query
    $result = queryDB($query, $db);
    
    while($row = nextTuple($result)) {
        echo "\n <tr>";
        // picture
        echo "<td>";
        if ($row['thumbnail']) {
            $imageLocation = $row['thumbnail'];
            $altText = $row['name'];
            echo "<img src='$imageLocation' width='150' alt='$altText'>";
        }
        echo "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['category'] . "</td>";
        echo "<td>""$" . $row['price'] . "</td>";
        echo "<td>" . $row['description'] . "</td>";       
        
    /*            
        // link to update record (pizza)
        echo "<td><a href='updatepizza.php?id=" . $row['id']  .  "'>edit</a></td>";
        
        // link to delete record (pizza)
        echo "<td><a href='deletepizza.php?id=" . $row['id']  .  "'>delete</a></td>";
     */   
        echo "</tr> \n";
    }
?>        
    
</table>
        
    </div>
</div>

    </body>
</html>