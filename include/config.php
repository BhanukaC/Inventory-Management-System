<?php
$con = mysqli_connect("localhost", "root", "root", "inventory");

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}


function convert($str)
{
    return htmlspecialchars($str, ENT_QUOTES);
}


function deconvert($str)
{
    return htmlspecialchars_decode($str);
}

?>