<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
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
            background-color: pink;
        }
    </style>
</head>
<body>
<header>
<section>
    <h1><u>Reviewers Form</u></h1>

    <form method="post" onsubmit="return confirmInsert();">
        <label for="ReviewerID">ReviewerID:</label>
        <input type="number" id="ReviewerID" name="ReviewerID"><br>
        <label for="UserID">UserID:</label>
        <input type="number" id="UserID" name="UserID"><br>
        <label for="ReviewDate">Review Date:</label>
        <input type="date" id="ReviewDate" name="ReviewDate" required><br>
        <label for="Rating">Rating:</label>
        <input type="number" id="Rating" name="Rating" min="1" max="5" required><br>
        <label for="ReviewText">Review Text:</label>
        <input type="text" id="ReviewText" name="ReviewText" required><br>
        <input type="submit" name="add" value="Insert">
    </form>

    <?php
    include('dbconnection.php'); // Include your database connection file

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind parameters for reviewer insertion
        $stmt = $connection->prepare("INSERT INTO reviewers (ReviewerID, UserID, ReviewDate, Rating, ReviewText) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisss", $ReviewerID, $UserID, $ReviewDate, $Rating, $ReviewText);

        // Set parameters from form data
        $ReviewerID= $_POST['ReviewerID'];
        $UserID= $_POST['UserID'];
        $ReviewDate= $_POST['ReviewDate'];
        $Rating= $_POST['Rating'];
        $ReviewText = $_POST['ReviewText'];

        // Execute the statement
        if ($stmt->execute() === TRUE) {
            echo "New record has been added successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    $sql = "SELECT * FROM reviewers";
    $result = $connection->query($sql);
    ?>


</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviewers Form</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        /* CSS styles */
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
            background-color: blue;
        }
        footer {
            background-color: green;
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
    

   


    <h2>Table of Reviewers</h2>
    <table>
        <tr>
            <th>ReviewerID</th>
            <th>UserID</th>
            <th>Review Date</th>
            <th>Rating</th>
            <th>Review Text</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        // Output data from the reviewers table
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $ReviewerID = $row['ReviewerID'];
                echo "<tr>
                    <td>" . $row['ReviewerID'] . "</td>
                    <td>" . $row['UserID'] . "</td>
                    <td>" . $row['ReviewDate'] . "</td>
                    <td>" . $row['Rating'] . "</td>
                    <td>" . $row['ReviewText'] . "</td>
                    <td><a href='delete_reviewers.php?ReviewerID=$ReviewerID'>Delete</a></td>
                    <td><a href='update_reviewers.php?ReviewerID=$ReviewerID'>Update</a></td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No data found</td></tr>";
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
