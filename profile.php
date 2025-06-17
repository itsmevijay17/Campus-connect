<?php
session_start();

// Redirect if the student is not logged in
if (!isset($_SESSION['regNumber'])) {
    header("Location: login.php");
    exit();
}

// Retrieve student details from session
$name = $_SESSION['name'] ?? "Unknown";
$regNumber = $_SESSION['regNumber'] ?? "N/A";
$department = $_SESSION['department'] ?? "N/A";
$section = $_SESSION['section'] ?? "N/A";
$year = $_SESSION['year'] ?? "N/A";
$mentor = $_SESSION['mentor'] ?? "N/A";
$attendance = $_SESSION['attendance'] ?? "N/A";
$profilePic = $_SESSION['profile_pic'] ?? "default_profile.jpg"; // Default image if not available
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000000;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
            color: white;
        }
        .profile-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
            color: black;
        }
        .profile-container img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin-bottom: 15px;
        }
        .profile-container h2 {
            margin: 10px 0;
        }
        .profile-details {
            text-align: left;
            margin-top: 10px;
        }
        .profile-details p {
            margin: 5px 0;
            font-size: 16px;
        }
        .logout-btn {
            margin-top: 15px;
            background: red;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        .logout-btn:hover {
            background: darkred;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <img src="<?php echo htmlspecialchars($profilePic); ?>" alt="Student Photo">
        <h2><?php echo htmlspecialchars($name); ?></h2>
        <div class="profile-details">
            <p><strong>Roll No:</strong> <?php echo htmlspecialchars($regNumber); ?></p>
            <p><strong>Department:</strong> <?php echo htmlspecialchars($department); ?></p>
            <p><strong>Section:</strong> <?php echo htmlspecialchars($section); ?></p>
            <p><strong>Year:</strong> <?php echo htmlspecialchars($year); ?></p>
            <p><strong>Class Advisor:</strong> <?php echo htmlspecialchars($mentor); ?></p>
            <p><strong>Attendance Percentage:</strong> <?php echo htmlspecialchars($attendance); ?>%</p>
        </div>
        <button class="logout-btn" onclick="logout()">Logout</button>
    </div>

    <script>
        function logout() {
            sessionStorage.clear(); // Clear frontend session storage
            window.location.href = "logout.php"; // Redirect to logout script
        }
    </script>
</body>
</html>
