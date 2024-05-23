<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        /* Add CSS for table styling */
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: yellow;
        }
        footer {
            background-color: teal;
            text-align: center;
            width: 100%;
            color: white;
            font-size: 25px;
            position: fixed;
            bottom: 0;
            padding: 10px 0;
        }
        button a {
            color: red;
            text-decoration: none;
        }
    </style>
</head>
<body>
<header>
<section>
    <h1><u>Feedback Form</u></h1>

    <form method="post" action="feedback.php" onsubmit="return confirmInsert();">
        <label for="FeedbackID">FeedbackID:</label>
        <input type="number" id="FeedbackID" name="FeedbackID"><br>
        <label for="UserID">UserID:</label>
        <input type="number" id="UserID" name="UserID"><br>
        <label for="FeedbackText">Feedback Text:</label>
        <input type="text" id="FeedbackText" name="FeedbackText" required><br>
        <label for="FeedbackTime">Feedback Time:</label>
        <input type="datetime-local" id="FeedbackTime" name="FeedbackTime" required><br>
        <input type="submit" name="add" value="Insert">
    </form>

    <?php
    include('dbconnection.php'); // Include your database connection file

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind parameters for feedback insertion
        $stmt = $connection->prepare("INSERT INTO feedback (FeedbackID, UserID, FeedbackText, FeedbackTime) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $FeedbackID, $UserID, $FeedbackText, $FeedbackTime);

        // Set parameters from form data
        $FeedbackID = $_POST['FeedbackID'];
        $UserID = $_POST['UserID'];
        $FeedbackText = $_POST['FeedbackText'];
        $FeedbackTime = $_POST['FeedbackTime'];

        // Execute the statement
        if ($stmt->execute() === TRUE) {
            echo "New record has been added successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    $sql = "SELECT * FROM feedback";
    $result = $connection->query($sql);
    ?>

    <h2>Table of Feedback</h2>
    <table>
        <tr>
            <th>FeedbackID</th>
            <th>UserID</th>
            <th>Feedback Text</th>
            <th>Feedback Time</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        // Output data from the feedback table
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $FeedbackID = $row['FeedbackID'];
                echo "<tr>
                    <td>" . $row['FeedbackID'] . "</td>
                    <td>" . $row['UserID'] . "</td>
                    <td>" . $row['FeedbackText'] . "</td>
                    <td>" . $row['FeedbackTime'] . "</td>
                    <td><a href='delete_feedback.php?FeedbackID=$FeedbackID'>Delete</a></td>
                    <td><a href='update_feedback.php?FeedbackID=$FeedbackID'>Update</a></td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No data found</td></tr>";
        }
        // Close the database connection
        $connection->close();
        ?>
    </table>
    <center><button><a href="home.html">Back Home</a></button></center>
</section>
</header>
<footer>
    <b>UR CBE BIT &copy; 2024 &reg;, Designed by: @ingabire pascaline</b>
</footer>
</body>
</html>
