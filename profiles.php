<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profiles Form</title>
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
            background-color: green;
        }
        footer {
            background-color: blue;
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
    <h1><u>Profiles Form</u></h1>

    <form method="post" action="profiles.php" onsubmit="return confirmInsert();">
        <label for="ProfileID">ProfileID:</label>
        <input type="number" id="ProfileID" name="ProfileID"><br>
        <label for="UserID">UserID:</label>
        <input type="number" id="UserID" name="UserID"><br>
        <label for="FullName">Full Name:</label>
        <input type="text" id="FullName" name="FullName"><br>
        <label for="Age">Age:</label>
        <input type="number" id="Age" name="Age" min="0"><br>
        <label for="Gender">Gender:</label>
        <input type="text" id="Gender" name="Gender"><br>
        <label for="NativeLanguage">Native Language:</label>
        <input type="text" id="NativeLanguage" name="NativeLanguage"><br>
        <label for="LearningLanguage">Learning Language:</label>
        <input type="text" id="LearningLanguage" name="LearningLanguage"><br>
        <label for="DateJoined">Date Joined:</label>
        <input type="date" id="DateJoined" name="DateJoined" required><br>
        <input type="submit" name="add" value="Insert">
    </form>

    <?php
    include('dbconnection.php'); // Include your database connection file

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind parameters for profile insertion
        $stmt = $connection->prepare("INSERT INTO profiles (ProfileID, UserID, FullName, Age, Gender, NativeLanguage, LearningLanguage, DateJoined) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissssss", $ProfileID, $UserID, $FullName, $Age, $Gender, $NativeLanguage, $LearningLanguage, $DateJoined);

        // Set parameters from form data
        $ProfileID = $_POST['ProfileID'];
        $UserID = $_POST['UserID'];
        $FullName = $_POST['FullName'];
        $Age = $_POST['Age'];
        $Gender = $_POST['Gender'];
        $NativeLanguage = $_POST['NativeLanguage'];
        $LearningLanguage = $_POST['LearningLanguage'];
        $DateJoined = $_POST['DateJoined'];

        // Execute the statement
        if ($stmt->execute() === TRUE) {
            echo "New record has been added successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    $sql = "SELECT * FROM profiles";
    $result = $connection->query($sql);
    ?>

    <h2>Table of Profiles</h2>
    <table>
        <tr>
            <th>ProfileID</th>
            <th>UserID</th>
            <th>Full Name</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Native Language</th>
            <th>Learning Language</th>
            <th>Date Joined</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        // Output data from the profiles table
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $ProfileID = $row['ProfileID'];
                echo "<tr>
                    <td>" . $row['ProfileID'] . "</td>
                    <td>" . $row['UserID'] . "</td>
                    <td>" . $row['FullName'] . "</td>
                    <td>" . $row['Age'] . "</td>
                    <td>" . $row['Gender'] . "</td>
                    <td>" . $row['NativeLanguage'] . "</td>
                    <td>" . $row['LearningLanguage'] . "</td>
                    <td>" . $row['DateJoined'] . "</td>
                    <td><a href='delete_profiles.php?ProfileID=$ProfileID'>Delete</a></td>
                    <td><a href='update_profiles.php?ProfileID=$ProfileID'>Update</a></td>
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
