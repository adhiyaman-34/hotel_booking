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

// Define facilities
$facilities = [
    "Free Wi-Fi",
    "Swimming Pool",
    "Spa and Wellness Center",
    "Multi-cuisine Restaurant",
    "Fitness Center",
    "Conference Rooms",
    "24/7 Room Service"
];

// Fetch all rooms
$roomsQuery = "SELECT room_no, image, type, price, bed, wifi, capacity, room_status FROM add_room";
$roomsResult = $conn->query($roomsQuery);

// Fetch customer reviews
$reviewsQuery = "SELECT username, feedback_text, rating FROM feedback LIMIT 5";
$reviewsResult = $conn->query($reviewsQuery);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Overview</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
            margin: 0;
        }

        header {
            background: url('banner.jpg') no-repeat center center/cover;
            color: white;
            padding: 20px;
            text-align: center;
        }

        header h1 {
            font-size: 2.5rem;
        }

        header p {
            font-size: 1.2rem;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            padding: 20px;
        }

        .left, .right {
            padding: 20px;
        }

        .left {
            flex: 3;
        }

        .right {
            flex: 2;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            margin-left: 20px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section h2 {
            border-bottom: 2px solid #333;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        .facilities ul {
            list-style: disc;
            padding-left: 20px;
        }

        .facilities ul li {
            margin-bottom: 10px;
        }

        .room {
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .room img {
            max-width: 150px;
            height: auto;
            float: left;
            margin-right: 15px;
        }

        .room-details {
            overflow: hidden;
        }

        .room-details p {
            margin: 5px 0;
        }

        .reviews {
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
        }

        .review {
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .review:last-child {
            border-bottom: none;
        }

        .review p {
            margin: 5px 0;
        }

        .rating {
            color: #FFD700;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to Our Hotel</h1>
        <p>Experience luxury and comfort at its best.</p>
    </header>

    <div class="container">
        <!-- Left Content -->
        <div class="left">
            <!-- Facilities Section -->
            <div class="section facilities">
                <h2>Our Facilities</h2>
                <ul>
                    <?php foreach ($facilities as $facility): ?>
                        <li><?= htmlspecialchars($facility) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Rooms Section -->
            <div class="section rooms">
                <h2>Available Rooms</h2>
                <?php if ($roomsResult->num_rows > 0): ?>
                    <?php while ($room = $roomsResult->fetch_assoc()): ?>
                        <div class="room">
                            <img src="<?= htmlspecialchars($room['image']) ?>" alt="Room Image">
                            <div class="room-details">
                                <p><strong>Room No:</strong> <?= htmlspecialchars($room['room_no']) ?></p>
                                <p><strong>Type:</strong> <?= htmlspecialchars($room['type']) ?></p>
                                <p><strong>Bed:</strong> <?= htmlspecialchars($room['bed']) ?></p>
                                <p><strong>Wi-Fi:</strong> <?= htmlspecialchars($room['wifi']) ?></p>
                                <p><strong>Capacity:</strong> <?= htmlspecialchars($room['capacity']) ?> Guests</p>
                                <p><strong>Price:</strong> <?= htmlspecialchars($room['price']) ?> per night</p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No rooms available at the moment.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right Content -->
        <div class="right">
            <div class="reviews">
                <h2>Customer Reviews</h2>
                <?php if ($reviewsResult->num_rows > 0): ?>
                    <?php while ($review = $reviewsResult->fetch_assoc()): ?>
                        <div class="review">
                            <p><strong><?= htmlspecialchars($review['username']) ?>:</strong></p>
                            <p><?= htmlspecialchars($review['feedback_text']) ?></p>
                            <p class="rating">Rating: <?= str_repeat('★', $review['rating']) ?></p>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No reviews available at the moment.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
