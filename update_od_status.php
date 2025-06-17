<?php
session_start();
require_once 'db_connect.php';

// Check if organizer is logged in
if (!isset($_SESSION['organizer_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);
$requestId = $data['requestId'];
$status = $data['status'];

try {
    $query = "UPDATE od_requests SET organizer_status = ?, updated_at = NOW() 
              WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $status, $requestId);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception('Update failed');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
}

$conn->close();
?>