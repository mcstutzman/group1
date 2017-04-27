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
session_start();

include_once('config.php');
include_once('dbutils.php');

if (isset($_POST['submit'])){
    
    $productid = $_POST['id'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $grocerid = $_SESSION['grocerid'];
    $customerid = $_SESSION['customerid'];
    
    if (!isset($_SESSION['orderid'])){
        $query = 'INSERT INTO orders (grocerid, customerid, orderdate, status) VALUES ('.$grocerid.','.$customerid.',"'.$_SESSION['date'].'",0);';
        $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
        $result = queryDB($query, $db);
        $_SESSION['orderid']= mysqli_insert_id($db);
        $query2 = 'INSERT INTO orderdetails (orderid, productid, quantity, price) VALUES ('.$_SESSION['orderid'].','.$productid.','.$quantity.','.$price.');';
        $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
        $result2 = queryDB($query2, $db);
    }
    else {
        $query2 = 'INSERT INTO orderdetails (orderid, productid, quantity, price) VALUES ('.$_SESSION['orderid'].','.$productid.','.$quantity.','.$price.');';
        $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
        $result2 = queryDB($query2, $db);
    }
    $success = "Added item to cart";
}
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
        <li class="active"><a href="index.php">Home</a></li>
        <form class="navbar-form navbar-left" action="shop.php" method="Get">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search" name="search">
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
<?php
    if (isset($success)) {
        // for successes after the form was submitted
        echo '<div class="alert alert-success" role="alert">';
        echo ($success);
        echo '</div>';
        }
?>
<div class="row">&nbsp</div>
<div class="row">&nbsp</div>
<div class="row">
    <div class = "col-md-1">
        <div class="list-group">
        <?php
        $query = 'SELECT * from prodcategories;';
        $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
        $result = queryDB($query, $db);
        while ($cat = nextTuple($result)){
            echo '<a href="shop.php?categoryid='.$cat['id'].'" class="list-group-item">'.$cat['name'].'</a>';
        }
        ?>
        </div>
    </div>
    <div class="col-xs-12 col-md-10">
        
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
    
    $search = $_GET['search'];
    // connect to the database
    $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
    
    
    // set up a query to get information on the pizzas from the database
    if ($_GET['categoryid']){
        $query = 'SELECT * FROM products WHERE categoryid = '.$_GET['categoryid'].';';
        }
    elseif ($search){
        $query = 'SELECT * FROM products WHERE name LIKE "%'.$search.'%" OR description LIKE "%'.$search.'%" OR brand LIKE "%'.$search.'%";';
        
        }
    else{
        $query = 'SELECT * FROM products;';
        }
    
    // run the query
    $result = queryDB($query, $db);
    
    
    
    while($row = nextTuple($result)) {
        echo "\n <tr>";
        // picture
        echo "<td><a href='productdetails.php?productid=".$row['id']."'><img src='" . $row['thumbnail'] . "'class='img-responsive'></a></td>";
        echo "<td>" . $row['brand']. "</td>";
        echo "<td>" . $row['name'] . "</td>";
        
        $qprice = 'SELECT saleprice FROM productdetails WHERE productid ='.$row['id'].' AND grocerid = 1;';
        $rprice = queryDB($qprice, $db);
        $price = nextTuple($rprice);
        echo "<td>$".$price['saleprice']."</td>";
        
        echo '<form action="shop.php" method="post">';
        echo '<input type="hidden" name="id" value='.$row['id'].'>';
        echo '<input type="hidden" name="price" value='.$price['saleprice'].'>';
        echo '<td><select class="form-control" name="quantity">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                </select></td>';
        echo '<td><button type="submit" class="btn btn-default" name="submit">Add to cart</button></td>';
        echo '</form>';
      
        
               
        echo "</tr> \n";
    }
    
    
?>        
    
</table>
        
    </div>
</div>
</body>
</html>