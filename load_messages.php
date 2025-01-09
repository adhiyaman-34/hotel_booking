<?php
session_start();
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hoteldb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Assume admin's ID is 1, you can replace this with dynamic admin fetch from DB if needed
$admin_id = 1;

// Fetch all messages between the user and the admin
$stmt = $conn->prepare("SELECT * FROM messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY timestamp ASC");
$stmt->bind_param("iiii", $user_id, $admin_id, $admin_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Display all messages
while ($row = $result->fetch_assoc()) {
    $sender = ($row['sender_id'] == $user_id) ? 'You' : 'Admin';
    $message_class = ($row['sender_id'] == $user_id) ? 'sender' : 'receiver';
    echo "<div class='message $message_class'>" . htmlspecialchars($row['message']) . " <span>[$sender]</span></div>";
}
?>
