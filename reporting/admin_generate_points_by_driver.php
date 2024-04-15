<?php include "../../../inc/dbinfo.inc"; ?>
<?php
    error_reporting(E_ALL);
    ini_set('display_errors',1);
    session_start();
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);

    $driver_username = $_POST['driver'];

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
    $test = fopen("csvs/{$start_range}_{$end_range}_point_details_for_$driver_username.csv", 'w');

    $header_array = array("Username", "First Name", "Last Name", "Total Points", "Point Changes", "Date of Point Change", "Associated Sponsor", "Reason For Point Change");
    echo "<b>Username\tFirst Name\tLast Name\tTotal Points\tPoint Changes\tDate of Point Change\tAssociated Sponsor\tReason For Point Change</b><br>";
    fputcsv($test, $header_array);

    if($driver_username === "All Drivers") {

        $driver_id_query = mysqli_query($connection, "SELECT * FROM drivers where driver_associated_sponsor != 'none'");  

        while($rows=$driver_id_query->fetch_assoc()) {
            $driver_id = $rows['driver_id'];
            $driver_curr_username = $rows['driver_username'];
            $driver_fname = $rows['driver_first_name'];
            $driver_lname = $rows['driver_last_name'];

            $sponsor_id_query = mysqli_query($connection, "SELECT * FROM driver_sponsor_assoc where driver_id = '$driver_id'");

            while($rows=$sponsor_id_query->fetch_assoc()) {
                $sponsor_name_id = $rows['assoc_sponsor_id'];
                $sponsor_name_query = mysqli_query($connection, "SELECT * FROM organizations WHERE organization_id='$sponsor_name_id'");

                while($rows=$sponsor_name_query->fetch_assoc()) {
                    $sponsor_name = $rows['organization_username'];

                    //Grabs point history info for all drivers
                    $total_driver_points_query = "SELECT * FROM point_history WHERE point_history_associated_sponsor = '$sponsor_name' AND point_history_driver_id = '$driver_id' AND point_history_date BETWEEN '$start_range' AND '$end_range_format'";
                    $total_points = mysqli_query($connection, $total_driver_points_query);

                    while($rows=$total_points->fetch_assoc()) {
                        $total_points = $rows['point_history_points'];
                        $point_changes = $rows['point_history_amount'];
                        $date = $rows['point_history_date'];
                        $reason = $rows['point_history_reason'];

                        //Stores info in an array to be written to the CSV.
                        $temp_array = array($driver_curr_username, $driver_fname, $driver_lname, $total_points, $point_changes, $date, $sponsor_name, $reason);
                        fputcsv($test, $temp_array);
                        echo "{$driver_curr_username}\t{$driver_fname}\t{$driver_lname}\t{$total_points}\t{$point_changes}\t{$date}\t{$sponsor_name}\t{$reason}<br>";
                    }

                }
            }
        }

    } else {

        $driver_id_query = mysqli_query($connection, "SELECT * FROM drivers where driver_username = '$driver_username'"); 

        while($rows=$driver_id_query->fetch_assoc()) {
            $driver_id = $rows['driver_id'];
            $driver_fname = $rows['driver_first_name'];
            $driver_lname = $rows['driver_last_name'];
        }

        $sponsor_id_query = mysqli_query($connection, "SELECT * FROM driver_sponsor_assoc where driver_id = '$driver_id'");

        while($rows=$sponsor_id_query->fetch_assoc()) {
            $sponsor_name_id = $rows['assoc_sponsor_id'];
            $sponsor_name_query = mysqli_query($connection, "SELECT * FROM organizations WHERE organization_id='$sponsor_name_id'");

            while($rows=$sponsor_name_query->fetch_assoc()) {
                $sponsor_name = $rows['organization_username'];

                    //Grabs point history info for selected driver
                    $total_driver_points_query = "SELECT * FROM point_history WHERE point_history_associated_sponsor = '$sponsor_name' AND point_history_driver_id = '$driver_id' AND point_history_date BETWEEN '$start_range' AND '$end_range_format'";
                    $total_points = mysqli_query($connection, $total_driver_points_query);

                    while($rows=$total_points->fetch_assoc()) {
                        $total_points = $rows['point_history_points'];
                        $point_changes = $rows['point_history_amount'];
                        $date = $rows['point_history_date'];
                        $reason = $rows['point_history_reason'];
                
                        $temp_array = array($driver_curr_username, $driver_fname, $driver_lname, $total_points, $point_changes, $date, $sponsor_name, $reason);
                        fputcsv($test, $temp_array);
                        echo "{$driver_curr_username}\t{$driver_fname}\t{$driver_lname}\t{$total_points}\t{$point_changes}\t{$date}\t{$sponsor_name}\t{$reason}<br>";
                    }
            }
        }
    }
    //Closes the file pointer.
    fclose($test);
?>
<a href=" <?= "http://team05sif.cpsc4911.com/S24-Team05/reporting/csvs/{$start_range}_{$end_range}_point_details_for_$driver_username.csv" ?>" download> Download csv... </a>