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
<?php

if (isset($_POST['submit'])){
    $status = $_POST['status'];
    $id = $_POST['id'];
    
    $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
    $query = "UPDATE orders SET status = $status, employeeid=".$_SESSION['employeeid']." WHERE id = $id;";
    $result = queryDB($query, $db);
    
    $success = "Successfully updated order: " . $id;
}
?>
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
        <?php
        if ($_SESSION['admin']==1){
            echo '<form class="navbar-form navbar-left" action="grocerhome.php" method="Get">
            <div class="form-group">
            <input type="text" class="form-control" placeholder="Search" name="search">
            </div>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
            </form>';
        }
       ?> 
     </ul>
     <ul class="nav navbar-nav navbar-right">
        <?php
        if ($_SESSION['admin']==1){
        echo'<li><a href="employees.php">Add/edit Employees</a></li>
        <li class="active"><a href="manageorders.php">Manage Orders</a></li>
        <li><a href="productEntry.php">Enter Products</a></li>';
        }else{
            echo '<li class="active"><a href="manageorders.php">Manage Orders</a></li>';
        }
        ?>
     </ul>
  </div>
</nav>


<body>
<h1>MANAGE ORDERS</h1>
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
    $query = "SELECT * FROM orders WHERE status > '0' AND grocerid = ".$_SESSION['grocerid'].";";    
    // run the query
    $result = queryDB($query, $db);
    
    while($row = nextTuple($result)) {
        echo "\n <tr>";
        echo "<td><a href=orderdetails.php?id=".$row['id'].">".$row['id']."</a></td>";
        echo "<td>".$row['orderdate']."</td>";
        echo "<td>".$row['total']."</td>";
        echo "<td>".$row['deliverydate']."</td>";
        
        echo '<form action="manageorders.php" method="post">';
        echo '<td>';
        echo statusDropdown($row['status']);
        echo "</td>";
        echo '<input type="hidden" name="id" value='.$row['id'].'>';
        echo '<td><button type="submit" class="btn btn-default" name="submit">Update Status</button>';
        echo '</form>';
        echo "</tr> \n";
    }
?>
</body>
</html>