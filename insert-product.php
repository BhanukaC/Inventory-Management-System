<?php
session_start();
//error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['adlogin']) == 0) {
    header('location:index.php');
    exit();
} else {


    if (isset($_POST['submit'])) {

        $name=$_POST['productName'];
        $productprice=$_POST['productprice'];
        $qty=$_POST['qty'];
        
        $sql = mysqli_query($con, "insert into products(productname,productprice,qty) values('$name','$productprice','$qty')");

        $_SESSION['msg'] = "Product Inserted Successfully !!";
       

    }


    ?>
    <!DOCTYPE html>
    <html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Product</title>
    <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link type="text/css" href="css/theme.css" rel="stylesheet">
    <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
          rel='stylesheet'>
    <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
    <script type="text/javascript">
        bkLib.onDomLoaded(nicEditors.allTextAreas);
    </script>

    <script>
        function selectCountry(val) {
            $("#search-box").val(val);
            $("#suggesstion-box").hide();
        }
    </script>


</head>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>


<body>
<?php include('include/header.php'); ?>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <?php include('include/sidebar.php'); ?>
            <div class="span9">
                <div class="content">

                    <div class="module">
                        <div class="module-head">
                            <h3>Insert Product</h3>
                        </div>
                        <div class="module-body">

                            <?php if (isset($_POST['submit'])) {
                                ?>
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>Well done!</strong>
                                    <?php echo htmlentities($_SESSION['msg']); ?><?php echo htmlentities($_SESSION['msg'] = "");
                                    unset($_SESSION['msg']); ?>
                                </div>
                            <?php } ?>


                            <?php if (isset($_GET['del'])) {
                                ?>
                                <div class="alert alert-error">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>Oh snap!</strong>
                                    <?php echo htmlentities($_SESSION['delmsg']); ?><?php echo htmlentities($_SESSION['delmsg'] = ""); ?>
                                </div>
                            <?php } ?>

                            <br/>

                            <form class="form-horizontal row-fluid" name="insertproduct" method="post"
                                  enctype="multipart/form-data">


                                <div class="control-group">
                                    <label class="control-label" for="basicinput">Product Name</label>
                                    <div class="controls">
                                        <input type="text" name="productName" placeholder="Enter Product Name"
                                               class="span8 tip" required>
                                    </div>
                                </div>
   
                                <div class="control-group">
                                    <label class="control-label" for="basicinput">Product Price</label>
                                    <div class="controls">
                                        <input type="number" name="productprice" placeholder="Enter Product Price"
                                               class="span8 tip" value="0">
                                    </div>
                                </div>


                               

                                <div class="control-group">
                                    <label class="control-label" for="basicinput">Start Quantity</label>
                                    <div class="controls">
                                        <input type="number" name="qty" placeholder="Start Quantity"
                                               class="span8 tip" value="0">
                                    </div>
                                </div>

                                 


                                <div class="control-group">
                                    <div class="controls">
                                        <button type="submit" name="submit" class="btn">Insert</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>
                <!--/.content-->
            </div>
            <!--/.span9-->
        </div>
    </div>
    <!--/.container-->
</div>
<!--/.wrapper-->

<?php include('include/footer.php'); ?>

<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
</body>
<?php } ?>