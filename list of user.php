<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "hoteldb";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch users from the 'signup' table
$sql = "SELECT username FROM signup";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error); // Display SQL error
}

// Fetch unread messages count for each user (admin's perspective)
$unreadMessages = [];
$sqlUnread = "SELECT sender, COUNT(*) AS unread_count 
             FROM message 
             WHERE receiver = 'admin' AND is_read = FALSE 
             GROUP BY sender";
$unreadResult = $conn->query($sqlUnread);

if ($unreadResult) {
    while ($row = $unreadResult->fetch_assoc()) {
        // Store unread message count for each sender
        $unreadMessages[$row['sender']] = $row['unread_count'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #f8f9fa;
            border-right: 1px solid #ddd;
            padding: 15px;
            height: 100vh;
        }
        .sidebar h2 {
            font-size: 24px;
            color: #0056d2;
            margin-bottom: 20px;
        }
        .sidebar a {
            display: block;
            padding: 10px 15px;
            margin: 10px 0;
            text-decoration: none;
            color: #333;
            background-color: #f8f9fa;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #0056d2;
            color: white;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
        }
        .user-container {
            padding: 20px;
            max-width: 600px;
            margin: auto;
        }
        .user-card {
            display: flex;
            align-items: center;
            background: #fff;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            justify-content: flex-start; /* Align content to the left */
        }
        .user-card h4 {
            margin: 0;
            font-size: 16px;
            text-align: left; /* Align text to the left */
            width: 100%; /* Ensure the username takes full width */
            display: flex;
            align-items: center;
        }
        .red-dot {
            width: 10px;
            height: 10px;
            background-color: red;
            border-radius: 50%;
            margin-left: 10px;
        }
        .search-bar {
            margin-top: 20px;
            text-align: left; /* Align the search bar to the left */
        }
        .search-bar input {
            width: 100%;
            max-width: 400px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
    <script>
        // JavaScript for filtering users
        function filterUsers() {
            const input = document.getElementById("searchInput").value.toLowerCase();
            const userCards = document.getElementsByClassName("user-card");

            for (let i = 0; i < userCards.length; i++) {
                const username = userCards[i].getElementsByTagName("h4")[0].innerText.toLowerCase();
                if (username.includes(input)) {
                    userCards[i].style.display = "flex";
                } else {
                    userCards[i].style.display = "none";
                }
            }
        }

        // Check if there are unread messages and play the notification sound
        window.onload = function() {
            <?php if (count($unreadMessages) > 0): ?>
                var audio = new Audio('notification_sound.mp3'); // Replace with your sound file path
                audio.play(); // Play sound when there are unread messages
            <?php endif; ?>
        }
    </script>
</head>
<body>
    <div class="sidebar">
        <h2>Smart Stay</h2>
        <a href="owner_dashboard.php">Dashboard</a>
        <a href="edit_room.php">Manage Rooms</a>
        <a href="Manage_bookin.php">Manage Bookings</a>
        <a href="list of user.php"class="active">Message</a>
        <a href="admin_feedback.php">View feedback</a>
        <a href="login.php">Log Out</a>
    </div>
    <div class="content">
        <div class="user-container">
            <h1>User List</h1>
            
            <!-- Search Bar Below Title -->
            <div class="search-bar">
                <input 
                    type="text" 
                    id="searchInput" 
                    placeholder="Search users..." 
                    onkeyup="filterUsers()"
                />
            </div>

            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Create a link for each user to open chat page with the username
                    $username = htmlspecialchars($row['username']);
                    echo '<div class="user-card">';
                    echo '<a href="chat admin.php?user=' . urlencode($username) . '" style="text-decoration: none; color: inherit;">';
                    echo '<h4>' . $username;
                    
                    // If there are unread messages for the user, show the red dot
                    if (isset($unreadMessages[$username]) && $unreadMessages[$username] > 0) {
                        echo '<span class="red-dot"></span>';
                    }
                    
                    echo '</h4>';
                    echo '</a>';
                    echo '</div>';
                }
            } else {
                echo "<p>No users found.</p>";
            }
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>

