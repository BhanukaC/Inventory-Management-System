<?php
session_start();
error_reporting(0);
include("include/config.php");

if (isset($_SESSION['adlogin'])) {
    header("location:change-password.php");
    exit();
}



if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $ret = mysqli_query($con, "SELECT * FROM users WHERE name='$username'");
    $num = mysqli_fetch_array($ret, MYSQLI_BOTH);

    if (strcmp($num["password"], $password) == 0) {

        $_SESSION['adlogin'] = $_POST['username'];
        $_SESSION['id'] = $num['id'];
        header("location:change-password.php");
        exit();
    } else {
        $_SESSION['errmsg'] = "Invalid username or password";
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link type="text/css" href="css/theme.css" rel="stylesheet">
    <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
          rel='stylesheet'>
          <meta name="facebook-domain-verification" content="eciobzheuh0lskv508772ldxvgu2r3" />
</head>

<body>


<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
                <i class="icon-reorder shaded"></i>
            </a>

            <a class="brand">
                Inventory Management System
            </a>

            
        </div>
    </div><!-- /navbar-inner -->
</div><!-- /navbar -->
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }


</script>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="module module-login span4 offset4">
                <form class="form-vertical" method="post">
                    <div class="module-head">
                        <h3>Sign In</h3>
                    </div>
                    
                    <span
                            style="color:red;"><?php echo htmlentities($_SESSION['errmsg']); ?><?php echo htmlentities($_SESSION['errmsg'] = ""); ?></span>
                    <div class="module-body">
                        <div class="control-group">
                            <div class="controls row-fluid">
                                <input class="span12" type="text" id="inputEmail" name="username"
                                       placeholder="Username">
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls row-fluid">
                                <input class="span12" type="password" id="inputPassword" name="password"
                                       placeholder="Password">
                            </div>
                        </div>
                    </div>
                    <div class="module-foot">
                        <div class="control-group">
                            <div class="controls clearfix">
                                <button type="submit" class="btn btn-primary pull-right" name="submit">Login
                                </button>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--/.wrapper-->

<?php include('include/footer.php'); ?>
<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</body>