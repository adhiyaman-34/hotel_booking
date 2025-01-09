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

// Query to fetch room data
$sql = "SELECT * FROM user_roomedit";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SmartStay - Manage Rooms</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Inter', sans-serif;
    }

    body {
      display: flex;
      min-height: 100vh;
      background-color: #f8f9fa;
      color: #333;
    }

    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 30px;
      background-color: #fff;
      border-bottom: 1px solid #e0e0e0;
      position: fixed;
      top: 0;
      width: calc(100% - 250px);
      z-index: 1000;
      margin-left: 250px;
    }

    .logo {
      font-size: 24px;
      color: #0056d2;
      font-weight: bold;
    }

    .user-info {
      font-size: 16px;
      color: #555;
    }

    .sidebar {
      width: 250px;
      background-color: #ffffff;
      padding: 20px;
      border-right: 1px solid #e0e0e0;
      position: fixed;
      top: 0;
      bottom: 0;
    }

    .sidebar h2 {
      font-size: 18px;
      color: #333;
      margin-bottom: 20px;
      padding-left: 5px;
    }

    .menu-item {
      color: #333;
      background-color: #f8f9fa;
      border: none;
      padding: 10px 20px;
      margin-bottom: 10px;
      border-radius: 8px;
      width: 100%;
      text-align: left;
      font-size: 14px;
      cursor: pointer;
      display: flex;
      align-items: center;
      transition: background-color 0.3s;
    }

    .menu-item:hover, .menu-item.active {
      background-color: #e6f3ff;
      color: #0056d2;
    }

    .menu-item i {
      margin-right: 10px;
    }

    .logout {
      color: #555;
      background-color: #fff;
      border: 1px solid #ddd;
      padding: 10px 20px;
      border-radius: 8px;
      width: 100%;
      text-align: left;
      font-size: 14px;
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
      flex: 1;
      padding: 30px;
      margin-top: 70px;
      margin-left: 250px;
    }

    .main-content h1 {
      font-size: 28px;
      margin-bottom: 20px;
      color: #333;
    }

    
  </style>
</head>
<body>
  <aside class="sidebar">
    <h2>Smart Stay</h2>
    <button class="menu-item" onclick="window.location.href='dashboard.html'">Dashboard</button>
    <button class="menu-item active" onclick="window.location.href='managerooms.html'">Manage Rooms</button>
    <button class="menu-item" onclick="window.location.href='managebookings.html'">Manage Bookings</button>
    <button class="menu-item" onclick="window.location.href='managepayments.html'">Manage Payments</button>
    <button class="menu-item" onclick="window.location.href='viewfeedback.html'">View Feedback</button>
    <button class="logout">Log Out</button>
  </aside>

  <header class="navbar">
    <div class="user-info">Manage Rooms</div>
  </header>

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
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Display rooms in a table if there are any results
          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  echo "<tr data-id='" . $row['id'] . "'>";
                  echo "<td>" . htmlspecialchars($row['room_no']) . "</td>";
                  echo "<td><img src='" . htmlspecialchars($row['image']) . "' alt='Room Image' width='100'></td>";
                  echo "<td>" . htmlspecialchars($row['type']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['price']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['bed']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['wifi']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['capacity']) . "</td>";
                  echo "<td><a href='' class='btn btn-primary'>Edit</a><a href='?delete_id=" . $row['id'] . "' class='btn btn-danger ms-2'>Delete</a></td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='8'>No rooms available.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </main>
</body>
</html>
