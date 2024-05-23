<?php
// Connection details
  include('dbconnection.php'); // Include your database connection file

// Check if LanguageID is set and is a positive integer
if(isset($_REQUEST['LanguageID']) && $_REQUEST['LanguageID'] > 0) {
    $LanguageID = $_REQUEST['LanguageID']; // No need to escape, prepared statements handle it

    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM languages WHERE LanguageID = ?");
    if($stmt) {
        $stmt->bind_param("i", $LanguageID);

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
                <input type="hidden" name="LanguageID" value="<?php echo $LanguageID; ?>">
                <input type="submit" value="Delete">
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if ($stmt->execute()) {
                    // Redirect to languages.php after successful deletion
                    header('Location: languages.php?msg=Data deleted successfully');
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
