<?php
require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;

$api = new Api('rzp_test_D1pqgSP84KBqi2', 'V6tmEcwWviRzzSwg9BNXkt08'); // Replace with your API keys

// Get booking details from the form
$room_no = $_POST['room_no'];
$price = $_POST['price'];
$total_price = $_POST['total_price']; // This will be calculated by the client-side code

// Create Razorpay order
$orderData = [
    'receipt' => rand(1000, 9999),
    'amount' => $total_price * 100, // Amount in paise
    'currency' => 'INR',
    'payment_capture' => 1
];

$order = $api->order->create($orderData);

// Return the order details to the front-end
echo json_encode($order);
?>
