<?php
// Connection details
  include('dbconnection.php'); // Include your database connection file

// Initialize variables to avoid PHP notices
$ParticipantID = $SessionID = $UserID = "";

// Check if Participant ID is set
if(isset($_POST['ParticipantID'])) {
    $ParticipantID = $_POST['ParticipantID'];
    $SessionID = $_POST['SessionID'];
    $UserID = $_POST['UserID'];

    // Update the participant in the database
    $stmt = $connection->prepare("UPDATE participants SET SessionID=?, UserID=? WHERE ParticipantID=?");
    $stmt->bind_param("iii", $SessionID, $UserID, $ParticipantID);
    
    if ($stmt->execute()) {
        // Redirect to participants.php after successful update
        header('Location: participants.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        echo "Error updating participant: " . $stmt->error;
    }
}

// Check if Participant ID is set
if(isset($_GET['ParticipantID'])) {
    $ParticipantID = $_GET['ParticipantID'];
    
    // Prepare and execute SELECT statement to retrieve participant details
    $stmt = $connection->prepare("SELECT * FROM participants WHERE ParticipantID = ?");
    $stmt->bind_param("i", $ParticipantID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $SessionID = $row['SessionID'];
        $UserID = $row['UserID'];
    } else {
        echo "Participant not found.";
    }
}
?>

<html>
<head>
    <title>Update Participants</title>
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
        input[type="submit"] {
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
        <input type="hidden" name="ParticipantID" value="<?php echo $ParticipantID; ?>">
        <label for="SessionID">Session ID:</label>
        <input type="number" name="SessionID" value="<?php echo $SessionID; ?>">
        <label for="UserID">User ID:</label>
        <input type="number" name="UserID" value="<?php echo $UserID; ?>">
        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>

<script>
    function confirmUpdate() {
        return confirm('Are you sure you want to update this record?');
    }
</script>
