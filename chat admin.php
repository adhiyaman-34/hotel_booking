<?php
session_start();
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

// Check if 'user' parameter exists in the URL
if (isset($_GET['user']) && !empty($_GET['user'])) {
    $user = $_GET['user'];
} else {
    die("No user specified.");
}

// Fetch messages between admin and user
$sql = "SELECT * FROM message WHERE (sender = '$user' AND receiver = 'admin') OR (sender = 'admin' AND receiver = '$user') ORDER BY timestamp ASC";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

// Handle message sending
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'];
    $sender = "admin";  // Admin is sending the message
    $receiver = $user;  // The user passed in the URL
    $user_id = $_SESSION['user_id'];
    // Insert the message into the database
    $sql = "INSERT INTO message (sender, receiver, message, user_id) VALUES ('$sender', '$receiver', '$message', $user_id)";
    if ($conn->query($sql) === TRUE) {
        // Redirect to refresh the chat page with the new message
        header("Location: chat admin.php?user=" . urlencode($receiver));
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with <?php echo htmlspecialchars($user); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        .header {
            background-color: #0056d2;
            color: white;
            padding: 15px;
            text-align: center;
        }
        .chat-box {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            padding: 20px;
            overflow-y: auto;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            background-color: #f1f1f1;
            max-width: 70%;
        }
        .message strong {
            font-weight: bold;
        }
        .message small {
            display: block;
            margin-top: 5px;
            font-size: 12px;
            color: #aaa;
        }
        .message.sent {
            align-self: flex-end;
            background-color: #007bff;
            color: white;
        }
        .message.received {
            align-self: flex-start;
        }
        .input-container {
            display: flex;
            padding: 20px;
            background-color: #fff;
            border-top: 1px solid #ddd;
        }
        .input-container textarea {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            resize: none;
        }
        .input-container button {
            background-color: #0056d2;
            color: white;
            border: none;
            padding: 10px 15px;
            margin-left: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .input-container button:hover {
            background-color: #003f99;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Chat with <?php echo htmlspecialchars($user); ?></h2>
    </div>

    <div class="chat-box">
        <?php
        // Display chat messages
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $messageClass = ($row['sender'] == "admin") ? "sent" : "received";
                echo "<div class='message $messageClass'>";
                echo "<strong>" . htmlspecialchars($row['sender']) . ":</strong> ";
                echo htmlspecialchars($row['message']);
                echo " <small>" . $row['timestamp'] . "</small>";
                echo "</div>";
            }
        } else {
            echo "<p>No messages yet.</p>";
        }
        ?>
    </div>

    <div class="input-container">
        <form action="chat admin.php?user=<?php echo urlencode($user); ?>" method="POST" style="width: 100%;">
            <textarea name="message" placeholder="Type your message here..." required></textarea>
            <button type="submit">Send</button>
        </form>
    </div>
</body>
</html>
