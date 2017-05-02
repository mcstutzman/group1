<html>
    <head>
<!-- Bootstrap links -->

       
<?php
session_start();
include 'ProjectHeader.php';
include_once('config.php');
include_once('dbutils.php');
?>
        <title>Food.biz</title>
    </head>
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
<?php 
if (isset($_POST['edit'])){
    $quant = $_POST['quantity'];
    
    $query = "UPDATE orderdetails SET quantity= $quant WHERE orderid = ".$_SESSION['orderid'].";";
    $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
    $result = queryDB($query, $db);
}
if (isset($_POST['delete'])){
    $prod = $_POST['id'];
    
    $query = "DELETE FROM orderdetails WHERE productid = '$prod' AND orderid =".$_SESSION['orderid'].";";
    $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
    $result = queryDB($query, $db);
}
?>
<body>
    <?php
        echo "<h1>Order #".$_SESSION['orderid']."</h1>"
    
    ?>
    <div class="row">
        <div class="col-md-1"></div>
    <div class="col-md-10">
        
<!-- set up html table to show contents -->
<table class="table table-hover">
    <!-- headers for table -->
    <thead>
        <th></th>
        <th>Item</th>
        <th>Quantity</th>
        <th>Price</th>
        <th></th>
    </thead>
<?php
    if (isset($_SESSION['orderid'])){
        $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);    
        $query = 'SELECT * FROM orderdetails WHERE orderid = '.$_SESSION['orderid'].';';    
        // run the query
        $result = queryDB($query, $db);
        
        while($row = nextTuple($result)) {
            echo "\n <tr>";
            $query2= 'SELECT * FROM products WHERE id ='.$row['productid'].";";
            $result2 = queryDB($query2, $db);
            $product = nextTuple($result2);
            echo "<td><a href='productdetails.php?productid=".$row['productid']."'><img src='" . $product['thumbnail'] . "'class='img-responsive'></a></td>";
            echo "<td>" . $product['name'] . "</td>";
            echo '<form action="cart.php" method="post">';
            echo'<td><div class= "col-xs-3"><div class="form-group">
                <input type="text" class="form-control" name="quantity" value='. $row['quantity'].'></div><button type="submit" class="btn btn-default" name="edit">Edit</button></form></div></td>';
            
            $itemtotal = $row['quantity'] * $row['price'];
            echo "<td>$" . $itemtotal . "</td>";
            echo '<form action="cart.php" method="post">';
            echo '<input type="hidden" name="id" value='.$row['productid'].'>';
            echo '<td><button type="submit" class="btn btn-default" name="delete">Delete</button></form></div></td>';
            echo "</tr> \n";
            $total = $total + $itemtotal;
            }
        echo '</table>';
        echo '</div>';
        echo '</div>';
        echo '<div class="row">';
        echo '<div class="col-md-offset-10">';
        echo '<form action="checkout.php" method="post">';
        echo '<input type="hidden" name="total" value='.$total.'>';
        echo '<h3>Total: $'.$total.'</h3><button type="submit" class="btn btn-default" name="checkout">Checkout</button></form>';
        echo '</div>';
        echo '</div>';
    }
?>

    
        
</body>
</html>