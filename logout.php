<?php
session_start();
include("include/config.php");
//add activity record
$uip = $_SERVER['REMOTE_ADDR'];
$adminId = $_SESSION["id"];
$activity = 'Admin log out from dashboard';
$sql = mysqli_query($con, "insert into adminactivity(IP,AdminId,LOG) values('$uip',$adminId,'$activity')");

unset($_SESSION['adlogin']);
$sesid = $_SESSION['sesAID'];

$dt = new DateTime();
$timestamp = date_timestamp_get($dt);

$sql = mysqli_query($con, "update adminlog set LOGOUTTIME='$timestamp' where ID='$sesid'");

session_destroy();

?>
<script language="javascript">
    document.location = "index.php";
</script>
