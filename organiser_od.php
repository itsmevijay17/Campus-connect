<?php
session_start();
require_once 'db.php';

// Check if organizer is logged in
if (!isset($_SESSION['organizer_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Unauthorized access'
    ]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    
    switch($action) {
        case 'get_requests':
            // Get all OD requests for events managed by this organizer
            $organizer_id = $_SESSION['organizer_id'];
            $query = "SELECT od.*, s.name as student_name, s.department, e.name as event_name 
                     FROM od_requests od 
                     JOIN students s ON od.student_id = s.id 
                     JOIN organizer_events e ON od.event_id = e.id 
                     WHERE e.organizer_id = ? AND od.teacher_status = 'Approved'";
            
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $organizer_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $requests = [];
            while($row = $result->fetch_assoc()) {
                $requests[] = $row;
            }
            
            echo json_encode([
                'status' => 'success',
                'requests' => $requests
            ]);
            break;
            
        case 'update_status':
            $request_id = $_POST['request_id'];
            $status = $_POST['status'];
            $organizer_id = $_SESSION['organizer_id'];
            
            $query = "UPDATE od_requests 
                     SET organizer_status = ?, 
                         organizer_id = ?, 
                         updated_at = CURRENT_TIMESTAMP 
                     WHERE id = ?";
            
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sii", $status, $organizer_id, $request_id);
            
            if ($stmt->execute()) {
                // If selecting participant, add to selected_participants table
                if ($status === 'Selected') {
                    $query = "INSERT INTO selected_participants (event_id, student_reg_no, status, selected_by) 
                             SELECT event_id, student_id, ?, ? 
                             FROM od_requests WHERE id = ?";
                    
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("sii", $status, $organizer_id, $request_id);
                    $stmt->execute();
                }
                
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Status updated successfully'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to update status'
                ]);
            }
            break;
    }
    
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method'
    ]);
}

$conn->close();
?>