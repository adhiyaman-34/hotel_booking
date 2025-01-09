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
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve POST data
    $room_no = isset($_POST['room_no']) ? $conn->real_escape_string($_POST['room_no']) : '';
    $price = isset($_POST['price']) ? $conn->real_escape_string($_POST['price']) : '';
    $check_in = isset($_POST['check_in']) ? $conn->real_escape_string($_POST['check_in']) : '';
    $start_date = isset($_POST['start_date']) ? $conn->real_escape_string($_POST['start_date']) : '';
    $end_date = isset($_POST['end_date']) ? $conn->real_escape_string($_POST['end_date']) : '';

    // Validate form data
    if (empty($room_no) || empty($price) || empty($check_in) || empty($start_date) || empty($end_date)) {
        die("All fields are required.");
    }

    // Calculate total price
    $start = new DateTime($start_date);
    $end = new DateTime($end_date);
    $interval = $start->diff($end);

    if ($interval->invert) {
        die("Invalid date range. Start date must be before end date.");
    }

    $number_of_days = $interval->days + 1;
    $total_price = $number_of_days * $price;

    // Prepare SQL to insert booking details
    $sql = "INSERT INTO bookings (room_no, check_in, start_date, end_date, total_price) 
            VALUES ('$room_no', '$check_in', '$start_date', '$end_date', '$total_price')";

    if ($conn->query($sql) === TRUE) {
        header("Location: payment.php?total_price=$total_price&room_no=$room_no" . urlencode($name));
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
