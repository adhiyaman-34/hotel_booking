<?php
// Database connection details
$servername = "localhost";
$username = "root";  // Database username
$password = "";  // Database password
$dbname = "hoteldb";  // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User not logged in");
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID

// Query to fetch booking details including room images
$sql = "
    SELECT 
        b.room_no, 
        b.start_date, 
        b.end_date, 
        b.total_price, 
        r.image 
    FROM payment p
    JOIN bookings b ON p.product_id = b.room_no
    JOIN add_room r ON b.room_no = r.room_no
    WHERE p.userid = ?
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
    <title>My Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffff;
            padding: 20px;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background-color: #0056d2;
            color: white;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
        .navbar h2 {
            font-size: 24px;
            color: white;
        }
        .navbar nav {
            display: flex;
            gap: 15px;
        }
        .navbar a {
            text-decoration: none;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s;
            font-size: 14px;
        }
        .navbar a:hover, .navbar a.active {
            background-color: #003c99;
        }
        .booking-cards-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
            margin-top: 80px; /* Space for the fixed navbar */
        }
        .booking-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
            padding: 10px;
            width: 250px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .booking-card img {
            border-radius: 8px;
            width: 100%;
            height: 150px;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .booking-card h3 {
            margin: 10px 0;
            font-size: 16px;
            color: #0056d2;
        }
        .booking-card p {
            font-size: 14px;
            margin: 5px 0;
            color: #555;
        }
        .booking-card .price {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }
        .booking-card button {
            margin-top: 10px;
            background-color: #0056d2;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        .booking-card button:hover {
            background-color: #003c99;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<header class="navbar">
    <h2>Stay Smart</h2>
    <nav>
        <a href="user_dashboard.php">Dashboard</a>
        <a href="my_bookings.php" class="active">My Bookings</a>
        <a href="select_room.php">Book My Stay</a>
        <a href="chat_user.php">Chat Your Need</a>
        <a href="review.php">Review</a>
        <a href="homepage.php">Log Out</a>
    </nav>
</header>

<!-- Booking cards section -->
<div class="booking-cards-container">
    <?php if (!empty($bookings)): ?>
        <?php foreach ($bookings as $booking): ?>
            <div class="booking-card">
                <img src="<?= htmlspecialchars($booking['image']) ?>" alt="Room Image">
                <h3>Room No: <?= htmlspecialchars($booking['room_no']) ?></h3>
                <p>Start Date: <?= htmlspecialchars($booking['start_date']) ?></p>
                <p>End Date: <?= htmlspecialchars($booking['end_date']) ?></p>
                <p class="price">Total: ₹<?= htmlspecialchars($booking['total_price']) ?></p>
                <!-- Feedback Button -->
                <button onclick="window.location.href='user_feedback.php?room_no=<?= htmlspecialchars($booking['room_no']) ?>'">Feedback</button>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No bookings found.</p>
    <?php endif; ?>
</div>

</body>
</html>
