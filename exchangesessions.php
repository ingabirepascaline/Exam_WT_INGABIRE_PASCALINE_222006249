<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exchange Sessions Form</title>
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
    <h1><u>Exchange Sessions Form</u></h1>

    <form method="post" action="exchangesessions.php" onsubmit="return confirmInsert();">
        <label for="SessionID">SessionID:</label>
        <input type="number" id="SessionID" name="SessionID"><br>
        <label for="OrganizerID">OrganizerID:</label>
        <input type="number" id="OrganizerID" name="OrganizerID"><br>
        <label for="LanguageID">LanguageID:</label>
        <input type="number" id="LanguageID" name="LanguageID"><br>
        <label for="DateScheduled">Date Scheduled:</label>
        <input type="date" id="DateScheduled" name="DateScheduled" required><br>
        <label for="StartTime">Start Time:</label>
        <input type="time" id="StartTime" name="StartTime" required><br>
        <label for="EndTime">End Time:</label>
        <input type="time" id="EndTime" name="EndTime" required><br>
        <label for="Location">Location:</label>
        <input type="text" id="Location" name="Location" required><br>
        <label for="Description">Description:</label>
        <input type="text" id="Description" name="Description" required><br>
        <input type="submit" name="add" value="Insert">
    </form>

    <?php
    include('dbconnection.php'); // Include your database connection file

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind parameters for session insertion
        $stmt = $connection->prepare("INSERT INTO exchangesessions (SessionID, OrganizerID, LanguageID, DateScheduled, StartTime, EndTime, Location, Description) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiisssss", $SessionID, $OrganizerID, $LanguageID, $DateScheduled, $StartTime, $EndTime, $Location, $Description);

        // Set parameters from form data
        $SessionID = $_POST['SessionID'];
        $OrganizerID = $_POST['OrganizerID'];
        $LanguageID = $_POST['LanguageID'];
        $DateScheduled = $_POST['DateScheduled'];
        $StartTime = $_POST['StartTime'];
        $EndTime = $_POST['EndTime'];
        $Location = $_POST['Location'];
        $Description = $_POST['Description'];

        // Execute the statement
        if ($stmt->execute() === TRUE) {
            echo "New record has been added successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    $sql = "SELECT * FROM exchangesessions";
    $result = $connection->query($sql);
    ?>

    <h2>Table of Exchange Sessions</h2>
    <table>
        <tr>
            <th>SessionID</th>
            <th>OrganizerID</th>
            <th>LanguageID</th>
            <th>Date Scheduled</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Location</th>
            <th>Description</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        // Output data from the exchangesessions table
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $SessionID = $row['SessionID'];
                echo "<tr>
                    <td>" . $row['SessionID'] . "</td>
                    <td>" . $row['OrganizerID'] . "</td>
                    <td>" . $row['LanguageID'] . "</td>
                    <td>" . $row['DateScheduled'] . "</td>
                    <td>" . $row['StartTime'] . "</td>
                    <td>" . $row['EndTime'] . "</td>
                    <td>" . $row['Location'] . "</td>
                    <td>" . $row['Description'] . "</td>
                    <td><a href='delete_exchangesessions.php?SessionID=$SessionID'>Delete</a></td>
                    <td><a href='update_exchangesessions.php?SessionID=$SessionID'>Update</a></td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='10'>No data found</td></tr>";
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
