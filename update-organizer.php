<?php
// Connection details
  include('dbconnection.php'); // Include your database connection file
// Check if OrganizerID is set
if(isset($_REQUEST['OrganizerID'])) {
    $OrganizerID = $_REQUEST['OrganizerID'];
    
    // Prepare and execute the DELETE statement
    $stmt = $conn->prepare("DELETE FROM organizer WHERE OrganizerID=?");
    $stmt->bind_param("i", $OrganizerID);

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
            <input type="hidden" name="oid" value="<?php echo $OrganizerID; ?>">
            <input type="submit" value="Delete">
        </form>

        <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if ($stmt->execute()) {
        // Redirect to organizer.php after successful deletion
        header('location: organizer.php?msg=Data deleted successfully');
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
    echo "OrganizerID is not set.";
}

$conn->close();
?>
