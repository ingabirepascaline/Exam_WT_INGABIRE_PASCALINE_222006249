<?php
// Connection details
  include('dbconnection.php'); // Include your database connection file

// Initialize variables to avoid PHP notices
$FeedbackID = $UserID = $FeedbackText = $FeedbackTime = "";

// Check if Feedback ID is set
if(isset($_POST['FeedbackID'])) {
    $FeedbackID = $_POST['FeedbackID'];
    $UserID = $_POST['UserID'];
    $FeedbackText = $_POST['FeedbackText'];
    $FeedbackTime = $_POST['FeedbackTime'];

    // Update the feedback in the database
    $stmt = $connection->prepare("UPDATE feedback SET UserID=?, FeedbackText=?, FeedbackTime=? WHERE FeedbackID=?");
    $stmt->bind_param("issi", $UserID, $FeedbackText, $FeedbackTime, $FeedbackID);
    
    if ($stmt->execute()) {
        // Redirect to feedback.php after successful update
        header('Location: feedback.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        echo "Error updating feedback: " . $stmt->error;
    }
}

// Check if Feedback ID is set
if(isset($_GET['FeedbackID'])) {
    $FeedbackID = $_GET['FeedbackID'];
    
    // Prepare and execute SELECT statement to retrieve feedback details
    $stmt = $connection->prepare("SELECT * FROM feedback WHERE FeedbackID = ?");
    $stmt->bind_param("i", $FeedbackID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $UserID = $row['UserID'];
        $FeedbackText = $row['FeedbackText'];
        $FeedbackTime = $row['FeedbackTime'];
    } else {
        echo "Feedback not found.";
    }
}
?>

<html>
<head>
    <title>Update Feedback</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        form {
            max-width: 500px;
            margin: 0 auto;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="number"],
        input[type="date"],
        input[type="submit"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <form method="POST" onsubmit="return confirmUpdate();">
        <input type="hidden" name="FeedbackID" value="<?php echo $FeedbackID; ?>">
        <label for="UserID">User ID:</label>
        <input type="number" name="UserID" value="<?php echo $UserID; ?>">
        <label for="FeedbackText">Feedback Text:</label>
        <textarea name="FeedbackText"><?php echo $FeedbackText; ?></textarea>
        <label for="FeedbackTime">Feedback Time:</label>
        <input type="datetime-local" name="FeedbackTime" value="<?php echo date('Y-m-d\TH:i', strtotime($FeedbackTime)); ?>">
        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>

<script>
    function confirmUpdate() {
        return confirm('Are you sure you want to update this record?');
    }
</script>
