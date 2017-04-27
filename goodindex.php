

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
    
<div class="row">
    <div class="col-xs-12">
        <h1>Food.biz</h1>        
    </div>
</div>
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
    <div class="col-xs-12 col-md-2">
        <a href="shop.php?categoryid=4&grocerid=1" class="thumbnail">
            <img src="GroceryPics/steakTN.png" alt="meat">
        </a>
        <div class="caption">
            <h3><a href="shop.php?categoryid=4&grocerid=1">Meat</a></h3>
        </div>
    </div>
    <div class="col-xs-12 col-md-2 ">
        <a href="shop.php?categoryid=2&grocerid=1" class="thumbnail">
            <img src="GroceryPics/broccoliTN.jpg" alt="produce">
        </a>
        <div class="caption">
            <h3><a href="shop.php?categoryid=2&grocerid=1">Produce</a></h3>
        </div>
    </div>
    <div class="col-xs-12 col-md-2">
        <a href="shop.php?categoryid=1&grocerid=1" class="thumbnail">
            <img src="GroceryPics/milkTN.jpg" alt="dairy">
        </a>
        <div class="caption">
            <h3><a href="shop.php?categoryid=1&grocerid=1">Dairy</a></h3>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-xs-12 col-md-2 col-md-offset-3">
        <a href="shop.php?categoryid=3&grocerid=1" class="thumbnail">
            <img src="GroceryPics/toiletpaperTN.jpg" alt="paper products">
        </a>
        <div class="caption">
            <h3><a href="shop.php?categoryid=3&grocerid=1">Paper Products</a></h3>
        </div>
    </div>
    <div class="col-xs-12 col-md-2 ">
        <a href="shop.php?categoryid=5&grocerid=1" class="thumbnail">
            <img src="GroceryPics/herseybarTN.jpg" alt="candy">
        </a>
        <div class="caption">
            <h3><a href="shop.php?categoryid=5&grocerid=1">Candy</a></h3>
        </div>
    </div>
    
</div>
    </body>
</html>