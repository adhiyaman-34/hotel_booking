<?php
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $checkin = $_POST["checkin"];  // Corrected from email to username
    $checkout = $_POST["checkout"];

    // Convert the input dates to DateTime objects
    $checkinDate = new DateTime($checkin);
    $checkoutDate = new DateTime($checkout);

    // Calculate the difference between the two dates
    $interval = $checkinDate->diff($checkoutDate);

    // Get the number of days
    $daysCount = $interval->days;

    // echo "Check-in Date: " . $checkin . "<br>";
    // echo "Check-out Date: " . $checkout . "<br>";
    // echo "Total Days: " . $daysCount . "<br>";

    $_SESSION['checkin'] = $checkin;
    $_SESSION['checkout'] = $checkout;
    $_SESSION['daysCount'] = $daysCount;
    
    header("Location: homepage.php");
    exit();
} else {
    header("Location: index.php");
    exit();
}
?>
