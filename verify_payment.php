<?php
require('razorpay-php/Razorpay.php');


$apiKey = "rzp_test_D1pqgSP84KBqi2"; // Replace with your Razorpay Key ID
$apiSecret = "V6tmEcwWviRzzSwg9BNXkt08"; // Replace with your Razorpay Key Secret

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (isset($data['razorpay_payment_id'])) {
    $api = new Api($apiKey, $apiSecret);

    try {
        $attributes = [
            'razorpay_order_id' => $data['razorpay_order_id'],
            'razorpay_payment_id' => $data['razorpay_payment_id'],
            'razorpay_signature' => $data['razorpay_signature']
        ];

        $api->utility->verifyPaymentSignature($attributes);

        // Save payment details to database
        echo json_encode(['message' => 'Payment verified successfully']);
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode(['message' => 'Payment verification failed', 'error' => $e->getMessage()]);
    }
} else {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid payment data']);
}
?>
