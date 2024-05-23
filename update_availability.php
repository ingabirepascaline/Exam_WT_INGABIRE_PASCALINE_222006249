<?php
// Connection details
  include('dbconnection.php'); // Include your database connection file

// Initialize variables to avoid PHP notices
$AvailabilityID = $UserID = $DayOfWeek = $StartTime = $EndTime = "";

// Check if Availability ID is set
if(isset($_POST['AvailabilityID'])) {
    $AvailabilityID = $_POST['AvailabilityID'];
    $UserID = $_POST['UserID'];
    $DayOfWeek = $_POST['DayOfWeek'];
    $StartTime = $_POST['StartTime'];
    $EndTime = $_POST['EndTime'];

    // Update the availability in the database
    $stmt = $connection->prepare("UPDATE availability SET UserID=?, DayOfWeek=?, StartTime=?, EndTime=? WHERE AvailabilityID=?");
    $stmt->bind_param("isssi", $UserID, $DayOfWeek, $StartTime, $EndTime, $AvailabilityID);
    
    if ($stmt->execute()) {
        // Redirect to availability.php after successful update
        header('Location: availability.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        echo "Error updating availability: " . $stmt->error;
    }
}

// Check if Availability ID is set
if(isset($_GET['AvailabilityID'])) {
    $AvailabilityID = $_GET['AvailabilityID'];
    
    // Prepare and execute SELECT statement to retrieve availability details
    $stmt = $connection->prepare("SELECT * FROM availability WHERE AvailabilityID = ?");
    $stmt->bind_param("i", $AvailabilityID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $UserID = $row['UserID'];
        $DayOfWeek = $row['DayOfWeek'];
        $StartTime = $row['StartTime'];
        $EndTime = $row['EndTime'];
    } else {
        echo "Availability not found.";
    }
}
?>

<html>
<head>
    <title>Update Availability</title>
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
        input[type="time"],
        input[type="submit"],
        select,
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
        <input type="hidden" name="AvailabilityID" value="<?php echo $AvailabilityID; ?>">
        <label for="UserID">User ID:</label>
        <input type="number" name="UserID" value="<?php echo $UserID; ?>">
        <label for="DayOfWeek">Day of Week:</label>
        <select name="DayOfWeek">
            <option value="Monday" <?php if($DayOfWeek == "Monday") echo "selected"; ?>>Monday</option>
            <option value="Tuesday" <?php if($DayOfWeek == "Tuesday") echo "selected"; ?>>Tuesday</option>
            <option value="Wednesday" <?php if($DayOfWeek == "Wednesday") echo "selected"; ?>>Wednesday</option>
            <option value="Thursday" <?php if($DayOfWeek == "Thursday") echo "selected"; ?>>Thursday</option>
            <option value="Friday" <?php if($DayOfWeek == "Friday") echo "selected"; ?>>Friday</option>
            <option value="Saturday" <?php if($DayOfWeek == "Saturday") echo "selected"; ?>>Saturday</option>
            <option value="Sunday" <?php if($DayOfWeek == "Sunday") echo "selected"; ?>>Sunday</option>
        </select>
        <label for="StartTime">Start Time:</label>
        <input type="time" name="StartTime" value="<?php echo $StartTime; ?>">
        <label for="EndTime">End Time:</label>
        <input type="time" name="EndTime" value="<?php echo $EndTime; ?>">
        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>

<script>
    function confirmUpdate() {
        return confirm('Are you sure you want to update this record?');
    }
</script>
