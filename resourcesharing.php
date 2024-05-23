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
            background-color: green;
        }
    </style>
</head>
<body>
<header>
<section>
    <h1><u>Resource Sharing Form</u></h1>

    <form method="post" action="resourcesharing.php" onsubmit="return confirmInsert();">
        <label for="ResourceID">ResourceID:</label>
        <input type="number" id="ResourceID" name="ResourceID"><br>
        <label for="UserID">UserID:</label>
        <input type="number" id="UserID" name="UserID"><br>
        <label for="Title">Title:</label>
        <input type="text" id="Title" name="Title"><br>
        <label for="Description">Description:</label>
        <input type="text" id="Description" name="Description"><br>
        
        <label for="ResourceContent">Resource Content:</label>
        <input type="text" id="ResourceContent" name="ResourceContent"><br>
        <label for="DateShared">Date Shared:</label>
        <input type="date" id="DateShared" name="DateShared" required><br>
        <input type="submit" name="add" value="Insert">
    </form>

    <?php
    include('dbconnection.php'); // Include your database connection file

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind parameters for resource sharing insertion
        $stmt = $connection->prepare("INSERT INTO resourcesharing(ResourceID, UserID, Title, Description, ResourceContent, DateShared) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissss", $ResourceID, $UserID, $Title, $Description, $ResourceContent, $DateShared);

        // Set parameters from form data
        $ResourceID = $_POST['ResourceID'];
        $UserID = $_POST['UserID'];
        $Title = $_POST['Title'];
        $Description = $_POST['Description'];
        $ResourceContent = $_POST['ResourceContent'];
        $DateShared = $_POST['DateShared'];

        // Execute the statement
        if ($stmt->execute() === TRUE) {
            echo "New record has been added successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    $sql = "SELECT * FROM resourcesharing";
    $result = $connection->query($sql);
    ?>

    <h2>Table of Resources Shared</h2>
    <table>
        <tr>
            <th>ResourceID</th>
            <th>UserID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Resource Content</th>
            <th>Date Shared</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        // Output data from the resourcesharing table
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $ResourceID = $row['ResourceID'];
                echo "<tr>
                    <td>" . $row['ResourceID'] . "</td>
                    <td>" . $row['UserID'] . "</td>
                    <td>" . $row['Title'] . "</td>
                    <td>" . $row['Description'] . "</td>
                    <td>" . $row['ResourceContent'] . "</td>
                    <td>" . $row['DateShared'] . "</td>
                    <td><a href='delete_resourcesharing.php?ResourceID=$ResourceID'>Delete</a></td>
                    <td><a href='update_resourcesharing.php?ResourceID=$ResourceID'>Update</a></td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No data found</td></tr>";
        }
        // Close the database connection
        $connection->close();
        ?>
    </table>
    <center><button style="background-color: red; width: 150px;height: 40px;" ><a href="home.html" style=" font-size: 15px;color: white;text-decoration: none;margin-top: 400px;" >Back Home</a></button></center>
</section>

<footer style="background-color:blue;text-align: center;width:100%;height:auto; color: white;font-size: 25px; bottom: 0;position: fixed;">
    <b><h2>UR CBE BIT &copy; 2024 &reg;, Designed by: @ingabire pascaline</h2></b>
</footer>

</body>
</html>
