<?php
// Connection details
  include('dbconnection.php'); // Include your database connection file

// Initialize variables to avoid PHP notices
$ReviewerID = $UserID = $ReviewDate = $Rating = $ReviewText = "";

// Check if Reviewer ID is set
if(isset($_POST['ReviewerID'])) {
    $ReviewerID = $_POST['ReviewerID'];
    $UserID = $_POST['UserID'];
    $ReviewDate = $_POST['ReviewDate'];
    $Rating = $_POST['Rating'];
    $ReviewText = $_POST['ReviewText'];

    // Update the review in the database
    $stmt = $connection->prepare("UPDATE reviewers SET UserID=?, ReviewDate=?, Rating=?, ReviewText=? WHERE ReviewerID=?");
    $stmt->bind_param("isssi", $UserID, $ReviewDate, $Rating, $ReviewText, $ReviewerID);
    
    if ($stmt->execute()) {
        // Redirect to reviewers.php after successful update
        header('Location: reviewers.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        echo "Error updating reviewer: " . $stmt->error;
    }
}

// Check if Reviewer ID is set
if(isset($_GET['ReviewerID'])) {
    $ReviewerID = $_GET['ReviewerID'];
    
    // Prepare and execute SELECT statement to retrieve review details
    $stmt = $connection->prepare("SELECT * FROM reviewers WHERE ReviewerID = ?");
    $stmt->bind_param("i", $ReviewerID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $UserID = $row['UserID'];
        $ReviewDate = $row['ReviewDate'];
        $Rating = $row['Rating'];
        $ReviewText = $row['ReviewText'];
    } else {
        echo "Review not found.";
    }
}

?>

<html>
<head>
    <title>Update Reviewers</title>
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
        <input type="hidden" name="ReviewerID" value="<?php echo $ReviewerID; ?>">
        <label for="UserID">User ID:</label>
        <input type="number" name="UserID" value="<?php echo $UserID; ?>">
        <label for="ReviewDate">Review Date:</label>
        <input type="date" name="ReviewDate" value="<?php echo $ReviewDate; ?>">
        <label for="Rating">Rating:</label>
        <input type="number" name="Rating" value="<?php echo $Rating; ?>">
        <label for="ReviewText">Review Text:</label>
        <textarea name="ReviewText"><?php echo $ReviewText; ?></textarea>
        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>

<script>
    function confirmUpdate() {
        return confirm('Are you sure you want to update this record?');
    }
</script>
