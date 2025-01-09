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

// Query to fetch all feedback from the database
$sql = "SELECT * FROM feedback ORDER BY created_at DESC";
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
    <title>Admin Feedback Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            background-color: #0056d2;
            color: white;
            padding: 10px 20px;
        }
        .navbar .title {
            color: white;
            font-size: 20px;
            font-weight: bold;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px;
            margin: 5px;
            border-radius: 5px;
        }
        .navbar a:hover {
            background-color: #003a8c;
        }
        .feedback-table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        .feedback-table th, .feedback-table td {
            padding: 12px;
            border: 1px solid #ddd;
        }
        .feedback-table th {
            background-color: #f4f4f4;
        }
        .star-rating {
            font-size: 20px;
            color: gold;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar d-flex justify-content-between">
        <div class="title">Admin - Feedback Management</div>
        <a href="owner_dashboard.php" class="btn btn-secondary">Back</a>
    </nav>

    <!-- Feedback Admin View -->
    <div class="container">
        <h2 class="text-center my-4">Manage Feedback</h2>
        <table class="feedback-table">
            <thead>
                <tr>
                    <th>Room No</th>
                    <th>Rating</th>
                    <th>Feedback Text</th>
                    <th>Submitted On</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $rating = $row['rating'];
                        $stars = str_repeat('★', $rating) . str_repeat('☆', 5 - $rating);
                        echo "<tr>
                                <td>{$row['room_no']}</td>
                                <td class='star-rating'>{$stars}</td>
                                <td>{$row['feedback_text']}</td>
                                <td>{$row['created_at']}</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No feedback available.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
