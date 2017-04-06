

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
?>
    
<nav class="navbar navbar-default">
  <div class="container-fluid">
    
     <ul class="nav navbar-nav navbar-right">
        <li><a href="account.php"></a>Account</li>
        <?php
        if (isset($_SESSION['email'])) {
            echo "<li><a href="login.php"></a>log in</li>";            
        }
        else{
            echo "<li><a href="logout.php">log out</a></li>";
        }
        ?>
        <li><a href="cart.php"></a>cart</li>
     </ul>
  </div>
</nav>

<!-- product categories -->
