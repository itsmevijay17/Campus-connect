<?php
session_start();
require_once 'db_connect.php';

// Check if organizer is logged in
if (!isset($_SESSION['organizer_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

try {
    $query = "SELECT od.*, s.name as studentName, s.department 
              FROM od_requests od 
              JOIN students s ON od.student_id = s.id";
    $result = $conn->query($query);
    
    $requests = [];
    while ($row = $result->fetch_assoc()) {
        $requests[] = $row;
    }
    
    echo json_encode($requests);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
}

$conn->close();
?>