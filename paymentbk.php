<?php
session_start();
$servername = "localhost";
$username = "root"; // Update if necessary
$password = ""; // Update if necessary
$dbname = "hoteldb"; // Update with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_SESSION['user_id'];

// Capture data from the POST request
$data = [
    'payment_id' => $_POST['razorpay_payment_id'],
    'amount' => $_POST['total_price'],
    'product_id' => $_POST['room_no']
];

// Define the SQL query to insert data into the fees_table
$sql = "INSERT INTO payment (userid, transaction_id, total_price, product_id) VALUES (?, ?, ?, ?)";

// Prepare the statement
if ($stmt = $conn->prepare($sql)) {
    // Bind the parameters and execute the query
    $stmt->bind_param("ssss", $id, $data['payment_id'], $data['amount'], $data['product_id']);

    if ($stmt->execute()) {
        // Respond with success
        $response = ['msg' => 'Payment successfully credited', 'status' => true];
        echo json_encode($response);
    } else {
        // Respond with error if query execution fails
        $response = ['msg' => 'Error: Unable to insert data into the database', 'status' => false];
        echo json_encode($response);
    }

    // Close the statement
    $stmt->close();
} else {
    // Respond with error if statement preparation fails
    $response = ['msg' => 'Error: ' . $conn->error, 'status' => false];
    echo json_encode($response);
}

// Close the database connection
$conn->close();
?>