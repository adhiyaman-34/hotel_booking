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

// Fetch total bookings
$totalBookingsQuery = "SELECT COUNT(*) as total FROM bookings";
$totalBookingsResult = $conn->query($totalBookingsQuery);
$totalBookings = $totalBookingsResult->fetch_assoc()['total'];

// Fetch current bookings
$currentBookingsQuery = "SELECT COUNT(*) as total FROM add_room WHERE room_status = '1'";
$currentBookingsResult = $conn->query($currentBookingsQuery);
$currentBookings = $currentBookingsResult->fetch_assoc()['total'];

// Fetch total users
$totalUsersQuery = "SELECT COUNT(*) as total FROM signup";
$totalUsersResult = $conn->query($totalUsersQuery);
$totalUsers = $totalUsersResult->fetch_assoc()['total'];

// Fetch average rating
$averageRatingQuery = "SELECT AVG(rating) as avg_rating FROM feedback";
$averageRatingResult = $conn->query($averageRatingQuery);
$averageRating = round($averageRatingResult->fetch_assoc()['avg_rating'], 2);

// Close connection
$conn->close();

// Calendar Variables
$holidays = [
    "2024-12-25" => "Christmas",
    "2024-12-31" => "New Year's Eve",
    "2024-12-26" => "Boxing Day",
    "2024-01-01" => "New Year",
    "2024-04-10" => "Eid al-Fitr",
    "2024-08-15" => "Independence Day"
];

$currentMonth = date('m'); // Current month
$currentYear = date('Y'); // Current year
$firstDay = strtotime("$currentYear-$currentMonth-01"); // First day of month
$daysInMonth = date('t', $firstDay); // Total days in month
$startDayOfWeek = date('w', $firstDay); // 0 (Sunday) to 6 (Saturday)
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SmartStay - Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
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
      background: url('adminpage_bg.jpg') no-repeat center center fixed;
      background-size: cover;
      color: #333;
    }

    .sidebar {
      width: 250px;
      background-color: #f8f9fa;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      border-right: 1px solid #ddd;
      padding: 20px;
    }

    .sidebar h2 {
      font-size: 34px;
      color: #0056d2;
      margin-bottom: 30px;
    }

    .sidebar a {
      display: block;
      padding: 10px 15px;
      margin: 5px 0;
      text-decoration: none;
      color: #333;
      border-radius: 5px;
    }

    .sidebar a:hover, .sidebar a.active {
      background-color: #0056d2;
      color: #fff;
    }

    .main-content {
      flex: 1;
      padding: 30px;
      margin-left: 250px;
      display: flex;
      flex-direction: column;
    }

    .main-content h1 {
      font-size: 48px;
      margin-bottom: 20px;
      color: #fff;
    }

    .stats {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
    }

    .stat-card {
      background: rgba(255, 255, 255, 0.8);
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .stat-card h2 {
      font-size: 36px;
      color: #0056d2;
      margin-bottom: 10px;
    }

    .stat-card p {
      font-size: 18px;
      color: #333;
    }

    .calendar-container {
      margin-top: 30px;
      padding: 15px;
      width: 50%; /* Reduced width */
      background-color: rgba(255, 255, 255, 0.9);
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      position: relative;
    }

    .calendar {
      display: grid;
      grid-template-columns: repeat(7, 1fr);
      gap: 5px;
      margin-top: 10px;
    }

    .calendar div {
      padding: 10px;
      font-size: 14px;
      height: 70px; /* Fixed height for uniform size */
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      background-color: #f8f9fa;
      border-radius: 5px;
      text-align: center;
    }

    .calendar div.today {
      background-color: #4CAF50;
      color: white;
    }

    .calendar div.holiday {
      background-color: #FFEB3B;
      color: #333;
    }

    .day-header {
      font-weight: bold;
      color: #0056d2;
    }

    /* Digital clock styling */
    .time-container {
      font-size: 50px;
      font-weight: bold;
      position: fixed;
      top: 20px; /* Adjust top spacing */
      right: 20px; /* Adjust right spacing */
      text-align: center;
      color: #fff;
      z-index: 999;
    }

    /* Admin info section */
    .admin-info-container {
      margin-top: 115px; /* Increased margin to bring it down */
      padding: 20px;
      background-color: rgba(255, 255, 255, 0.9);
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      width: 40%;
      position: absolute;
      top: 140px;
      right: 20px;
    }

    .admin-info-container h2 {
      font-size: 20px;
      color: #0056d2;
      margin-bottom: 10px;
    }

    .team-condition ul {
      padding-left: 20px;
    }

    .team-condition li {
      margin-bottom: 10px;
      font-size: 14px;
    }
  </style>
</head>
<body>

<div class="sidebar">
    <h2>Smart Stay</h2>
    <a href="#" class="active">Dashboard</a>
    <a href="edit_room.php">Manage Rooms</a>
    <a href="manage_bookin.php">Manage Bookings</a>
    <a href="list_of_user.php">Messages</a>
    <a href="admin_feedback.php">View Feedback</a>
    <a href="homepage.php">Log Out</a>
</div>

<div class="main-content">
  <h1>Admin Dashboard</h1>
  <div class="stats">
    <div class="stat-card"><h2><?= $totalBookings ?></h2><p>Total Bookings</p></div>
    <div class="stat-card"><h2><?= $currentBookings ?></h2><p>Current Bookings</p></div>
    <div class="stat-card"><h2><?= $totalUsers ?></h2><p>Total Users</p></div>
    <div class="stat-card"><h2><?= $averageRating ?></h2><p>Average Rating</p></div>
  </div>

  <!-- Calendar -->
  <div class="calendar-container">
    <h2>Calendar - <?= date('F Y') ?></h2>
    <div class="calendar">
      <div class="day-header">Sun</div>
      <div class="day-header">Mon</div>
      <div class="day-header">Tue</div>
      <div class="day-header">Wed</div>
      <div class="day-header">Thu</div>
      <div class="day-header">Fri</div>
      <div class="day-header">Sat</div>
      <?php
      for ($i = 0; $i < $startDayOfWeek; $i++) echo "<div></div>";
      for ($day = 1; $day <= $daysInMonth; $day++) {
          $date = "$currentYear-$currentMonth-" . str_pad($day, 2, "0", STR_PAD_LEFT);
          $holidayText = $holidays[$date] ?? '';
          $class = ($date == date('Y-m-d')) ? 'today' : ($holidayText ? 'holiday' : '');
          echo "<div class='$class'>$day<br><small>$holidayText</small></div>";
      }
      ?>
    </div>
  </div>

  <!-- Digital Time -->
  <div class="time-container" id="time"></div>
</div>

<!-- New Section - Hotel Team Condition -->
<div class="admin-info-container">
  <h2>Hotel Notice</h2>
  <div class="team-condition">
    <ul>
      <li>Staff Meeting- Every Friday at 5PM</li>
      <li>Check-in time updated to 12:00 PM</li>
      <li>Deep cleaning scheduled on Every wednesday.</li>
      <li>Staff holidays- Monday</li>
    </ul>
  </div>
</div>

<script>
  function updateTime() {
    const now = new Date();
    let hours = now.getHours();
    let minutes = now.getMinutes().toString().padStart(2, '0');
    let seconds = now.getSeconds().toString().padStart(2, '0');
    let ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    document.getElementById("time").innerText = `${hours}:${minutes}:${seconds} ${ampm}`;
  }
  
  setInterval(updateTime, 1000);
</script>

</body>
</html>
