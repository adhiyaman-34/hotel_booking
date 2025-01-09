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

// Get the room number from the URL
$room_no = isset($_GET['room_no']) ? $_GET['room_no'] : '';

// Query to fetch room data based on room_no
$sql = "SELECT * FROM add_room WHERE room_no = '$room_no'";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

// Check if room is found
$room = $result->fetch_assoc();
if (!$room) {
    die("Room not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Stay - Booking</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .room-details img {
            width: 100%;
            max-width: 400px;
            border-radius: 8px;
        }
        .room-details h3 {
            color: #333;
        }
        .room-details p {
            color: #555;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .btn-book {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-book:hover {
            background-color: #0056b3;
        }
        .total-price {
            margin-top: 20px;
            font-size: 18px;
            color: #333;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Booking Information</h1>
        
        <div class="room-details">
            <img src="<?php echo htmlspecialchars($room['image']); ?>" alt="Room Image">
            <h3>Room No: <?php echo htmlspecialchars($room['room_no']); ?></h3>
            <p><strong>Price:</strong> ₹<?php echo htmlspecialchars($room['price']); ?> per night</p>
        </div>

        <form id="booking-form" action="process_booking.php" method="POST">
            <input type="hidden" name="room_no" value="<?php echo htmlspecialchars($room['room_no']); ?>">
            <input type="hidden" name="price" value="<?php echo htmlspecialchars($room['price']); ?>">

            <div class="form-group">
                <label for="check_in">Check-in Time</label>
                <input type="time" name="check_in" required>
            </div>

            <div class="form-group">
                <label for="start_date">Pick a Start Date</label>
                <input type="date" name="start_date" id="start_date" required>
            </div>

            <div class="form-group">
                <label for="end_date">Pick an End Date</label>
                <input type="date" name="end_date" id="end_date" required>
            </div>

            <div class="total-price">
                <p>Total Price: ₹<span id="total-price">0</span></p>
            </div>

            <button type="submit" class="btn-book">PAY Now</button>
        </form>
    </div>

    <script>
        // Function to calculate the number of days and total price
        function calculateTotalPrice() {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;
            const pricePerDay = <?php echo $room['price']; ?>;

            if (startDate && endDate) {
                const start = new Date(startDate);
                const end = new Date(endDate);
                const timeDifference = end - start;

                if (timeDifference >= 0) {
                    const numberOfDays = timeDifference / (1000 * 3600 * 24) + 1; // Convert time difference to days
                    const totalPrice = numberOfDays * pricePerDay;
                    document.getElementById('total-price').textContent = totalPrice;
                } else {
                    alert("End date must be later than start date");
                }
            }
        }

        // Event listeners to calculate total price when dates are selected
        document.getElementById('start_date').addEventListener('change', calculateTotalPrice);
        document.getElementById('end_date').addEventListener('change', calculateTotalPrice);
    </script>
</body>
</html>
