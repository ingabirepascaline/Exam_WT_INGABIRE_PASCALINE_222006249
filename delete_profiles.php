<?php
// Connection details
  include('dbconnection.php'); // Include your database connection file

// Check if ProfileID is set
if(isset($_REQUEST['ProfileID'])) {
    $ProfileID = $_REQUEST['ProfileID'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM profiles WHERE ProfileID=?");
    $stmt->bind_param("i", $ProfileID);

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
            <input type="hidden" name="pid" value="<?php echo $ProfileID; ?>">
            <input type="submit" value="Delete">
        </form>

        <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if ($stmt->execute()) {
        // Redirect to profiles.php after successful deletion
        header('location: profiles.php?msg=Data deleted successfully');
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
    echo "ProfileID is not set.";
}

$connection->close();
?>
