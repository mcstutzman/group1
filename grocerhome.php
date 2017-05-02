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
if (!isset($_SESSION['employeeid'])){
	header('location: grocerlogin.php');
	exit;
	}
if ($_SESSION['admin'] == 0){
	header('location: manageorders.php');
	exit;
}

if (isset($_POST['submit'])){
    include_once('config.php');
	include_once('dbutils.php');
    $theme = $_POST['theme'];
    
	$db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
	$query = "UPDATE grocers SET theme= '$theme' where id= ".$_SESSION['grocerid'].";";
	$result = queryDB($query, $db);
   
	$_SESSION['theme'] = $theme;
	$success = "Theme set";
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
<h1>Food.biz</h1>
<?php
    if (isset($success)) {
        // for successes after the form was submitted
		header('redirect.php');
        echo '<div class="alert alert-success" role="alert">';
        echo ($success);
        echo '</div>';
        }
?>
<div class="row">&nbsp</div>
<div class="row">
	<div class= "col-xs-12">
		
	<form action="grocerhome.php" method="post">
	<div class="form-group">
    <label for="theme">Select Theme:</label>
    <label class="radio-inline">
        <input type="radio" name="theme" value="superhero" ><img src=https://bootswatch.com/superhero/thumbnail.png style="width: 100px ;height: 60px">
    </label>
	&nbsp
    <label class="radio-inline">
        <input type="radio" name="theme" value="yeti"><img src=https://bootswatch.com/yeti/thumbnail.png style="width: 100px ;height: 60px">
    </label>
	&nbsp
	<label class="radio-inline">
        <input type="radio" name="theme" value="united"><img src=https://bootswatch.com/united/thumbnail.png style="width: 100px ;height: 60px">
    </label>
	&nbsp
	<label class="radio-inline">
        <input type="radio" name="theme" value="spacelab"><img src=https://bootswatch.com/spacelab/thumbnail.png style="width: 100px ;height: 60px">
    </label>
	&nbsp
	<label class="radio-inline">
        <input type="radio" name="theme" value="journal"><img src=https://bootswatch.com/journal/thumbnail.png style="width: 100px ;height: 60px">
    </label>
	&nbsp
	<label class="radio-inline">
        <input type="radio" name="theme" value="cerulean"><img src=https://bootswatch.com/cerulean/thumbnail.png style="width: 100px ;height: 60px">
    </label>
	&nbsp

<button type="submit" class="btn btn-default" name="submit">Update Theme</button>
</div>
</form>
	</div>
	
<div class="row">
    <div class = "col-md-1">
        <div class="list-group">
        <?php
        $query = 'SELECT * from prodcategories;';
        $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
        $result = queryDB($query, $db);
        while ($cat = nextTuple($result)){
            echo '<a href="grocerhome.php?categoryid='.$cat['id'].'" class="list-group-item">'.$cat['name'].'</a>';
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
        <th>Brand</th>
        <th>Name</th>
        <th>Sale Price</th>
        <th>Stock</th>        
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
        echo "<td><a href='updateproducts.php?productid=".$row['id']."'><img src='" . $row['thumbnail'] . "'class='img-responsive'></a></td>";
        echo "<td>" . $row['brand']. "</td>";
        echo "<td>" . $row['name'] . "</td>";
        $pricequery = 'SELECT * FROM productdetails WHERE productid = '.$row['id'].' AND grocerid = '.$_SESSION['grocerid'].';';
		$priceresult = queryDB($pricequery, $db);
		$price = nextTuple($priceresult);
        echo "<td>$".$price['saleprice']."</td>";
        echo "<td>".$price['stock']."</td>";        
               
        echo "</tr> \n";
    }
    
    
?>        
    
</table>
        
    </div>
</div>
</body>
</html>