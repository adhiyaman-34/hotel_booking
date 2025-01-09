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

// Assuming user is logged in, get user_id from session
session_start();
if (!isset($_SESSION['user_id'])) {
    die("User not logged in. Please login to submit feedback.");
}

$user_id = $_SESSION['user_id'];  // Fetch user ID from session

// Handle feedback submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_no = $_POST['room_no'];
    $feedback_text = $_POST['feedback_text'];
    $rating = $_POST['rating'];

    // Insert feedback into the database without the 'user_id'
    $stmt = $conn->prepare("INSERT INTO feedback (room_no, feedback_text, rating) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $room_no, $feedback_text, $rating);

    if ($stmt->execute()) {
        echo "Feedback submitted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Feedback</title>
    <style>
        /* Basic styles for the feedback form */
        .feedback-form {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .feedback-form label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #333;
        }
        .feedback-form textarea, .feedback-form input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .feedback-form button {
            padding: 12px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .feedback-form button:hover {
            background-color: #0056b3;
        }

        /* Star rating styles */
        .star-rating {
            display: flex;
            justify-content: space-between;
            width: 200px;
            cursor: pointer;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            font-size: 30px;
            color: #ddd;
            transition: color 0.3s ease;
        }

        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #ffb400;
        }

        /* Emoji Icon Style */
        .emoji-icon {
            font-size: 24px;
            cursor: pointer;
            position: absolute;
            bottom: 20px;
            right: 0px;
            color: #333; /* Black-and-white effect */
        }

        /* Emoji Picker */
        .emoji-picker {
            display: none;
            position: absolute;
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 100;
            max-width: 200px;
            overflow: auto;
            height: 100px;
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 5px;
        }

        .emoji-picker span {
            cursor: pointer;
            font-size: 20px;
            padding: 5px;
            color: #333; /* Black-and-white effect */
        }

        .emoji-picker span:hover {
            background-color: #f0f0f0;
            border-radius: 5px;
        }

        /* Header with Back button */
        .header {
            background-color: #0056d2;
            color: white;
            padding: 10px 20px;
            text-align: left;
        }

        .header a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            background-color: #003c99;
            padding: 8px 16px;
            border-radius: 5px;
        }

        .header a:hover {
            background-color: #002f74;
        }
    </style>
</head>
<body>
    <!-- Header with Back button -->
    <div class="header">
        <a href="my_bookings.php">Back to My Bookings</a>
    </div>

    <!-- Feedback Form -->
    <div class="feedback-form">
        <h2>Submit Your Feedback</h2>
        <form action="user_feedback.php" method="POST">
            <label for="room_no">Room No:</label>
            <input type="number" name="room_no" placeholder="Enter your room number" required>

            <label for="rating">Rating:</label>
            <div class="star-rating">
                <input type="radio" id="star5" name="rating" value="5" required>
                <label for="star5">&#9733;</label>
                <input type="radio" id="star4" name="rating" value="4">
                <label for="star4">&#9733;</label>
                <input type="radio" id="star3" name="rating" value="3">
                <label for="star3">&#9733;</label>
                <input type="radio" id="star2" name="rating" value="2">
                <label for="star2">&#9733;</label>
                <input type="radio" id="star1" name="rating" value="1">
                <label for="star1">&#9733;</label>
            </div>

            <label for="feedback_text">Feedback:</label>
            <div style="position: relative;">
                <textarea name="feedback_text" id="feedback_text" rows="5" placeholder="Enter your feedback" required></textarea>
                <!-- Emoji Icon inside the textarea container -->
                <span id="emojiIcon" class="emoji-icon">😊</span>
                <!-- Emoji Picker inside the textarea container -->
                <div id="emojiPicker" class="emoji-picker">
                    <span>😊</span>
                    <span>😁</span>
                    <span>😂</span>
                    <span>😅</span>
                    <span>😍</span>
                    <span>😜</span>
                    <span>😎</span>
                    <span>😢</span>
                    <span>😡</span>
                    <span>🥺</span>
                    <span>🤩</span>
                    <span>🤗</span>
                </div>
            </div>

            <button type="submit">Submit Feedback</button>
        </form>
    </div>

    <script>
        // Emoji picker functionality
        const emojiIcon = document.getElementById('emojiIcon');
        const emojiPicker = document.getElementById('emojiPicker');
        const feedbackTextArea = document.getElementById('feedback_text');

        // Toggle emoji picker visibility
        emojiIcon.addEventListener('click', function() {
            emojiPicker.style.display = emojiPicker.style.display === 'none' ? 'grid' : 'none';
        });

        // Add emoji to feedback text area
        emojiPicker.addEventListener('click', function(event) {
            if (event.target.tagName.toLowerCase() === 'span') {
                feedbackTextArea.value += event.target.textContent;  // Insert emoji into the textarea
                emojiPicker.style.display = 'none';  // Close the picker after selection
            }
        });

        // Close the emoji picker if clicked outside
        window.addEventListener('click', function(event) {
            if (!emojiIcon.contains(event.target) && !emojiPicker.contains(event.target)) {
                emojiPicker.style.display = 'none';
            }
        });
    </script>
</body>
</html>
