<?php
session_start();

$orderid = intval($_GET["od"]);

include('include/config.php');
if (strlen($_SESSION['adlogin']) == 0) {
    header('location:index.php');
    exit();
} else {
date_default_timezone_set('Asia/Kolkata');// change according timezone
$currentTime = date('d-m-Y h:i:s A', time());



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Details</title>
    <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link type="text/css" href="css/theme.css" rel="stylesheet">
    <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
          rel='stylesheet'>
</head>
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
                            <h3>Issue Details</h3>
                        </div>
                        <div class="module-body">


                            <br/>


                            <br>

                            <table cellpadding="0" cellspacing="0" border="0"
                                   class=" table table-bordered table-striped	 display" width="100%">
                                <thead>
                                <tr>


                                    <th>Product</th>
                                    <th>Unit Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php

                                $ret = mysqli_query($con, "select * from issue_item where issue_id='$orderid'");

                                while ($row = mysqli_fetch_array($ret)) {
                                    
                                        ?>
                                        <tr>


                                            <td><?php echo deconvert($row['name']) ?>
                                            </td>
                                            <td><span
                                                        class="amount"><?php echo "Rs." . $row['price'] ?></span>
                                            </td>
                                            <td>
                                                <span
                                                        class="amount"><?php
                                                    
                                                        $qty = $row['qty'];
                                                    


                                                    echo $qty; ?></span>
                                            </td>
                                            <td><span
                                                        class="amount"><?php echo "Rs." . ($qty * $row['price']) ?></span>
                                            </td>
                                        </tr>

                                        <?php
                                    
                                }


                                ?>

                                </tbody>
                            </table>


                            <h2 style="text-align:center;">Other Details</h2>
                            <br>

                            <table>
                                <ul style="list-style: none;">

                                    <?php
                                    $ret = mysqli_query($con, "select * from issue_main where id='$orderid'");

                                    while ($row = mysqli_fetch_array($ret)) {
                                        
                                        ?>
                                        <li>Refernce Number - <span><?php echo $row['id'] ?></span></li>
                                        <li>Total - <span><?php echo "Rs." . $row['total'] ?></span></li>
                                        <li>Date - <span><?php echo $row['date'] ?></span></li>
                                       
                                        <li>Delivery Address - <span><?php
                                                echo $row["customer_name"] . ",";
                                                if (!empty($row["address1"])) {
                                                    echo $row["address1"] . ",";

                                                }
                                                if (!empty($row["address2"])) {
                                                    echo $row["address2"] . ",";

                                                }
                                                if (!empty($row["city"])) {
                                                    echo $row["city"] . ",";

                                                }
                                                if (!empty($row["zip"])) {
                                                    echo $row["zip"] . ".";

                                                }
                                                ?>
                                                </span></li>
                                        

                                        <?php
                                    }
                                    ?>

                                  


                                </ul>
                            </table>


                        </div>
                    </div>


                </div><!--/.content-->
            </div><!--/.span9-->
        </div>
    </div><!--/.container-->
</div><!--/.wrapper-->

<?php include('include/footer.php'); ?>

<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
<script src="scripts/datatables/jquery.dataTables.js"></script>
<script>
    $(document).ready(function () {
        $('.datatable-1').dataTable();
        $('.dataTables_paginate').addClass("btn-group datatable-pagination");
        $('.dataTables_paginate > a').wrapInner('<span />');
        $('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
        $('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
    });
</script>
</body>
<?php } ?>



