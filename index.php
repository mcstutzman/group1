

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

$_SESSION['grocerid']=1;
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
    <div class="col-xs-12 col-md-6">
    <?php
        $query = 'SELECT * from prodcategories;';
        $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
        $result = queryDB($query, $db);
        while ($cat = nextTuple($result)){
            echo '<div class="col-xs-12 col-md-4">
                    <a href="shop.php?categoryid='.$cat['id'].'&grocerid='.$_SESSION['grocerid'].'" class="thumbnail">
                        <img src="'.$cat['thumbnail'].'" alt="'.$cat['name'].'"></a>
                    <div class="caption">
                    <h3><a href="shop.php?categoryid='.$cat['id'].'&grocerid=1">'.$cat['name'].'</a></h3>
                    </div>
                    </div>';
        }
        ?>
    </div>
 
    </body>
</html>