<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments Form</title>
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
            background-color: skyblue;
        }
        footer {
            background-color: yellow;
            text-align: center;
            width: 100%;
            color: teal;
            font-size: 25px;
            position: fixed;
            bottom: 0;
            padding: 10px 0;
        }
        button a {
            color: orange;
            text-decoration: none;
        }
    </style>
</head>
<body>
<header>
<section>
    <h1><u>Payments Form</u><</h1>

    <form method="post" action="payments.php" onsubmit="return confirmInsert();">
        <label for="PaymentID">PaymentID:</label>
        <input type="number" id="PaymentID" name="PaymentID"><br>
        <label for="UserID">UserID:</label>
        <input type="number" id="UserID" name="UserID"><br>
        <label for="Amount">Amount:</label>
        <input type="number" id="Amount" name="Amount" min="0" step="0.01" required><br>
        <label for="PaymentDate">Payment Date:</label>
        <input type="date" id="PaymentDate" name="PaymentDate" required><br>
        <label for="PaymentMethod">Payment Method:</label>
        <input type="text" id="PaymentMethod" name="PaymentMethod" required><br>
        <label for="Description">Description:</label>
        <input type="text" id="Description" name="Description" required><br>
        <input type="submit" name="add" value="Insert">
    </form>

    <?php
    include('dbconnection.php'); // Include your database connection file

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind parameters for payment insertion
        $stmt = $connection->prepare("INSERT INTO payments (PaymentID , UserID, Amount, PaymentDate, PaymentMethod, Description) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iisdss", $PaymentID, $UserID, $Amount, $PaymentDate, $PaymentMethod, $Description);

        // Set parameters from form data
        $PaymentID = $_POST['PaymentID '];
        $UserID = $_POST['UserID'];
        $Amount = $_POST['Amount'];
        $PaymentDate = $_POST['PaymentDate'];
        $PaymentMethod = $_POST['PaymentMethod'];
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

    $sql = "SELECT * FROM payments";
    $result = $connection->query($sql);
    ?>

    <h2>Table of Payments</h2>
    <table>
        <tr>
            <th>PaymentID </th>
            <th>UserID</th>
            <th>Amount</th>
            <th>Payment Date</th>
            <th>Payment Method</th>
            <th>Description</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        // Output data from the payments table
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $PaymentID = $row['PaymentID'];
                echo "<tr>
                    <td>" . $row['PaymentID'] . "</td>
                    <td>" . $row['UserID'] . "</td>
                    <td>" . $row['Amount'] . "</td>
                    <td>" . $row['PaymentDate'] . "</td>
                    <td>" . $row['PaymentMethod'] . "</td>
                    <td>" . $row['Description'] . "</td>
                    <td><a href='delete_payments.php?PaymentID=$PaymentID '>Delete</a></td>
                    <td><a href='update_payments.php?PaymentID=$PaymentID '>Update</a></td>
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
