<?php
// Connection details
  include('dbconnection.php'); // Include your database connection file

// Initialize variables to avoid PHP notices
$ProfileID = $UserID = $FullName = $Age = $Gender = $NativeLanguage = $LearningLanguage = $DateJoined = "";

// Check if Profile ID is set
if(isset($_POST['ProfileID'])) {
    $ProfileID = $_POST['ProfileID'];
    $UserID = $_POST['UserID'];
    $FullName = $_POST['FullName'];
    $Age = $_POST['Age'];
    $Gender = $_POST['Gender'];
    $NativeLanguage = $_POST['NativeLanguage'];
    $LearningLanguage = $_POST['LearningLanguage'];
    $DateJoined = $_POST['DateJoined'];

    // Update the profile in the database
    $stmt = $connection->prepare("UPDATE profiles SET UserID=?, FullName=?, Age=?, Gender=?, NativeLanguage=?, LearningLanguage=?, DateJoined=? WHERE ProfileID=?");
    $stmt->bind_param("ississsi", $UserID, $FullName, $Age, $Gender, $NativeLanguage, $LearningLanguage, $DateJoined, $ProfileID);
    
    if ($stmt->execute()) {
        // Redirect to profiles.php after successful update
        header('Location: profiles.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        echo "Error updating profile: " . $stmt->error;
    }
}

// Check if Profile ID is set
if(isset($_GET['ProfileID'])) {
    $ProfileID = $_GET['ProfileID'];
    
    // Prepare and execute SELECT statement to retrieve profile details
    $stmt = $connection->prepare("SELECT * FROM profiles WHERE ProfileID = ?");
    $stmt->bind_param("i", $ProfileID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $UserID = $row['UserID'];
        $FullName = $row['FullName'];
        $Age = $row['Age'];
        $Gender = $row['Gender'];
        $NativeLanguage = $row['NativeLanguage'];
        $LearningLanguage = $row['LearningLanguage'];
        $DateJoined = $row['DateJoined'];
    } else {
        echo "Profile not found.";
    }
}
?>

<html>
<head>
    <title>Update Profiles</title>
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
        <input type="hidden" name="ProfileID" value="<?php echo $ProfileID; ?>">
        <label for="UserID">User ID:</label>
        <input type="number" name="UserID" value="<?php echo $UserID; ?>">
        <label for="FullName">Full Name:</label>
        <input type="text" name="FullName" value="<?php echo $FullName; ?>">
        <label for="Age">Age:</label>
        <input type="number" name="Age" value="<?php echo $Age; ?>">
        <label for="Gender">Gender:</label>
        <select name="Gender">
            <option value="Male" <?php if($Gender == "Male") echo "selected"; ?>>Male</option>
            <option value="Female" <?php if($Gender == "Female") echo "selected"; ?>>Female</option>
            <option value="Other" <?php if($Gender == "Other") echo "selected"; ?>>Other</option>
        </select>
        <label for="NativeLanguage">Native Language:</label>
        <input type="text" name="NativeLanguage" value="<?php echo $NativeLanguage; ?>">
        <label for="LearningLanguage">Learning Language:</label>
        <input type="text" name="LearningLanguage" value="<?php echo $LearningLanguage; ?>">
        <label for="DateJoined">Date Joined:</label>
        <input type="date" name="DateJoined" value="<?php echo $DateJoined; ?>">
        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>

<script>
    function confirmUpdate() {
        return confirm('Are you sure you want to update this record?');
    }
</script>
