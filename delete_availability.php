
<?php
// Connection details
  include('dbconnection.php'); // Include your database connection file

// Check if AvailabilityID is set
if(isset($_REQUEST['AvailabilityID'])) {
    $AvailabilityID = $_REQUEST['AvailabilityID'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM availability WHERE AvailabilityID=?");
    $stmt->bind_param("i", $AvailabilityID);

    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Delete Record</title>
        <script>
            function confirmDelete() {
                return confirm("Are you sure you want to delete this record?");
            }
        </script>
    </head>
    <body>
        <form method="post" onsubmit="return confirmDelete();">
            <input type="hidden" name="aid" value="<?php echo $AvailabilityID; ?>">
            <input type="submit" value="Delete">
        </form>

        <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if ($stmt->execute()) {
        // Redirect to availability.php after successful deletion
        header('location: availability.php?msg=Data deleted successfully');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        echo "Error deleting data: " . $stmt->error;
    }
}
     ?>
</body>
</html>
<?php

    $stmt->close();
} else {
    echo "AvailabilityID is not set.";
}

$connection->close();
?>
