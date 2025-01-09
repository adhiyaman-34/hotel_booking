<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $roomNo = $_POST['room-no'];
    $type = $_POST['type'];
    $price = $_POST['price'];
    $bed = $_POST['bed'];
    $wifi = $_POST['wifi'];
    $capacity = $_POST['capacity'];

    // Handle file upload
    $targetDir = "uploads/";
    $targetFile = $targetDir . uniqid() . "_" . basename($_FILES['room-image']['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if file is an image
    if (getimagesize($_FILES['room-image']['tmp_name']) !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Validate allowed formats
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo "Only JPG, JPEG, PNG, and GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 1 && move_uploaded_file($_FILES['room-image']['tmp_name'], $targetFile)) {
        // Use prepared statement
        $stmt = $conn->prepare("INSERT INTO add_room (room_no, image, type, price, bed, wifi, capacity) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdsss", $roomNo, $targetFile, $type, $price, $bed, $wifi, $capacity);

        if ($stmt->execute()) {
            echo "<script>alert('New room added successfully.'); window.location.href='edit_room.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "There was an error uploading your file.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Room</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            width: 600px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            border-top: 5px solid #007bff;
        }
        h2 {
            color: #007bff;
            text-align: center;
            margin: 0 0 20px;
        }
        label, input, select {
            display: block;
            width: 100%;
            margin: 10px 0;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        input[type="file"] {
            padding: 5px;
            background-color: #f0f0f0;
        }
        .submit-btn {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        .submit-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add Room Details</h2>
        <form action="add_room.php" method="POST" enctype="multipart/form-data">
            <label for="room-no">Room Number:</label>
            <input type="text" name="room-no" placeholder="Enter room number" required>

            <label for="type">Room Type (AC/Non-AC):</label>
            <select name="type" required>
                <option value="AC">AC</option>
                <option value="Non-AC">Non-AC</option>
            </select>

            <label for="price">Price per Day:</label>
            <input type="number" name="price" step="0.01" placeholder="Enter price" required>

            <label for="bed">Bed Type:</label>
            <input type="text" name="bed" placeholder="Enter bed type (e.g., King, Queen)" required>

            <label for="wifi">WiFi Available:</label>
            <select name="wifi" required>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>

            <label for="capacity">Capacity:</label>
            <input type="number" name="capacity" placeholder="Enter number of guests" required>

            <label for="room-image">Room Image:</label>
            <input type="file" name="room-image" accept="image/*" required>

            <button type="submit" class="submit-btn">Add Room</button>
        </form>
    </div>
</body>
</html>
