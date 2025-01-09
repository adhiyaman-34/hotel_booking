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

// Handle Room Status Toggle (Booked/Unbooked)
if (isset($_GET['toggle_booking_id'])) {
    $room_id = $_GET['toggle_booking_id'];

    // Toggle room status: If the room is booked (status = 1), set to unbooked (status = 0)
    // If the room is unbooked (status = 0), set to booked (status = 1)
    $sql = "UPDATE add_room SET room_status = IF(room_status = 1, 0, 1) WHERE id = $room_id";
    if ($conn->query($sql) === TRUE) {
        $message = "Room booking status updated successfully.";
    } else {
        $message = "Error updating room status: " . $conn->error;
    }
}

// Query to fetch room details
$sql = "SELECT * FROM add_room";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SmartStay - Manage Rooms</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* Your existing styles here */

    .sidebar {
        width: 250px;
        background-color: #f8f9fa;
        border-right: 1px solid #ddd;
        padding: 15px;
        height: 100vh;
        position: fixed; /* Make the sidebar fixed */
        top: 0;
        left: 0;
    }

    .sidebar h2 {
        font-size: 24px;
        color: #0056d2;
        margin-bottom: 20px;
    }

    .sidebar a {
        display: block;
        padding: 10px 15px;
        margin: 10px 0;
        text-decoration: none;
        color: #333;
        background-color: #f8f9fa;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .sidebar a:hover, .sidebar a.active {
        background-color: #0056d2;
        color: white;
    }

    .logout {
        color: #333;
        background-color: #f8f9fa;
        border: none;
        padding: 10px 15px 10px 25px;
        margin: 10px 0;
        border-radius: 8px;
        width: 100%;
        text-align: left;
        font-size: 16px;
        cursor: pointer;
        margin-top: auto;
        display: flex;
        align-items: center;
        transition: background-color 0.3s;
    }

    .logout:hover {
        background-color: #f1f1f1;
    }

    .main-content {
        padding: 30px;
    }

    .main-content h1 {
        font-size: 28px;
        margin-bottom: 20px;
        color: #333;
    }

    .room-table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        border: 1px solid #e0e0e0;
    }

    .room-table th, .room-table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .room-table th {
        background-color: #e6f3ff;
        color: #0056d2;
    }

    .room-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .add-room-btn, .action-btn {
        background-color: #0056d2;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin: 20px 0;
        font-size: 14px;
        transition: background-color 0.3s;
    }

    .add-room-btn:hover, .action-btn:hover {
        background-color: #004bb5;
    }

    .action-btn {
        margin-right: 10px;
    }
    /* Fix layout for sidebar and content */
    body {
        display: flex;
        margin: 0;
    }

    .main-content {
        flex: 1;
        padding-left: 270px; /* Add extra space for sidebar */
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
        <h2>Smart Stay</h2>
        <a href="owner_dashboard.php">Dashboard</a>
        <a href="edit_room.php"class="active">Manage Rooms</a>
        <a href="Manage_bookin.php">Manage Bookings</a>
        <a href="list of user.php">Message</a>
        <a href="admin_feedback.php">View feedback</a>
        <a href="login.php">Log Out</a>
    </div>

  <!-- Main content -->
  <main class="main-content">
    <h1>Room Management</h1>
    <button class="add-room-btn" onclick="window.location.href='add_room.php'">Add New Room</button>

    <?php if (isset($message)) { echo "<div class='alert alert-info'>$message</div>"; } ?>

    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Room No</th>
            <th>Image</th>
            <th>Type</th>
            <th>Price</th>
            <th>Bed</th>
            <th>WiFi</th>
            <th>Capacity</th>
            <th>Room Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Display rooms in a table if there are any results
          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  // Determine the booking status and button text
                  $button_text = ($row['room_status'] == 1) ? "Unbooked" : "Booked";
                  $button_class = ($row['room_status'] == 1) ? "btn-danger" : "btn-success";
                  
                  echo "<tr>";
                  echo "<td>" . $row['room_no'] . "</td>";
                  echo "<td><img src='" . $row['image'] . "' alt='" . $row['room_no'] . "' style='width: 100px; height: 100px; object-fit: cover;'></td>";
                  echo "<td>" . $row['type'] . "</td>";
                  echo "<td>" . $row['price'] . "</td>";
                  echo "<td>" . $row['bed'] . "</td>";
                  echo "<td>" . $row['wifi'] . "</td>";
                  echo "<td>" . $row['capacity'] . "</td>";
                  echo "<td>" . (($row['room_status'] == 1) ? "Booked" : "Unbooked") . "</td>";
                  echo "<td>";
                  echo "<a href='?toggle_booking_id=" . $row['id'] . "' class='btn $button_class'>$button_text</a>";
                  echo "<a href='?delete_id=" . $row['id'] . "' class='btn btn-danger action-btn' style='margin-left: 10px;'>Delete</a>";
                  echo "</td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='9'>No rooms available.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </main>
</body>
</html>
