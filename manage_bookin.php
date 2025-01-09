<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hoteldb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User not logged in");
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID

// Query to fetch room image, room no, user name, user phone number, start date, end date, transaction date, and transaction ID
$sql = "
    SELECT 
        r.image AS room_image, 
        r.room_no, 
        s.username AS user_name, 
        s.phone_no AS user_phone, 
        b.start_date, 
        b.end_date, 
        p.payment_date,
        p.transaction_id
    FROM 
        bookings b
    JOIN 
        payment p ON b.room_no = p.product_id
    JOIN 
        add_room r ON r.room_no = b.room_no
    JOIN 
        signup s ON s.id = p.userid
    WHERE 
        p.userid = ?
";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$bookings = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 250px;
            background-color: #f8f9fa;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            border-right: 1px solid #ddd;
            padding: 20px;
        }
        .sidebar h2 {
            font-size: 24px;
            color: #0056d2;
            margin-bottom: 30px;
        }
        .sidebar a {
            display: block;
            padding: 10px 15px;
            margin: 5px 0;
            text-decoration: none;
            color: #333;
            border-radius: 5px;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #0056d2;
            color: #fff;
        }
        .main-content {
            margin-left: 260px;
            padding: 20px;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card img {
            border-radius: 8px;
            object-fit: cover;
            height: 200px;
        }
    </style>
</head>
<body>
<div class="sidebar">
        <h2>Smart Stay</h2>
        <a href="owner_dashboard.php">Dashboard</a>
        <a href="edit_room.php">Manage Rooms</a>
        <a href="Manage_bookin.php"class="active">Manage Bookings</a>
        <a href="list of user.php">Message</a>
        <a href="admin_feedback.php">View feedback</a>
        <a href="login.php">Log Out</a>
    </div>

    <div class="main-content">
        <h1 class="text-center mb-4">Room Bookings</h1>
        <div class="row">
            <?php if (!empty($bookings)): ?>
                <?php foreach ($bookings as $booking): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="<?= htmlspecialchars($booking['room_image']) ?>" class="card-img-top" alt="Room Image">
                            <div class="card-body">
                                <h5 class="card-title">Room No: <?= htmlspecialchars($booking['room_no']) ?></h5>
                                <p>User: <?= htmlspecialchars($booking['user_name']) ?></p>
                                <p>Phone No: <?= htmlspecialchars($booking['user_phone']) ?></p>
                                <p>Start Date: <?= htmlspecialchars($booking['start_date']) ?></p>
                                <p>End Date: <?= htmlspecialchars($booking['end_date']) ?></p>
                                <p>Transaction Date: <?= htmlspecialchars($booking['payment_date']) ?></p>
                                <p>Transaction ID: <?= htmlspecialchars($booking['transaction_id']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">No bookings found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
