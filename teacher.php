<?php
session_start();
include 'db_connect.php';

if (!isset($_GET['teacherID'])) {
    header("Location: teacher_login.html");
    exit();
}

$teacherID = $_GET['teacherID'];

$query = "SELECT * FROM teachers WHERE teacherID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $teacherID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $teacher = $result->fetch_assoc();
    
    $_SESSION['teacherID'] = $teacher['teacherID'];
    $_SESSION['name'] = $teacher['name'];
    $_SESSION['email'] = $teacher['email'];
    $_SESSION['department'] = $teacher['department'];
    $_SESSION['designation'] = $teacher['designation'];
    $_SESSION['subjects'] = $teacher['subjects'];
    $_SESSION['profile_pic'] = $teacher['profile_pic'];

    header("Location: teacher_dashboard.php");
    exit();
} else {
    echo "Invalid Teacher ID. <a href='teacher_login.html'>Try again</a>";
}
?>

