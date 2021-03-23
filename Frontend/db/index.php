<?php
$username = "1162174";
$password = "du1234";
$host = "localhost";

$db = 1;  // 1 for Users, 2 for Marks Data

if ($db==1) {
	$dbname = "1162174";
} elseif ($db==2) {
	$dbname = "1162174db2";
} else {
	echo "Please select the correct DB.";
	die();	
}

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT College, Subjects, UR, OBC, SC, ST, PwD, KM, SG, SM FROM federer";
$result = $conn->query($sql);
/*
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo $row["College"]. "-" . $row["Subjects"]. $row["UR"] . $row["OBC"] . $row["SC"] . $row["ST"] . $row["PwD"] . $row["KM"] . $row["SG"] . $row["SM"] ."<br>";
    }
} else {
    echo "0 results";
}
*/


$sql = "SELECT id, name, email, cat, sub, marks FROM searches";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo $row["id"]. " - Name: " . $row["name"]. ", Email: " . $row["email"]. ", Category: " . $row["cat"] . ", Subjects: " . $row["sub"]. ", Marks: " . $row["marks"] ."<br>";
    }
} else {
    echo "0 results";
}




$conn->close();
?>