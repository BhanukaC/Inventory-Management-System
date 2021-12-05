<?php
session_start();
include('include/config.php');
if (!isset($_SESSION['adlogin'])) {
    header('location:index.php');
    exit();
}




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receive log</title>
    <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link type="text/css" href="css/theme.css" rel="stylesheet">
    <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
          rel='stylesheet'>
    <script language="javascript" type="text/javascript">
        var popUpWin = 0;

        function popUpWindow(URLStr, left, top, width, height) {
            if (popUpWin) {
                if (!popUpWin.closed) popUpWin.close();
            }
            popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width=' + 600 + ',height=' + 600 + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
        }

    </script>
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
                            <h3>Receive log</h3>
                        </div>
                        <div class="module-body table">
                            <?php if (isset($_GET['del'])) {
                                ?>
                                <div class="alert alert-error">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>Oh
                                        snap!</strong> <?php echo htmlentities($_SESSION['delmsg']); ?><?php echo htmlentities($_SESSION['delmsg'] = ""); ?>
                                </div>
                            <?php } ?>

                            <br/>


                            <table cellpadding="0" cellspacing="0" border="0"
                                   id="table_id" class="display">
                                <thead>
                                <tr>

                                    <th>ID</th>
                                    <th>Vendor</th>
                                    <th>DATE & Time</th>
                                    <th>TOTAL</th>
                                    <th>View More Deatails</th>
                                  


                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                
                                $ret = mysqli_query($con, "select * from receive_main ");

                                while ($row = mysqli_fetch_array($ret)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $row['id'] ?></td>
                                        <td><?php echo $row['vendor_name'] ?></td>
                                        <td><?php echo $row['date'] ?></td>
                                        

                                        <td><?php echo "Rs." . $row['total'] ?></td>
                                        <td><a href="receive-details.php?od=<?php echo $row['id'] ?>"
                                               class="hiraola-btn hiraola-btn_dark hiraola-btn_sm"><span>View</span></a>
                                        </td>

                                        
                                    </tr>

                                <?php } ?>
                                </tbody>
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
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<script>
   $(document).ready( function () {
    $('#table_id').DataTable();
} );
</script>
</body>
