<?php include "../../../inc/dbinfo.inc"; ?>

<html>
<body>

<?php
// Create connection to database

session_start();
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
$database = mysqli_select_db($connection, DB_DATABASE);

// Get query variables from POST
$sponsor_id = $_POST['organization_id'];
$archived = 0;

$sql_organization = "UPDATE organizations SET organization_archived=? WHERE organization_id=?";
$stmt_organization = $connection->prepare($sql_organization);
$stmt_organization->bind_param('ii',$archived,$sponsor_id);

// Check for invald info
if($stmt_organization->execute()){
    echo '<script>alert("The organization has been unarchived succesfully!")</script>';
    echo '<script>window.location.href = "admin_unarchive_sponsor_company.php"</script>';
}
?>

</body>
</html>