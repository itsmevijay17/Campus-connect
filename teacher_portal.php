<?php
session_start();
require 'vendor/autoload.php'; // Load QR Code Library
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

date_default_timezone_set('Asia/Kolkata'); // Set your timezone

$date = date("Y-m-d"); // Today's date
$hour = date("H"); // Current hour (24-hour format)
$qrData = "attendance:$date-$hour"; // QR Code contains date & hour

$qrCode = QrCode::create($qrData)->setWriter(new PngWriter())->writeDataUri();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Portal - QR Code Attendance</title>
</head>
<body>
    <h2>Teacher Portal - QR Code Attendance</h2>
    <p><strong>Current QR Code (Valid for this hour only)</strong></p>

    <!-- Display QR Code -->
    <img src="<?php echo $qrCode; ?>" alt="Attendance QR Code">

    <h3>Attendance Records for Today (<?php echo $date; ?>)</h3>
    <table border="1">
        <tr>
            <th>Student Name</th>
            <th>Reg No</th>
            <th>Date</th>
            <th>Hour</th>
            <th>Status</th>
            <th>Time</th>
        </tr>

        <?php
        require 'db_connect.php';
        $conn = getDBConnection();

        $result = $conn->query("SELECT students.name, attendance.reg_no, attendance.date, attendance.hour, attendance.status, attendance.time 
                                FROM attendance 
                                JOIN students ON attendance.reg_no = students.reg_no 
                                WHERE attendance.date = '$date' 
                                ORDER BY attendance.time ASC");

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['name']}</td>
                    <td>{$row['reg_no']}</td>
                    <td>{$row['date']}</td>
                    <td>{$row['hour']}</td>
                    <td>{$row['status']}</td>
                    <td>{$row['time']}</td>
                  </tr>";
        }
        ?>
    </table>

    <script>
        // Auto-refresh QR code every hour (3600000ms = 1 hour)
        setInterval(() => { location.reload(); }, 3600000);
    </script>
</body>
</html>