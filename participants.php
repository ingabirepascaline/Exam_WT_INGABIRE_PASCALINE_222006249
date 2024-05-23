<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participants Form</title>
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
            background-color: pink;
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
            color: blue;
            text-decoration: none;
        }
    </style>
</head>
<body>
<header>
<section>
    <h1><u>Participants Form</u></h1>

    <form method="post" action="participants.php" onsubmit="return confirmInsert();">
        <label for="ParticipantID">ParticipantID:</label>
        <input type="number" id="ParticipantID" name="ParticipantID"><br>
        <label for="SessionID">SessionID:</label>
        <input type="number" id="SessionID" name="SessionID"><br>
        <label for="UserID">UserID:</label>
        <input type="number" id="UserID" name="UserID"><br>
        <input type="submit" name="add" value="Insert">
    </form>

    <?php
    include('dbconnection.php'); // Include your database connection file

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind parameters for participant insertion
        $stmt = $connection->prepare("INSERT INTO participants (ParticipantID, SessionID, UserID) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $ParticipantID, $SessionID, $UserID);

        // Set parameters from form data
        $ParticipantID= $_POST['ParticipantID'];
        $SessionID= $_POST['SessionID'];
        $UserID= $_POST['UserID'];

        // Execute the statement
        if ($stmt->execute() === TRUE) {
            echo "New record has been added successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    $sql = "SELECT * FROM participants";
    $result = $connection->query($sql);
    ?>

    <h2>Table of Participants</h2>
    <table>
        <tr>
            <th>ParticipantID</th>
            <th>SessionID</th>
            <th>UserID</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        // Output data from the participants table
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $ParticipantID = $row['ParticipantID'];
                echo "<tr>
                    <td>" . $row['ParticipantID'] . "</td>
                    <td>" . $row['SessionID'] . "</td>
                    <td>" . $row['UserID'] . "</td>
                    <td><a href='delete_participants.php?ParticipantID=$ParticipantID'>Delete</a></td>
                    <td><a href='update_participants.php?ParticipantID=$ParticipantID'>Update</a></td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No data found</td></tr>";
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
