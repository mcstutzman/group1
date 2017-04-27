<?php
session_start();
$_SESSION['grocerid']=1;
$_SESSION['date']= date("Y-m-d");
if (!isset($_SESSION['customerid'])){
    $_SESSION['customerid']= '0';
}

?>

<html>
    <head>
<!-- Bootstrap links -->
<?php
    echo var_dump($_SESSION);
    /*if (!isset($_SESSION['theme'])){
        echo "1";
        $query = 'SELECT * FROM grocers where id=1;';
        echo "2";
        $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
        $result = queryDB($query, $db);
        $theme = nextTuple($result);
        echo "3";
        $_SESSION['theme']=$theme['theme'];
    }
    echo var_dump($_SESSION);
    include_once('ProjectHeader.php');*/
?>
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
    
<div class="jumbotron">
    <div class= "container">
        <h1>Welcome to Food.biz!</h1>
        <p>Please click here to create an account and start saving or browse our wide selection of products by clicking one of the links below.</p>
        <p><a class="btn btn-primary btn-lg" href="AccountCreation.php" role="button">Create Account</a>&nbsp<a class="btn btn-primary btn-lg" href="login.php" role="button">Log In</a></p>
    </div>
</div>
<!-- product categories -->

<div class="row">
    <div class="col-md-3">
        
    </div>
    <div class="col-xs-12 col-md-6">
    <?php
        $query = 'SELECT * from prodcategories where grocerid = '.$_SESSION['grocerid'].';';
        $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
        $result = queryDB($query, $db);
        while ($cat = nextTuple($result)){
            echo '<div class="col-xs-12 col-md-4">
                    <a href="shop.php?categoryid='.$cat['id'].'&grocerid='.$_SESSION['grocerid'].'" class="thumbnail">
                        <img src="'.$cat['thumbnail'].'" alt="'.$cat['name'].'"></a>
                    <div class="caption">
                    <h3><a href="shop.php?categoryid='.$cat['id'].'&grocerid='.$_SESSION['grocerid'].'">'.$cat['name'].'</a></h3>
                    </div>
                    </div>';
        }
        ?>
    </div>
</div>
    </body>
    <footer>
      <nav class="navbar navbar-default">
    <div class="container-fluid">
        <ul class="nav navbar-nav navbar-right">
            <li><a href="grocerlogin.php">Employee Login</a></li>
        </ul>
    </div>
</nav>  
    </footer>
</html>