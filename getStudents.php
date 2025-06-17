<?php
$servername = "localhost"; // Change if needed
$username = "root";  // Your phpMyAdmin username
$password = ""; // Your phpMyAdmin password (empty if default)
$dbname = "student_db"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed"]));
}

// Get roll number from the request
$rollNumber = $_GET['rollNumber'];

// Fetch student details
$sql = "SELECT * FROM students WHERE roll_number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $rollNumber);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
    echo json_encode(["status" => "success", "student" => $student]);
} else {
    echo json_encode(["status" => "error", "message" => "Student not found"]);
}

$stmt->close();
$conn->close();
?>
