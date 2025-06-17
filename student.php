<?php
session_start();
include 'db_connect.php';

if (!isset($_GET['regNumber'])) {
    header("Location: student_login.html");
    exit();
}

$regNumber = $_GET['regNumber'];

$query = "SELECT * FROM students WHERE regNumber = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $regNumber);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
    
    $_SESSION['regNumber'] = $student['regNumber'];
    $_SESSION['name'] = $student['name'];
    $_SESSION['email'] = $student['email'];
    $_SESSION['department'] = $student['department'];
    $_SESSION['section'] = $student['section'];
    $_SESSION['year'] = $student['year'];
    $_SESSION['mentor'] = $student['mentor'];
    $_SESSION['attendance'] = $student['attendance'];
    $_SESSION['profile_pic'] = $student['profile_pic'];

    header("Location: student.php");
    exit();
} else {
    echo "Invalid Roll Number. <a href='student_login.html'>Try again</a>";
}
?>
