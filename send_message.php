<?php
$conn = new mysqli('localhost', 'root', '', 'hoteldb');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['message'])) {
    $sender_id = $_POST['sender_id'];
    $message = $conn->real_escape_string($_POST['message']);

    $sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES ($sender_id, 0, '$message')"; // Admin ID assumed to be 0
    if ($conn->query($sql)) {
        header("Location: chat_user.php");
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
