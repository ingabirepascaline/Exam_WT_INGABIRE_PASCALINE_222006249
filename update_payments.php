<?php
// Connection details
  include('dbconnection.php'); // Include your database connection file

// Initialize variables to avoid PHP notices
$PaymentID = $UserID = $Amount = $PaymentDate = $PaymentMethod = $Description = "";

// Check if PaymentID is set
if(isset($_POST['PaymentID'])) {
    $PaymentID = $_POST['PaymentID'];
    $UserID = $_POST['UserID'];
    $Amount = $_POST['Amount'];
    $PaymentDate = $_POST['PaymentDate'];
    $PaymentMethod = $_POST['PaymentMethod'];
    $Description = $_POST['Description'];

    // Update the payment in the database
    $stmt = $connection->prepare("UPDATE payments SET UserID=?, Amount=?, PaymentDate=?, PaymentMethod=?, Description=? WHERE PaymentID=?");
    $stmt->bind_param("idsssi", $UserID, $Amount, $PaymentDate, $PaymentMethod, $Description, $PaymentID);
    
    if ($stmt->execute()) {
        // Redirect to payments.php after successful update
        header('Location: payments.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        echo "Error updating payment: " . $stmt->error;
    }
}

// Retrieve PaymentID from GET parameters
if(isset($_GET['PaymentID'])) {
    $PaymentID = $_GET['PaymentID'];
    
    // Prepare and execute SELECT statement to retrieve payment details
    $stmt = $connection->prepare("SELECT * FROM payments WHERE PaymentID = ?");
    $stmt->bind_param("i", $PaymentID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $UserID = $row['UserID'];
        $Amount = $row['Amount'];
        $PaymentDate = $row['PaymentDate'];
        $PaymentMethod = $row['PaymentMethod'];
        $Description = $row['Description'];
    } else {
        echo "Payment not found.";
    }
}
?>

<html>
<head>
    <title>Update Payments</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        .container {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .container input[type="number"],
        .container input[type="text"],
        .container input[type="date"],
        .container textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .container textarea {
            height: 100px;
        }
        .container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px 20px;
            border-radius: 4px;
        }
        .container input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="POST" onsubmit="return confirmUpdate();">
            <label for="PaymentID">PaymentID:</label>
            <input type="number" name="PaymentID" value="<?php echo $PaymentID; ?>" readonly>
            <label for="UserID">User ID:</label>
            <input type="number" name="UserID" value="<?php echo $UserID; ?>">
            <label for="Amount">Amount:</label>
            <input type="number" name="Amount" value="<?php echo $Amount; ?>">
            <label for="PaymentDate">Payment Date:</label>
            <input type="date" name="PaymentDate" value="<?php echo $PaymentDate; ?>">
            <label for="PaymentMethod">Payment Method:</label>
            <input type="text" name="PaymentMethod" value="<?php echo $PaymentMethod; ?>">
            <label for="Description">Description:</label>
            <textarea name="Description"><?php echo $Description; ?></textarea>
            <input type="submit" name="update" value="Update">
        </form>
    </div>
</body>
</html>

<script>
    function confirmUpdate() {
        return confirm('Are you sure you want to update this record?');
    }
</script>
