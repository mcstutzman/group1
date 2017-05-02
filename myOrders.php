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
        <li class="active"><a href="myOrders.php">Orders</a></li>
        <li><a href="cart.php">Cart</a></li>
        
     </ul>
  </div>
</nav>
<?php

if ($_SESSION['customerid'] == 0){
    header('location: login.php');
    exit;
}
/*if (isset($_POST['edit'])){
    
}*/ 
?>

<body>
<h1>ORDERS</h1>
<h2><?php echo $_SESSION['email']; ?></h2>

    <div class="row">
        <div class="col-md-1"></div>
    <div class="col-md-10">
        
<!-- set up html table to show contents -->
<table class="table table-hover">
    <!-- headers for table -->
    <thead>
        <th>Order ID</th>
        <th>Order Date</th>
        <th>Total Price</th>
        <th>Delivery Date</th>
        <th>Delivery Status</th>
        <th></th>
    </thead>
<?php
    $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);    
    $query = "SELECT * FROM orders WHERE customerid = ".$_SESSION['customerid']." AND status > '0' AND grocerid = ".$_SESSION['grocerid'].";";    
    // run the query
    $result = queryDB($query, $db);
    
    while($row = nextTuple($result)) {
        echo "\n <tr>";
        echo "<td><a href=orderdetails.php?id=".$row['id'].">".$row['id']."</a></td>";
        echo "<td>".$row['orderdate']."</td>";
        echo "<td>".$row['total']."</td>";
        echo "<td>".$row['deliverydate']."</td>";
        echo "<td>";
            if ($row['status']==1){
                echo "waiting to be filled";
            }
            elseif ($row['status']==2){
                echo "waiting for delivery";
            }
            elseif ($row['status']==3){
                echo "out for delivery";
            }
            elseif ($row['status']==4){
                echo "delivered";
            }
            elseif ($row['status']==5){
                echo "failed delivery";
            }
        echo "</td>";
        echo "</tr> \n";
    }
?>
</body>
</html>