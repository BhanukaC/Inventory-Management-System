<?php
session_start();
//unset($_SESSION['cart']);
include('include/config.php');

if (isset($_POST['add_to_cart'])) {

    $id = $_GET['id'];
    $qty = $_POST['quantity'];
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] = $_SESSION['cart'][$id]['quantity'] + $qty;

    } else {

        $_SESSION['cart'][$id] = array("quantity" => $qty, "price" => $_POST['price'], "name" => $_POST['name']);

    }
}

if (isset($_GET['action'])) {
    if ($_GET['action'] == "clearall") {
        unset($_SESSION['cart']);
    }

    if ($_GET['action'] == "remove") {
        unset($_SESSION['cart'][$_GET['id']]);


    }
}


if (isset($_POST['issue_stock'])) {
    $name = $_POST['name'];
    $add1 = $_POST['add1'];
    $add2 = $_POST['add2'];
    $city = $_POST['city'];
    $zip = $_POST['zip'];

    $total = 0;
    foreach ($_SESSION['cart'] as $key => $value) {
        $total += ($value['quantity'] * $value['price']);
    }

    $sql = mysqli_query($con, "insert into issue_main(customer_name,address1,address2,city,zip,total) values('$name','$add1','$add2','$city','$zip','$total')");

    $queryd = mysqli_query($con, "select max(id) from issue_main where customer_name='$name'");

    $resultd = mysqli_fetch_array($queryd, MYSQLI_BOTH);

    $oid = $resultd[0];

    foreach ($_SESSION['cart'] as $key => $value) {
        $name = $value['name'];
        $price = $value['price'];
        $qty = $value['quantity'];
        $sql = mysqli_query($con, "insert into issue_item(name,price,qty,issue_id) values('$name','$price','$qty','$oid')");

        $queryd = mysqli_query($con, "select qty from products where id='$key'");

        $resultd = mysqli_fetch_array($queryd, MYSQLI_BOTH);

        $qty_last = $resultd[0] - $qty;

        $sql = mysqli_query($con, "update products set qty='$qty_last' where id='$key'");
    }

    unset($_SESSION['cart']);

    header("location:issue-details.php?od=$oid");
    exit();


}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Issue Stock</title>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

</head>
<body>
<h1>Nav Bar</h1>
<hr>
<div class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <h2>Product Details</h2>
                <div class="col-md-12">
                    <div class="row">


                        <?php

                        $query = "select * from products where qty>0";
                        $result = mysqli_query($con, $query);

                        while ($row = mysqli_fetch_array($result)) {
                            ?>
                            <div class="col-md-4">
                                <form action="issue-stock.php?id=<?php echo $row['id'] ?>" method="post"
                                      style="border:1px solid;margin:5px;">
                                    <h5 class="text-center"><?php echo $row['productname'] ?></h5>
                                    <h5 class="text-center">Rs.<?php echo $row['productprice'] ?></h5>
                                    <input type="number" name="quantity" value="1" class="form-control">
                                    <input type="hidden" name="name" value="<?php echo $row['productname'] ?>">
                                    <input type="hidden" name="price" value="<?php echo $row['productprice'] ?>">

                                    <input type="submit" value="Add to list" class="btn btn-warning btn-block my-2"
                                           name="add_to_cart">
                                </form>
                            </div>

                            <?php
                        }


                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h2>Issue Details</h2>


                <table class="table table-bordered table-striped">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Action</th>
                    </tr>
                    <?php

                    if (!empty($_SESSION['cart'])) {
                        $total = 0;
                        foreach ($_SESSION['cart'] as $key => $value) {
                            $total += ($value['quantity'] * $value['price']);

                            ?>
                            <tr>
                                <td><?php echo $key ?></td>
                                <td><?php echo $value['name'] ?></td>
                                <td><?php echo $value['price'] ?></td>
                                <td><?php echo $value['quantity'] ?></td>
                                <td><?php echo($value['price'] * $value['quantity']) ?></td>
                                <td><a href="issue-stock.php?action=remove&id=<?php echo $key ?>">
                                        <button class="btn btn-danger btn-block">Remove</button>
                                    </a></td>

                            </tr>
                            <?php
                        } ?>
                        <tr>
                            <td colspan="3"></td>
                            <td><b>Total Price</b></td>
                            <td><?php echo $total ?></td>
                            <td><a href="issue-stock.php?action=clearall">
                                    <button class="btn btn-warning btn-block">Clear All</button>
                                </a></td>
                        </tr>

                        <?php
                    }

                    ?>

                </table>

                <form method="post">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputEmail4">Customer Name</label>
                            <input type="text" class="form-control" id="inputEmail4" placeholder="Name" name="name">
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Customer Address</label>
                        <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St"
                               name="add1">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress2">Customer Address 2</label>
                        <input type="text" class="form-control" id="inputAddress2"
                               placeholder="Apartment, studio, or floor" name="add2">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputCity">Customer City</label>
                            <input type="text" class="form-control" id="inputCity" name="city">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputZip">Customer Zip</label>
                            <input type="text" class="form-control" id="inputZip" name="zip">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" name="issue_stock">Issue stock</button>
                </form>


            </div>

        </div>

    </div>
</div>
</body>
</html>