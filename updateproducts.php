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

if (isset($_POST['edit'])){
    echo var_dump($_POST);
    $id = $_POST['id'];
    $desc = $_POST['description'];
    $stock = $_POST['stock'];
    $price = $_POST['saleprice'];
    $newproduct = $_POST['newproduct'];
    
    $query1 = "UPDATE products SET description = '$desc' WHERE id = '$id';";
    
    if ($newproduct==1){
        $query2 = "INSERT INTO productdetails(productid, grocerid, saleprice, stock) VALUES ('$id', ".$_SESSION['grocerid'].", '$price', '$stock');";
    }else{
        $query2 = "UPDATE productdetails SET stock = '$stock', saleprice = '$price' where productid = '$id' AND grocerid = ".$_SESSION['grocerid'].";";
    }
    // connect to the database
    $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
    
    // run the insert statement
    $result1 = queryDB($query1, $db);
    $result2 = queryDB($query2, $db);
    
    $success = "Successfully updated product";
    header('location: grocerhome.php');
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
    <div class= "col-md-2">
        <?php
        $productid = $_GET['productid'];
        $query1 = 'SELECT * FROM products WHERE id ='.$productid.';';
        $query2 = 'SELECT * FROM productdetails WHERE productid = '.$productid.' and grocerid = '.$_SESSION['grocerid'].';';
        $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
        $result1 = queryDB($query1, $db);
        $result2 = queryDB($query2, $db);
        $product = nextTuple($result1);
        $product2 = nextTuple($result2);
        echo "<img src=".$product['image'].">";
        echo "</div>";
        echo "<div class= 'col-md-8'>";
        echo "<h2>".$product['brand']." ".$product['name']."</h2>\r\n";
        echo '<form class="form-inline" action="updateproducts.php" method="post">';
        echo '<input type="hidden" name="id" value='.$productid.'>';
        if (!isset($product2['saleprice'])){
            echo '<input type="hidden" name="newproduct" value= 1>';
        }
        echo '<label for="description">Description</label>';
        echo' <div class="form-group"><input type="text" class="form-control" name="description" value='. $product['description'].'></div>';
        echo '<label for="stock">Stock</label>';
        echo' <div class="form-group"><input type="text" class="form-control" name="stock" value='. $product2['stock'].'></div>';
        echo '<label for="saleprice">Saleprice</label>';
        echo '<div class="form-group">$<input type="text" class="form-control" name="saleprice" value='. $product2['saleprice'].'></div><button type="submit" class="btn btn-default" name="edit">Edit</button></form></div>';
        echo "</div>";
        
        

        
        
        ?>
    
</div>
</body>
</html>
