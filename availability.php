<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Availability Form</title>
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
            color: green;
            text-decoration: none;
        }
    </style>
</head>
<body>
<header>
<section>
    <h1><u>Availability Form</u></h1>

    <form method="post" action="availability.php" onsubmit="return confirmInsert();">
        <label for="AvailabilityID">AvailabilityID:</label>
        <input type="number" id="AvailabilityID" name="AvailabilityID"><br>
        <label for="UserID">UserID:</label>
        <input type="number" id="UserID" name="UserID"><br>
        <label for="DayOfWeek">Day of Week:</label>
        <input type="text" id="DayOfWeek" name="DayOfWeek" required><br>
        <label for="StartTime">Start Time:</label>
        <input type="time" id="StartTime" name="StartTime" required><br>
        <label for="EndTime">End Time:</label>
        <input type="time" id="EndTime" name="EndTime" required><br>
        <input type="submit" name="add" value="Insert">
    </form>

    <?php
    include('dbconnection.php'); // Include your database connection file

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind parameters for availability insertion
        $stmt = $connection->prepare("INSERT INTO availability (AvailabilityID, UserID, DayOfWeek, StartTime, EndTime) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisss", $AvailabilityID, $UserID, $DayOfWeek, $StartTime, $EndTime);

        // Set parameters from form data
        $AvailabilityID = $_POST['AvailabilityID'];
        $UserID = $_POST['UserID'];
        $DayOfWeek = $_POST['DayOfWeek'];
        $StartTime = $_POST['StartTime'];
        $EndTime = $_POST['EndTime'];

        // Execute the statement
        if ($stmt->execute() === TRUE) {
            echo "New record has been added successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    $sql = "SELECT * FROM availability";
    $result = $connection->query($sql);
    ?>

    <h2>Table of Availability</h2>
    <table>
        <tr>
            <th>AvailabilityID</th>
            <th>UserID</th>
            <th>Day of Week</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        // Output data from the availability table
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $AvailabilityID = $row['AvailabilityID'];
                echo "<tr>
                    <td>" . $row['AvailabilityID'] . "</td>
                    <td>" . $row['UserID'] . "</td>
                    <td>" . $row['DayOfWeek'] . "</td>
                    <td>" . $row['StartTime'] . "</td>
                    <td>" . $row['EndTime'] . "</td>
                    <td><a href='delete_availability.php?AvailabilityID=$AvailabilityID'>Delete</a></td>
                    <td><a href='update_availability.php?AvailabilityID=$AvailabilityID'>Update</a></td>
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
