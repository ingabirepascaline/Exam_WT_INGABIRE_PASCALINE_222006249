<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Languages Form</title>
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
            background-color: skyblue;
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
    <h1><u>Languages Form</u></h1>

    <form method="post" action="languages.php" onsubmit="return confirmInsert();">
        <label for="LanguageID">Language ID:</label>
        <input type="number" id="LanguageID" name="LanguageID"><br>
        <label for="LanguageName">Language Name:</label>
        <input type="text" id="LanguageName" name="LanguageName" required><br>
        <input type="submit" name="add" value="Insert">
    </form>

    <?php
    include('dbconnection.php'); // Include your database connection file

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind parameters for language insertion
        $stmt = $connection->prepare("INSERT INTO languages (LanguageID, LanguageName) VALUES (?, ?)");
        $stmt->bind_param("is", $LanguageID, $LanguageName);

        // Set parameters from form data
        $LanguageID = $_POST['LanguageID'];
        $LanguageName = $_POST['LanguageName'];

        // Execute the statement
        if ($stmt->execute() === TRUE) {
            echo "New record has been added successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    $sql = "SELECT * FROM languages";
    $result = $connection->query($sql);
    ?>

    <h2>Table of Languages</h2>
    <table>
        <tr>
            <th>Language ID</th>
            <th>Language Name</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        // Output data from the languages table
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $LanguageID = $row['LanguageID'];
                echo "<tr>
                    <td>" . $row['LanguageID'] . "</td>
                    <td>" . $row['LanguageName'] . "</td>
                    <td><a href='delete_languages.php?LanguageID=$LanguageID'>Delete</a></td>
                    <td><a href='update_languages.php?LanguageID=$LanguageID'>Update</a></td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No data found</td></tr>";
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
