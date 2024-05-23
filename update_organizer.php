<?php
// Connection details
  include('dbconnection.php'); // Include your database connection file

// Initialize variables to avoid PHP notices
$OrganizerID = $UserID = $OrganizerName = $OrganizerEmail = $OrganizerPhone = $OrganizerBio = "";

// Check if Organizer ID is set
if(isset($_POST['OrganizerID'])) {
    $OrganizerID = $_POST['OrganizerID'];
    $UserID = $_POST['UserID'];
    $OrganizerName = $_POST['OrganizerName'];
    $OrganizerEmail = $_POST['OrganizerEmail'];
    $OrganizerPhone = $_POST['OrganizerPhone'];
    $OrganizerBio = $_POST['OrganizerBio'];

    // Update the organizer in the database
    $stmt = $connection->prepare("UPDATE organizer SET UserID=?, OrganizerName=?, OrganizerEmail=?, OrganizerPhone=?, OrganizerBio=? WHERE OrganizerID=?");
    $stmt->bind_param("issssi", $UserID, $OrganizerName, $OrganizerEmail, $OrganizerPhone, $OrganizerBio, $OrganizerID);
    
    if ($stmt->execute()) {
        // Redirect to organizers.php after successful update
        header('Location: organizers.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        echo "Error updating organizer: " . $stmt->error;
    }
}

// Check if Organizer ID is set
if(isset($_GET['OrganizerID'])) {
    $OrganizerID = $_GET['OrganizerID'];
    
    // Prepare and execute SELECT statement to retrieve organizer details
    $stmt = $connection->prepare("SELECT * FROM organizer WHERE OrganizerID = ?");
    $stmt->bind_param("i", $OrganizerID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $UserID = $row['UserID'];
        $OrganizerName = $row['OrganizerName'];
        $OrganizerEmail = $row['OrganizerEmail'];
        $OrganizerPhone = $row['OrganizerPhone'];
        $OrganizerBio = $row['OrganizerBio'];
    } else {
        echo "Organizer not found.";
    }
}
?>

<html>
<head>
    <title>Update Organizer</title>
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
        input[type="email"],
        input[type="tel"],
        textarea,
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
        <input type="hidden" name="OrganizerID" value="<?php echo $OrganizerID; ?>">
        <label for="UserID">User ID:</label>
        <input type="number" name="UserID" value="<?php echo $UserID; ?>">
        <label for="OrganizerName">Organizer Name:</label>
        <input type="text" name="OrganizerName" value="<?php echo $OrganizerName; ?>">
        <label for="OrganizerEmail">Organizer Email:</label>
        <input type="email" name="OrganizerEmail" value="<?php echo $OrganizerEmail; ?>">
        <label for="OrganizerPhone">Organizer Phone:</label>
        <input type="tel" name="OrganizerPhone" value="<?php echo $OrganizerPhone; ?>">
        <label for="OrganizerBio">Organizer Bio:</label>
        <textarea name="OrganizerBio"><?php echo $OrganizerBio; ?></textarea>
        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>

<script>
    function confirmUpdate() {
        return confirm('Are you sure you want to update this record?');
    }
</script>
