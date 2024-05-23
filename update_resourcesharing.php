<?php
// Connection details
  include('dbconnection.php'); // Include your database connection file

// Initialize variables to avoid PHP notices
$ResourceID = $UserID = $Title = $Description = $ResourceContent = $DateShared = "";

// Check if ResourceID is set
if(isset($_POST['ResourceID'])) {
    $ResourceID = $_POST['ResourceID'];
    $UserID = $_POST['UserID'];
    $Title = $_POST['Title'];
    $Description = $_POST['Description'];
    $ResourceContent = $_POST['ResourceContent'];
    $DateShared = $_POST['DateShared'];

    // Update the resource in the database
    $stmt = $connection->prepare("UPDATE resourcesharing SET UserID=?, Title=?, Description=?, ResourceContent=?, DateShared=? WHERE ResourceID=?");
    $stmt->bind_param("issssi", $UserID, $Title, $Description, $ResourceContent, $DateShared, $ResourceID);
    
    if ($stmt->execute()) {
        // Redirect to resourcesharing.php after successful update
        header('Location: resourcesharing.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        echo "Error updating resource: " . $stmt->error;
    }
}

// Retrieve ResourceID from GET parameters
if(isset($_GET['ResourceID'])) {
    $ResourceID = $_GET['ResourceID'];
    
    // Prepare and execute SELECT statement to retrieve resource details
    $stmt = $connection->prepare("SELECT * FROM resourcesharing WHERE ResourceID = ?");
    $stmt->bind_param("i", $ResourceID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $UserID = $row['UserID'];
        $Title = $row['Title'];
        $Description = $row['Description'];
        $ResourceContent = $row['ResourceContent'];
        $DateShared = $row['DateShared'];
    } else {
        echo "Resource not found.";
    }
}
?>

<html>
<head>
    <title>Update Resource Sharing</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        form {
            max-width: 500px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="number"],
        input[type="text"],
        input[type="date"],
        textarea {
            width: calc(100% - 16px);
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        textarea {
            height: 100px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px 20px;
            border-radius: 4px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="ResourceID">ResourceID:</label>
        <input type="number" name="ResourceID" value="<?php echo $ResourceID; ?>" readonly>
        <label for="UserID">User ID:</label>
        <input type="number" name="UserID" value="<?php echo $UserID; ?>">
        <label for="Title">Title:</label>
        <input type="text" name="Title" value="<?php echo $Title; ?>">
        <label for="Description">Description:</label>
        <textarea name="Description"><?php echo $Description; ?></textarea>
        <label for="ResourceContent">Resource Content:</label>
        <textarea name="ResourceContent"><?php echo $ResourceContent; ?></textarea>
        <label for="DateShared">Date Shared:</label>
        <input type="date" name="DateShared" value="<?php echo $DateShared; ?>">
        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>

<script>
    function confirmUpdate() {
        return confirm('Are you sure you want to update this record?');
    }
</script>
