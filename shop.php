<html>
    <head>
<!-- Bootstrap links -->

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>        
        
        <title>Food.biz</title>
    </head>
<body>
<?php
include_once('config.php');
include_once('dbutils.php');
/*if (isset($_POST['submit'])){
    
}*/
?>

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
        <li class="active"><a href="shop.php">Home</a></li>
        <form class="navbar-form navbar-left">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
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
<h1>Food.biz</h1>

<div class= "row">
    <div class="col-md-10 col-md-offset-1">
    <div class="input-group">
      <input type="text" class="form-control" placeholder="Search">
      <span class="input-group-btn">
        <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
      </span>
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->    
</div>
<div class="row">
    <div class="col-xs-12 col-md-10 col-md-offset-1">
        
<!-- set up html table to show contents -->
<table class="table table-hover">
    <!-- headers for table -->
    <thead>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>        
    </thead>

<?php
    /*
     * List all the pizzas in the database
     *
     */
    
    
    // connect to the database
    $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
    
    
    // set up a query to get information on the pizzas from the database
    if ($_GET['categoryid']){
        $query = 'SELECT * FROM products WHERE categoryid = '.$_GET['categoryid'].';';
        }
    /*elseif ($_GET['search']{
        $query = 'SELECT * FROM products WHERE name CONTAINS '.$_GET['search'].';';
    }*/
    else{
        $query = 'SELECT products.name, products.description, products.thumbnail, prodcategories.name as category FROM products, prodcategories WHERE products.categoryid = prodcategories.id;';
        }
    
    // run the query
    $result = queryDB($query, $db);
    
    
    
    while($row = nextTuple($result)) {
        echo "\n <tr>";
        // picture
        echo "<td><a href='productdetails.php'><img src='" . $row['thumbnail'] . "'class='img-responsive'></a></td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['category'] . "</td>";
        echo "<td>" . $row['price'] . "</td>";
        echo "<td>" . $row['description'] . "</td>";
               
        echo "</tr> \n";
    }
?>        
    
</table>
        
    </div>
</div>
</body>
</html>