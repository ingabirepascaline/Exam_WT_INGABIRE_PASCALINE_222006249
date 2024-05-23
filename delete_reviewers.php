<?php
// Include the database connection file
include('dbconnection.php');

// Check if ReviewerID is set
if(isset($_GET['ReviewerID'])) {
    // Get the ReviewerID from the URL
    $ReviewerID = $_GET['ReviewerID'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM reviewers WHERE ReviewerID=?");
    $stmt->bind_param("i", $ReviewerID);

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Execute the delete statement
        if ($stmt->execute()) {
            // Redirect to reviewers.php after successful deletion
            header('location: reviewers.php?msg=Data deleted successfully');
            exit(); // Ensure that no other content is sent after the header redirection
        } else {
            echo "Error deleting data: " . $stmt->error;
        }
    }

    // Close the statement
    $stmt->close();
} else {
    echo "ReviewerID is not set.";
}

// Close the connection
$connection->close();
?>
