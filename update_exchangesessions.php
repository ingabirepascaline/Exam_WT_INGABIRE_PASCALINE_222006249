<?php
// Connection details
  include('dbconnection.php'); // Include your database connection file
// Initialize variables to avoid PHP notices
$SessionID = $OrganizerID = $LanguageID = $DateScheduled = $StartTime = $EndTime = $Location = $Description = "";

// Check if Session ID is set
if(isset($_POST['SessionID'])) {
    $SessionID = $_POST['SessionID'];
    $OrganizerID = $_POST['OrganizerID'];
    $LanguageID = $_POST['LanguageID'];
    $DateScheduled = $_POST['DateScheduled'];
    $StartTime = $_POST['StartTime'];
    $EndTime = $_POST['EndTime'];
    $Location = $_POST['Location'];
    $Description = $_POST['Description'];

    // Update the exchange session in the database
    $stmt = $connection->prepare("UPDATE exchangesessions SET OrganizerID=?, LanguageID=?, DateScheduled=?, StartTime=?, EndTime=?, Location=?, Description=? WHERE SessionID=?");
    $stmt->bind_param("iisssssi", $OrganizerID, $LanguageID, $DateScheduled, $StartTime, $EndTime, $Location, $Description, $SessionID);
    
    if ($stmt->execute()) {
        // Redirect to exchangesessions.php after successful update
        header('Location: exchangesessions.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        echo "Error updating exchange session: " . $stmt->error;
    }
}

// Check if Session ID is set
if(isset($_GET['SessionID'])) {
    $SessionID = $_GET['SessionID'];
    
    // Prepare and execute SELECT statement to retrieve session details
    $stmt = $connection->prepare("SELECT * FROM exchangesessions WHERE SessionID = ?");
    $stmt->bind_param("i", $SessionID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $OrganizerID = $row['OrganizerID'];
        $LanguageID = $row['LanguageID'];
        $DateScheduled = $row['DateScheduled'];
        $StartTime = $row['StartTime'];
        $EndTime = $row['EndTime'];
        $Location = $row['Location'];
        $Description = $row['Description'];
    } else {
        echo "Exchange session not found.";
    }
}
?>

<html>
<head>
    <title>Update Exchange Sessions</title>
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
        input[type="text"],
        input[type="date"],
        input[type="time"],
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
        <input type="hidden" name="SessionID" value="<?php echo $SessionID; ?>">
        <label for="OrganizerID">Organizer ID:</label>
        <input type="number" name="OrganizerID" value="<?php echo $OrganizerID; ?>">
        <label for="LanguageID">Language ID:</label>
        <input type="number" name="LanguageID" value="<?php echo $LanguageID; ?>">
        <label for="DateScheduled">Date Scheduled:</label>
        <input type="date" name="DateScheduled" value="<?php echo $DateScheduled; ?>">
        <label for="StartTime">Start Time:</label>
        <input type="time" name="StartTime" value="<?php echo $StartTime; ?>">
        <label for="EndTime">End Time:</label>
        <input type="time" name="EndTime" value="<?php echo $EndTime; ?>">
        <label for="Location">Location:</label>
        <input type="text" name="Location" value="<?php echo $Location; ?>">
        <label for="Description">Description:</label>
        <textarea name="Description"><?php echo $Description; ?></textarea>
        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>

<script>
    function confirmUpdate() {
        return confirm('Are you sure you want to update this record?');
    }
</script>
