<?php
$host = "localhost";
$username = "1162174";
$password = "du1234";
$dbname = "1162174db2";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// sql to create table
$sql = "DROP TABLE federer;";


if ($conn->query($sql) === TRUE) {
    echo "Table Deleted !";
} else {
    echo "Error deleting table: " . $conn->error;
}

$conn->close();

?>