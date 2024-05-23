<?php
// Connection details
  include('dbconnection.php'); // Include your database connection file

// Check if ResourceID is set
if(isset($_REQUEST['ResourceID'])) {
    $ResourceID = $_REQUEST['ResourceID'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM resourcesharing WHERE ResourceID=?");
    $stmt->bind_param("i", $ResourceID);

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
            <input type="hidden" name="rid" value="<?php echo $ResourceID; ?>">
            <input type="submit" value="Delete">
        </form>

        <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if ($stmt->execute()) {
        // Redirect to resourcesharing.php after successful deletion
        header('location: resourcesharing.php?msg=Data deleted successfully');
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
    echo "ResourceID is not set.";
}

$connection->close();
?>
