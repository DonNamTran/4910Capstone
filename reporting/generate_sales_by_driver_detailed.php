<?php include "../../../inc/dbinfo.inc"; ?>
<style>
    /* Table formatting from https://www.w3schools.com/css/css_table.asp */
    #point-details {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #point-details td, #point-details th {
        padding: 8px;
        border-bottom: 1px solid #ddd;
    }

    #point-details tr:nth-child(even){background-color: #f2f2f2;}

    #point-details tr:hover {background-color: #ddd;}

    #point-details th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #b8a97b;
        color: white;
    }
</style>
<?php
    //error_reporting(E_ALL);
    //ini_set('display_errors',1);
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);

    $driver = $_POST['account_id'];
    
    if($driver === "All Drivers") {
        $driver_name = "All Drivers";
    } else {
        $driver_name_query = mysqli_query($connection, "SELECT * FROM drivers WHERE driver_id = $driver");
        $driver_name = ($driver_name_query->fetch_assoc())['driver_username'];
    }

    //Formats the dates so they don't cause errors when naming the CSV file.
    $start_range = $_POST['start_date'];
    $start_range = (new DateTime($start_range))->format("Y-m-d");
    $end_range = $_POST['end_date'];
    
    //Adds 23:59:59 to the end range to make it include all orders on that day.
    $end_range_format = new DateTime($end_range);
    $end_range_format->add(new DateInterval("PT23H59M59S"));
    $end_range_format = $end_range_format->format("Y-m-d H:i:s");
    
    $end_range = (new DateTime($end_range))->format("Y-m-d");

    //Opens the CSV file for writing, overwrites any existing one. 
    $test = fopen("csvs/{$start_range}_{$end_range}_detailed_for_$driver_name.csv", 'w');

    $header_array = array("Detailed Sales By Driver Report - {$driver_name}");
    fputcsv($test, $header_array);

    ?>
    <table id="point-details">
    <tr>
        <th colspan = "5"; style = "background-color: #857f5b"> Detailed Sales By Driver Report - <?php echo "{$driver_name} - $start_range,$end_range" ?></th>
    </tr>
    <?php

    if($driver === "All Drivers") {
        echo "<tr>
            <th>Driver</th>
            <th>Item</th>
            <th>Category</th>
            <th>Units</th>
            <th>Sales</th>
        </tr>";
        fputcsv($test, array("Driver", "Item", "Category", "Units", "Sales"));
        //Grabs the total sales from ALL DRIVERS.
        $total_driver_sales_query = "SELECT *, SUM(order_contents_item_cost*organization_dollar2pt) AS total_sales FROM orders 
        JOIN order_contents 
            ON orders.order_id = order_contents.order_id
        JOIN organizations 
            ON orders.order_associated_sponsor=organizations.organization_username 
                WHERE order_contents_removed = 0 AND order_date_ordered BETWEEN '$start_range' AND '$end_range_format'";
        $total_sales = mysqli_query($connection, $total_driver_sales_query);
        $result = $total_sales->fetch_assoc();
        $total_sales =  number_format($result['total_sales'], 2);

        //Grabs the total sales from EACH driver
        $total_driver_sales_by_driver = "SELECT *, SUM(order_contents_item_cost*organization_dollar2pt) AS total_sales, count(order_contents_item_name) as qty FROM orders 
        JOIN order_contents 
            ON orders.order_id = order_contents.order_id
        JOIN organizations 
            ON orders.order_associated_sponsor=organizations.organization_username 
        JOIN drivers
            on orders.order_driver_id=drivers.driver_id 
        WHERE order_contents_removed = 0 AND order_date_ordered BETWEEN '$start_range' AND '$end_range_format'
            GROUP BY order_driver_id, order_contents_item_name";
        $total_by_item = mysqli_query($connection, $total_driver_sales_by_driver);

        while($row=$total_by_item->fetch_assoc()) {
            $sales_by_item =  number_format($row['total_sales'], 2);
            $qty = $row['qty'];
            //Stores the driver and sales by item in an array to be written to the CSV.
            $temp_array = array($row['driver_username'], $row['order_contents_item_name'], $row['order_contents_item_type'],$qty, $sales_by_item);
            fputcsv($test, $temp_array);
            ?>
            <tr>
                <td><?php echo "{$row['driver_username']}" ?></td>
                <td><?php echo "{$row['order_contents_item_name']}" ?></td>
                <td><?php echo "{$row['order_contents_item_type']}" ?></td>
                <td><?php echo "$qty" ?></td>
                <td><?php echo "$","{$sales_by_item}" ?></td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td><?php echo "<b>TOTAL</b>" ?></td>
            <td><?php echo "" ?></td>
            <td><?php echo "" ?></td>
            <td><?php echo "" ?></td>
            <td><?php echo "<b>","$",$total_sales,"</b>" ?></td>
        </tr>
        <?php
    } else {
        echo "<tr>
        <th>Driver</th>
        <th>Date Purchased</th>
        <th>Item</th>
        <th>Category</th>
        <th>Sales</th>
        </tr>";
        fputcsv($test, array("Driver", "Purchase Date", "Item", "Category", "Sales"));
        //Grabs the total sales from the specified driver.
        $total_sponsor_sales_query = "SELECT *, SUM(order_contents_item_cost*organization_dollar2pt) AS total_sales FROM orders 
        JOIN order_contents 
            ON orders.order_id = order_contents.order_id
        JOIN organizations 
            ON orders.order_associated_sponsor=organizations.organization_username 
                WHERE order_driver_id='$driver' AND order_contents_removed = 0 AND order_date_ordered BETWEEN '$start_range' AND '$end_range_format'
            GROUP BY order_driver_id";
        $total_sales = mysqli_query($connection, $total_sponsor_sales_query);
        $result = $total_sales->fetch_assoc();
        $total_sales =  number_format(  $result['total_sales'], 2);
    
        //Grabs the total sales by item from the specified driver.
        $total_sponsor_sales_by_item_query = "SELECT *, SUM(order_contents_item_cost*organization_dollar2pt) AS total_sales FROM orders 
        JOIN order_contents 
            ON orders.order_id = order_contents.order_id
        JOIN organizations 
            ON orders.order_associated_sponsor=organizations.organization_username 
        JOIN drivers
            on orders.order_driver_id=drivers.driver_id 
        WHERE order_driver_id='$driver' AND order_contents_removed = 0 AND order_date_ordered BETWEEN '$start_range' AND '$end_range_format'
            GROUP BY order_driver_id, order_contents_item_name, order_date_ordered";
        $total_by_item = mysqli_query($connection, $total_sponsor_sales_by_item_query);
        while($row=$total_by_item->fetch_assoc()) {
            $sales_by_item =  number_format($row['total_sales'], 2);
            $qty = $row['qty'];
            //Stores the driver and sales by item in an array to be written to the CSV.
            $temp_array = array($row['driver_username'],$row['order_date_ordered'], $row['order_contents_item_name'], $row['order_contents_item_type'], $sales_by_item);
            fputcsv($test, $temp_array);
            ?>
            <tr>
                <td><?php echo "{$row['driver_username']}" ?></td>
                <td><?php echo "{$row['order_date_ordered']}" ?></td>
                <td><?php echo "{$row['order_contents_item_name']}" ?></td>
                <td><?php echo "{$row['order_contents_item_type']}" ?></td>
                <td><?php echo "$","{$sales_by_item}" ?></td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td><?php echo "<b>TOTAL</b>" ?></td>
            <td><?php echo "" ?></td>
            <td><?php echo "" ?></td>
            <td><?php echo "" ?></td>
            <td><?php echo "<b>","$",$total_sales,"</b>" ?></td>
        </tr>
        <?php
    }
    //Closes the file pointer.
    fclose($test);
?>
<a href=" <?= "http://team05sif.cpsc4911.com/S24-Team05/reporting/csvs/{$start_range}_{$end_range}_detailed_for_$driver_name.csv" ?>" download> Download csv... </a>