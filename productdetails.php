<html>
    <head>
<!-- Bootstrap links -->

<?php
session_start();
include 'ProjectHeader.php';
?>       
        
        <title>Food.biz</title>
    </head>
<body>
<?php
include_once('config.php');
include_once('dbutils.php');

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


<div class= "row">
    <div class= "col-md-1">
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
    <div class= "col-md-4">
        <?php
        $productid = $_GET['productid'];
        $query = 'SELECT * FROM products WHERE id ='.$productid.';';
        $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
        $result = queryDB($query, $db);
        $product = nextTuple($result);
        echo "<img src=".$product['image'].">";
        echo "</div>";
        echo "<div class= 'col-md-4'>";
        echo "<h2>".$product['brand']." ".$product['name']."</h2>\r\n";
        echo "<p>".$product['description']."</p>";
        echo "</div>";
        echo "<div class= 'col-md-1'>";
        $qprice = 'SELECT saleprice FROM productdetails WHERE productid ='.$product['id'].' AND grocerid = '.$_SESSION['grocerid'].';';
        $rprice = queryDB($qprice, $db);
        $price = nextTuple($rprice);
        echo "<h3>$".$price['saleprice']."</h3>";
        echo '<form action="shop.php" method="post">';
        echo '<input type="hidden" name="id" value='.$product['id'].'>';
        echo '<input type="hidden" name="price" value='.$price['saleprice'].'>';
        echo '<select class="form-control" name="quantity">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                </select>';
        echo "</div>";
        echo "<div class= 'col-md-1'>";        
        echo '<button type="submit" class="btn btn-default" name="submit">Add to cart</button>';
        echo '</form>';
        echo "</div>";
        
        
        ?>
    
</div>
</body>
</html>
