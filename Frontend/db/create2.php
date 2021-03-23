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
$sql = "CREATE TABLE federer (
College VARCHAR(100) NOT NULL,
Subjects VARCHAR(100) NOT NULL,
UR VARCHAR(50),
OBC VARCHAR(50),
SC VARCHAR(50),
ST VARCHAR(50),
PwD VARCHAR(50),
KM VARCHAR(50),
SG VARCHAR(50),
SM VARCHAR(50)
)";


if ($conn->query($sql) === TRUE) {
    echo "Table created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();

?>