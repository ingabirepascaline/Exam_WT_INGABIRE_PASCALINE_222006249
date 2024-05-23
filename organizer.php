<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizer Form</title>
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
    <h1><u>Organizer Form</u></h1>

    <form method="post" action="organizer.php" onsubmit="return confirmInsert();">
        <label for="OrganizerID">OrganizerID:</label>
        <input type="number" id="OrganizerID" name="OrganizerID"><br>
        <label for="UserID">UserID:</label>
        <input type="number" id="UserID" name="UserID"><br>
        <label for="OrganizerName">Organizer Name:</label>
        <input type="text" id="OrganizerName" name="OrganizerName" required><br>
        <label for="OrganizerEmail">Organizer Email:</label>
        <input type="email" id="OrganizerEmail" name="OrganizerEmail" required><br>
        <label for="OrganizerPhone">Organizer Phone:</label>
        <input type="tel" id="OrganizerPhone" name="OrganizerPhone" required><br>
        <label for="OrganizerBio">Organizer Bio:</label>
        <textarea id="OrganizerBio" name="OrganizerBio" required></textarea><br>
        <input type="submit" name="add" value="Insert">
    </form>

    <?php
    include('dbconnection.php'); // Include your database connection file

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind parameters for organizer insertion
        $stmt = $connection->prepare("INSERT INTO organizer (OrganizerID, UserID, OrganizerName, OrganizerEmail, OrganizerPhone, OrganizerBio) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissss", $OrganizerID, $UserID, $OrganizerName, $OrganizerEmail, $OrganizerPhone, $OrganizerBio);

        // Set parameters from form data
        $OrganizerID = $_POST['OrganizerID'];
        $UserID = $_POST['UserID'];
        $OrganizerName = $_POST['OrganizerName'];
        $OrganizerEmail = $_POST['OrganizerEmail'];
        $OrganizerPhone = $_POST['OrganizerPhone'];
        $OrganizerBio = $_POST['OrganizerBio'];

        // Execute the statement
        if ($stmt->execute() === TRUE) {
            echo "New record has been added successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    $sql = "SELECT * FROM organizer";
    $result = $connection->query($sql);
    ?>

    <h2>Table of Organizers</h2>
    <table>
        <tr>
            <th>OrganizerID</th>
            <th>UserID</th>
            <th>Organizer Name</th>
            <th>Organizer Email</th>
            <th>Organizer Phone</th>
            <th>Organizer Bio</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        // Output data from the organizer table
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $OrganizerID = $row['OrganizerID'];
                echo "<tr>
                    <td>" . $row['OrganizerID'] . "</td>
                    <td>" . $row['UserID'] . "</td>
                    <td>" . $row['OrganizerName'] . "</td>
                    <td>" . $row['OrganizerEmail'] . "</td>
                    <td>" . $row['OrganizerPhone'] . "</td>
                    <td>" . $row['OrganizerBio'] . "</td>
                    <td><a href='delete_organizer.php?OrganizerID=$OrganizerID'>Delete</a></td>
                    <td><a href='update_organizer.php?OrganizerID=$OrganizerID'>Update</a></td>
                </tr>";
            }
        } else {
            
 echo "<tr><td colspan='8'>No data found</td></tr>";
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