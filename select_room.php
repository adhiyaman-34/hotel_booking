<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Update if necessary
$password = ""; // Update if necessary
$dbname = "hoteldb"; // Update with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch room data where room_status is not booked (room_status != 1)
$sql = "SELECT * FROM add_room WHERE room_status != 1";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Stay - Select Room</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            min-height: 100vh;
            background-color: #eef6ff;
            color: #333;
        }

        /* Navbar */
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

        .content {
            margin-top: 80px;
            padding: 20px;
        }

        .room-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
            justify-content: center;
        }

        .room-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            width: 300px;
            background-color: #fff;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .room-card img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .room-card h3 {
            margin: 10px 0;
            color: #333;
        }

        .room-card p {
            margin: 5px 0;
            color: #555;
        }

        .room-card button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .room-card button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header class="navbar">
        <h2>Stay Smart</h2>
        <nav>
            <a href="user_dashboard.php">Dashboard</a>
            <a href="my_bookings.php">My Bookings</a>
            <a href="select_room.php" class="active">Book My Stay</a>
            <a href="chat_user.php">Chat Your Need</a>
            <a href="review.php">Review</a>
            <a href="homepage.php">Log Out</a>
        </nav>
    </header>
    <div class="content">
        <main>
            <div class="room-container">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="room-card">
                            <img src="' . htmlspecialchars($row['image']) . '" alt="Room Image">
                            <h3>Room No: ' . htmlspecialchars($row['room_no']) . '</h3>
                            <p>Type: ' . htmlspecialchars($row['type']) . '</p>
                            <p>WiFi: ' . htmlspecialchars($row['wifi']) . '</p>
                            <p>Capacity: ' . htmlspecialchars($row['capacity']) . '</p>
                            <p>Price: ₹' . htmlspecialchars($row['price']) . '</p>
                            <button onclick="window.location.href=\'bookin.php?room_no=' . urlencode($row['room_no']) . '\'">Book Now</button>
                        </div>';
                    }
                } else {
                    echo '<p>No rooms available</p>';
                }
                ?>
            </div>
        </main>
    </div>
</body>
</html>
