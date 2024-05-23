<?php
// Connection details
  include('dbconnection.php'); // Include your database connection file

// Check if ParticipantID is set and is a positive integer
if(isset($_REQUEST['ParticipantID']) && $_REQUEST['ParticipantID'] > 0) {
    $ParticipantID = $_REQUEST['ParticipantID']; // No need to escape, prepared statements handle it

    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM participants WHERE ParticipantID = ?");
    if($stmt) {
        $stmt->bind_param("i", $ParticipantID);

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
                <input type="hidden" name="ParticipantID" value="<?php echo $ParticipantID; ?>">
                <input type="submit" value="Delete">
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if ($stmt->execute()) {
                    // Redirect to participants.php after successful deletion
                    header('Location: participants.php?msg=Data deleted successfully');
                    exit(); // Ensure no other content is sent after redirection
                } else {
                    echo "Error executing deletion: " . $stmt->error;
                }
            }
            ?>
        </body>
        </html>
        <?php
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

$connection->close();
?>
