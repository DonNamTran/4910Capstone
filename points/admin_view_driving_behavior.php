<?php include "../../../inc/dbinfo.inc"; ?>

<html>
<body>

<?php
// Create connection to database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if (mysqli_connect_errno()) {  
    echo "Database connection failed.";  
}  

session_start();
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
$database = mysqli_select_db($connection, DB_DATABASE);

$result = mysqli_query($connection, "SELECT * FROM sponsors");

// Get query variables from POST
$driving_behavior = $_POST['driving_behavior'];
$point_val = $_POST['point_val'];
$archived = 0;

// Create query to see if driving behavior already exists
$driving_behavior_query = mysqli_query($conn, "SELECT * FROM driving_behavior ORDER BY driving_behavior_associated_sponsor");
?>
<div class="div_before_table">
<table>
    <tr>
        <th class="sticky">Behavior ID</th>
        <th class="sticky">Description</th>
        <th class="sticky">Point Value</th>
        <th class="sticky">Sponsor</th>
    </tr>
    <!-- PHP CODE TO FETCH DATA FROM ROWS -->
    <?php 
        // LOOP TILL END OF DATA
        while($rows=$result->fetch_assoc())
        {
    ?>
    <tr>
        <!-- FETCHING DATA FROM EACH
            ROW OF EVERY COLUMN -->
        <td><?php echo $rows['driving_behavior_id'];?></td>
        <td><?php echo $rows['driving_behavior_desc'];?></td>
        <td><?php echo $rows['driving_behavior_point_val'];?></td>
        <td><?php echo $rows['driving_behavior_associated_sponsor'];?></td>
    </tr>
    <?php
        }
    ?>
</table>
</div>


</body>
</html>