<?php
$servername = "localhost";
$username = "root"; // Update if necessary
$password = ""; // Update if necessary
$dbname = "hoteldb"; // Update with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get booking details from the URL
$total_price = isset($_GET['total_price']) ? $_GET['total_price'] : 0;
$room_no = isset($_GET['room_no']) ? $_GET['room_no'] : 0;
$name = isset($_GET['name']) ? $_GET['name'] : '';
if ($total_price <= 0 || $room_no <= 0) {
    die("Invalid booking details. Please try again.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Stay - Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:  #fff;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .logo {
            font-family: 'italianno', sans-serif;
            font-size: 36px;
            color: #ff1e00;
            font-weight: bold;
        }

        .logo span {
            font-family: 'italianno', sans-serif;
            font-size: 36px;
            color: #fff;
            font-weight: bold;
        }

        .payment-container {
            background-color: #000080;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 400px;
        }

        .payment-container h1 {
            color: #fff;
            margin-bottom: 20px;
        }

        .payment-container p {
            color: #fff;
            margin: 10px 0;
        }

        .pay-now-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #fff;
            color: #0000806;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 20px;
            text-decoration: none;
        }

        .pay-now-btn:hover {
            background-color: #ff2727;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
    <div class="payment-container">
        <h1>Complete Your Payment</h1>
        <!-- <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p> -->
        <p><strong>Total Amount:</strong> ₹<?php echo number_format($total_price, 2); ?></p>
        <button class="pay-now-btn" id="payNow">Pay Now</button>
    </div>

    <script>
        document.getElementById('payNow').addEventListener('click', function (e) {
            var options = {
                "key": "rzp_test_v2uhLO9KDz3sx0", // Replace with your Razorpay API key
                "amount": <?php echo $total_price * 100; ?>, // Amount in paise
                "currency": "INR",
                "name": "Smart Stay",
                "description": "Smart Stay Booking Payment",
                "handler": function (response) {
                    // Send the payment details to the server
                    $.ajax({
                        url: 'paymentbk.php',
                        type: 'POST',
                        data: {
                            razorpay_payment_id: response.razorpay_payment_id,
                            room_no: <?php echo $room_no; ?>,
                            total_price: <?php echo $total_price; ?>
                        },
                        success: function (data) {
                            alert("Payment successful!");
                            window.location.href = "my_bookings.php";
                        },
                        error: function () {
                            alert("Payment failed. Please try again.");
                        }
                    });
                },
                "theme": {
                    "color": "#ff1e00"
                }
            };
            var rzp1 = new Razorpay(options);
            rzp1.open();
            e.preventDefault();
        });
    </script>
</body>
</html>