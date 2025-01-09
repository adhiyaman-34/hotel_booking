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

// Get hotel name (assumed to be stored in a separate table, for example, "hotel" table)
$hotel_name = "Stay Smart Reviews"; // Replace with query to fetch from the database if needed

// Fetch all feedback and ratings from the database
$sql = "SELECT feedback_text, rating, created_at FROM feedback ORDER BY created_at DESC";
$result = $conn->query($sql);

// Calculate the overall rating (average rating)
$rating_sql = "SELECT AVG(rating) AS avg_rating FROM feedback";
$rating_result = $conn->query($rating_sql);
$avg_rating = 0;
if ($rating_result->num_rows > 0) {
    $row = $rating_result->fetch_assoc();
    $avg_rating = round($row['avg_rating'], 1); // Round to 1 decimal place
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Reviews - <?php echo $hotel_name; ?></title>

    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Additional custom styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #0056d2;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            font-size: 36px;
        }

        .reviews-section {
            background-color: #eef6ff;
            padding: 20px;
            margin-top: 20px;
            border-radius: 8px;
        }

        .review-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            padding: 15px;
            margin-top: 20px;
        }

        .review-card p {
            font-size: 16px;
            color: #6c757d;
        }

        .rating {
            font-size: 20px;
            color: #f39c12;
        }

        .created-at {
            font-size: 14px;
            color: #777;
        }

        /* Back button styles */
        .back-btn {
            font-size: 18px;
            color: white;
            text-decoration: none;
            background-color: #003c99;
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .back-btn:hover {
            background-color: #002c6b;
        }

        /* Make sure the back button is responsive */
        .header .back-btn {
            font-size: 16px;
            padding: 8px 16px;
        }

    </style>
</head>
<body>

<!-- Header Section with Back Button -->
<div class="header d-flex justify-content-between align-items-center">
    <h1 class="m-0"><?php echo $hotel_name; ?></h1>
    <a href="javascript:history.back()" class="back-btn">Back</a>
</div>

<!-- Reviews Section -->
<div class="container reviews-section">
    <h2>Overall Rating</h2>
    <div class="rating">
        <?php
        // Displaying the overall rating (stars)
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $avg_rating) {
                echo "&#9733;"; // Full star
            } else {
                echo "&#9734;"; // Empty star
            }
        }
        echo " " . $avg_rating . " / 5";
        ?>
    </div>

    <h2>User Feedback</h2>

    <?php
    if ($result->num_rows > 0) {
        // Output each review
        while($row = $result->fetch_assoc()) {
            echo '<div class="review-card">';
            echo '<p class="rating">Rating: ';
            for ($i = 1; $i <= 5; $i++) {
                if ($i <= $row['rating']) {
                    echo "&#9733;"; // Full star
                } else {
                    echo "&#9734;"; // Empty star
                }
            }
            echo '</p>';
            echo '<p>' . htmlspecialchars($row['feedback_text']) . '</p>';
            echo '<p class="created-at">Posted on: ' . htmlspecialchars($row['created_at']) . '</p>';
            echo '</div>';
        }
    } else {
        echo "<p>No reviews available.</p>";
    }
    ?>
</div>

<!-- Bootstrap JS and Popper.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

</body>
</html>
