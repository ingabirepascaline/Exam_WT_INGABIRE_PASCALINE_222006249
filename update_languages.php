<?php
// Connection details
  include('dbconnection.php'); // Include your database connection file

// Initialize variables to avoid PHP notices
$LanguageID = $LanguageName = "";

// Check if Language ID is set
if(isset($_POST['LanguageID'])) {
    $LanguageID = $_POST['LanguageID'];
    $LanguageName = $_POST['LanguageName'];

    // Update the language in the database
    $stmt = $connection->prepare("UPDATE languages SET LanguageName=? WHERE LanguageID=?");
    $stmt->bind_param("si", $LanguageName, $LanguageID);
    
    if ($stmt->execute()) {
        // Redirect to languages.php after successful update
        header('Location: languages.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        echo "Error updating language: " . $stmt->error;
    }
}

// Check if Language ID is set
if(isset($_GET['LanguageID'])) {
    $LanguageID = $_GET['LanguageID'];
    
    // Prepare and execute SELECT statement to retrieve language details
    $stmt = $connection->prepare("SELECT * FROM languages WHERE LanguageID = ?");
    $stmt->bind_param("i", $LanguageID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $LanguageName = $row['LanguageName'];
    } else {
        echo "Language not found.";
    }
}
?>

<html>
<head>
    <title>Update Languages</title>
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
        <input type="hidden" name="LanguageID" value="<?php echo $LanguageID; ?>">
        <label for="LanguageName">Language Name:</label>
        <input type="text" name="LanguageName" value="<?php echo $LanguageName; ?>">
        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>

<script>
    function confirmUpdate() {
        return confirm('Are you sure you want to update this record?');
    }
</script>
