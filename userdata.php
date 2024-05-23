<?php
$servername = "localhost";
$username = "paccy1";
$password = "0791177597";
$dbname = "language_exchange"; // corrected the database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO users (UserID, name, Email, Password, native_language, learning_language, preferred_language)
VALUES ('$_POST[UserID]','$_POST[name]','$_POST[Email]','$_POST[Password]','$_POST[native_language]', '$_POST[learning_language]','$_POST[preferred_language]')";

if ($conn->query($sql) === TRUE) {
    echo "Data inserted successfully<br>";
    header("location:index.php");
} else {
    echo "Error inserting data: " . $conn->error;
}

// Close connection
$conn->close();
?>
