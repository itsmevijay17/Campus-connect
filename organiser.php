<?php
session_start();
require_once 'db.php';
if (!isset($_GET['organiserID'])) {
    header("Location: organiser_login.html");
    exit();
}

$organiserID = $_GET['organiserID'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM organizers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $organizer = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $organizer['password'])) {
            // Set session variables
            $_SESSION['organizer_id'] = $organizer['id'];
            $_SESSION['organizer_name'] = $organizer['name'];
            $_SESSION['organizer_email'] = $organizer['email'];
            $_SESSION['organizer_department'] = $organizer['department'];
            
            // Return success response
            echo json_encode([
                'status' => 'success',
                'message' => 'Login successful',
                'redirect' => 'organizer_dashboard.php'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid password'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Organizer not found'
        ]);
    }
    
    $stmt->close();
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method'
    ]);
}

$conn->close();
?>