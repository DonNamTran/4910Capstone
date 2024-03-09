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


// WIP
// Prepare query on catalog table
/*$sql_catalog = "INSERT INTO catalog;
$stmt_catalog = $conn->prepare($sql_catalog);
$stmt_catalog->bind_param("i", $archived);*/

if ($stmt_catalog->execute()) {
    echo '<script>alert("Successfully added to catalog!\n")</script>';
    echo '<script>window.location.href = "http://team05sif.cpsc4911.com/S24-Team05/catalog/sponsor_catalog_home.php"</script>';
}
else{
    echo '<script>alert("Failed to unarchive account...\n\nCheck your information and retry...")</script>';
    echo '<script>window.location.href = "sponsor_add_to_catalog.php"</script>';
}
?>

</body>
</html>