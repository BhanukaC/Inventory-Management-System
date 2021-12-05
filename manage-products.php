<?php
session_start();
include('include/config.php');

if (!isset($_SESSION['adlogin'])) {
    header('location:index.php');
    exit();
}
//product price update
if (isset($_POST['Update'])) {
    $pid = $_POST['pid'];
    $price = $_POST['price'];
    mysqli_query($con, "update products set PRODUCTPRICE='$price' where ID = $pid");
    //add activity record

    $uip = $_SERVER['REMOTE_ADDR'];
    $adminId = $_SESSION["id"];
    $activity = "Admin updated product price(productId-$pid)";
    $sql = mysqli_query($con, "insert into adminactivity(IP,AdminId,LOG) values('$uip',$adminId,'$activity')");
    $_SESSION['msg'] = "Product price Updated";
}


if (isset($_GET['del']) or isset($_POST['Update'])) {
    unset($_SESSION['is_refreshed']);

} else {
    //add activity record
    $uip = $_SERVER['REMOTE_ADDR'];
    $adminId = $_SESSION["id"];
    $activity = 'Admin come to manage-products.php';
    $sql = mysqli_query($con, "insert into adminactivity(IP,AdminId,LOG) values('$uip',$adminId,'$activity')");
}


if (isset($_GET['del'])) {
    mysqli_query($con, "delete from products where id = '" . $_GET['id'] . "'");
    $_SESSION['delmsg'] = "Product deleted !!";
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link type="text/css" href="css/theme.css" rel="stylesheet">
    <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
          rel='stylesheet'>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
          integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>

<body>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
<?php include('include/header.php'); ?>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <?php include('include/sidebar.php'); ?>
            <div class="span9">
                <div class="content">

                    <div class="module">
                        <div class="module-head">
                            <h3>Manage Products</h3>
                        </div>
                        <div class="module-body table">
                            <?php if (isset($_GET['del'])) {
                                ?>
                                <div class="alert alert-error">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>Oh snap!</strong>
                                    <?php echo htmlentities($_SESSION['delmsg']); ?><?php echo htmlentities($_SESSION['delmsg'] = ""); ?>
                                </div>
                                <?php
                                unset($_SESSION['delmsg']);

                            } ?>

                            <br/>
                            <!-- notification -->
                            <?php if (isset($_SESSION['msg'])) { ?>
                                <div class="alert alert-warning">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                    <b><?php echo $_SESSION['msg']; ?></b>
                                </div>

                                <?php
                                unset($_SESSION['msg']);

                            }
                            ?>


                            <table cellpadding="0" cellspacing="0" border="0"
                                   id="table_id" class="display" width="100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product Name</th>

                                    <th>Price(Rs.)</th>
                                    <th>Product Qty Availability</th>

                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tbody>

                                <?php $query = mysqli_query($con, "select * from products  ");

                                while ($row = mysqli_fetch_array($query)) {
                                    ?>
                                    <tr>
                                        <td><?php

                                            echo htmlentities($row['id']); ?></td>
                                        <td><?php echo deconvert($row['productname']); ?></td>


                                        <td>
                                            <?php echo htmlentities($row['productprice']); ?>

                                        </td>
                                        <td><?php echo htmlentities($row['qty']); ?></td>

                                        <td>
                                            <a href="edit-products.php?id=<?php echo $row['id'] ?>"><i
                                                        class="icon-edit"></i></a>
                                            <a href="manage-products.php?id=<?php echo $row['id'] ?>&del=delete"
                                               onClick="return confirm('Are you sure you want to delete?')"><i
                                                        class="icon-remove-sign"></i></a>
                                        </td>


                                    </tr>
                                <?php } ?>

                            </table>
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
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function () {
        $('#table_id').DataTable();
    });
</script>
</body>
