<?php include "../../../inc/dbinfo.inc"; ?>
<?php session_start();?>


<?php
    $order_id = $_POST['order_id'];
    $item_name = $_POST['order_item_name'];
    $item_cost = $_POST['order_item_cost'];
    var_dump($item_name);
?>