<?php  
$servername="localhost";
$username="paccy1";
$password="0791177597";
$dbname="language_exchange";

$connection=new mysqli($servername, $username, $password, $dbname);
if ($connection->connect_error) {
    die("connection failed.".$connection->connect_error);
} else {
    echo "Connected successfully";
}
?>