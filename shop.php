<html>
    <head>
<!-- Bootstrap links -->

<?php
session_start();

include_once('config.php');
include_once('dbutils.php');
include 'ProjectHeader.php';
?>
        
        <title>Food.biz</title>
    </head>
<body>
<?php


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
        <li><a href="index.php">Home</a></li>
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
        $query = 'SELECT * FROM products, productdetails WHERE products.id = productdetails.productid AND categoryid = '.$_GET['categoryid'].' AND grocerid = '.$_SESSION['grocerid'].';';
        }
    elseif ($search){
        $query = 'SELECT * FROM products, productdetails WHERE products.id = productdetails.productid AND grocerid = '.$_SESSION['grocerid'].' HAVING name LIKE "%'.$search.'%" OR description LIKE "%'.$search.'%" OR brand LIKE "%'.$search.'%";';
        
        }
    else{
        $query = 'SELECT * FROM products, productdetails WHERE products.id = productdetails.productid AND grocerid = '.$_SESSION['grocerid'].';';
        }
    
    // run the query
    $result = queryDB($query, $db);
    
    
    
    while($row = nextTuple($result)) {
        echo "\n <tr>";
        // picture
        echo "<td><a href='productdetails.php?productid=".$row['id']."'><img src='" . $row['thumbnail'] . "'class='img-responsive'></a></td>";
        echo "<td>" . $row['brand']. "</td>";
        echo "<td>" . $row['name'] . "</td>";
        
        echo "<td>$".$row['saleprice']."</td>";
        
        echo '<form action="shop.php" method="post">';
        echo '<input type="hidden" name="id" value='.$row['id'].'>';
        echo '<input type="hidden" name="price" value='.$row['saleprice'].'>';
        echo '<td><select class="form-control" name="quantity">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                </select></td>';
        /*if (isset($_GET['categoryid'])){
            echo '<input type="hidden" name= "catid" value ='.$_GET['categoryid'].'/>';
        }
        elseif ($search){
            echo '<input type="hidden" name= "search" value ='.$search.'/>';
        }*/
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