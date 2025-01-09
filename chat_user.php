<?php
session_start(); // Start the session to access $_SESSION variables

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

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You are not logged in. Please login to access the chat.");
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID

// Fetch user details
$sql = "SELECT username FROM signup WHERE id = '$user_id'";
$result = $conn->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $username = $row['username'];
} else {
    die("User not found.");
}

// Fetch messages for the logged-in user and admin only
$sql = "SELECT * FROM message WHERE 
        (sender = '$username' AND receiver = 'admin') 
        OR (sender = 'admin' AND receiver = '$username') 
        ORDER BY timestamp ASC";

$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

// Handle message sending
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id'])) { // Ensure the user is logged in
        $message = $_POST['message'];
        $sender = $username;  // The logged-in user is sending the message
        $receiver = "admin";  // Admin will receive the message
        
        if (!empty($message)) { // Check if the message is not empty
            // Insert the message into the database
            $sql = "INSERT INTO message (sender, receiver, message, user_id) VALUES ('$sender', '$receiver', '$message', '$user_id')";
            if ($conn->query($sql) === TRUE) {
                // Redirect to refresh the chat page with the new message
                header("Location: chat_user.php");
                exit();
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Message cannot be empty.";
        }
    } else {
        echo "You are not logged in.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chat-header {
            background-color: #0056d2;
            color: white;
            padding: 15px 20px;
        }
        .chat-box {
            height: calc(100vh - 150px);
            overflow-y: auto;
            margin-top: 15px;
        }
        .message {
            padding: 10px;
            border-radius: 15px;
            margin-bottom: 10px;
            max-width: 75%;
            word-wrap: break-word;
        }
        .message.sent {
            background-color: #0056d2;
            color: white;
            align-self: flex-end;
            border-top-left-radius: 0;
        }
        .message.received {
            background-color: #f1f1f1;
            align-self: flex-start;
            border-top-right-radius: 0;
        }
        .message .timestamp {
            font-size: 10px;
            color: #aaa;
            text-align: right;
            display: block;
        }
    </style>
</head>
<body>
    <div class="container-fluid d-flex flex-column h-100">
        <!-- Header -->
        <div class="chat-header d-flex align-items-center justify-content-between">
            <a href="user_dashboard.php" class="btn btn-light btn-sm">← Back</a>
            <span>Chat with Smart Stay</span>
        </div>

        <!-- Chat Messages -->
        <div class="chat-box d-flex flex-column px-3">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Adjust message class based on sender
                    $messageClass = ($row['sender'] == $username) ? "sent" : "received";
                    echo "<div class='message $messageClass'>";
                    echo "<strong>" . htmlspecialchars($row['sender']) . ":</strong> " . htmlspecialchars($row['message']);
                    echo "<span class='timestamp'>" . $row['timestamp'] . "</span>";
                    echo "</div>";
                }
            } else {
                echo "<p class='text-center'>No messages yet.</p>";
            }
            ?>
        </div>

        <!-- Message Input -->
        <div class="input-container mt-auto p-3 bg-light border-top">
            <form action="chat_user.php" method="POST" class="d-flex">
                <textarea name="message" class="form-control me-2" placeholder="Type your message..." required></textarea>
                <button type="submit" class="btn btn-primary">Send</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
