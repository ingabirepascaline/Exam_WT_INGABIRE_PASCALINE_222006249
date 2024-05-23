<?php
// Connection details
  include('dbconnection.php'); // Include your database connection file

// Check if PaymentID is set
if(isset($_REQUEST['PaymentID'])) {
    $PaymentID = $_REQUEST['PaymentID'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM payments WHERE PaymentID=?");
    $stmt->bind_param("i", $PaymentID);

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
            <input type="hidden" name="pid" value="<?php echo $PaymentID; ?>">
            <input type="submit" value="Delete">
        </form>

        <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if ($stmt->execute()) {
        // Redirect to payments.php after successful deletion
        header('location: payments.php?msg=Data deleted successfully');
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
    echo "PaymentID is not set.";
}

$connection->close();
?>
