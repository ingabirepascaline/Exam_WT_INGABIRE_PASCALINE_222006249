<?php
// Connection details
  include('dbconnection.php'); // Include your database connection file

// Check if SessionID is set
if(isset($_REQUEST['SessionID'])) {
    $SessionID = $_REQUEST['SessionID'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM exchangesessions WHERE SessionID=?");
    $stmt->bind_param("i", $SessionID);

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
            <input type="hidden" name="sid" value="<?php echo $SessionID; ?>">
            <input type="submit" value="Delete">
        </form>

        <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if ($stmt->execute()) {
        // Redirect to exchangesessions.php after successful deletion
        header('location: exchangesessions.php?msg=Data deleted successfully');
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
    echo "SessionID is not set.";
}

$connection->close();
?>
