<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SmartStay - Explore Jolarpettai</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #C6CDFF;
    }

    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 30px;
      background-color: #0056d2;
      color: white;
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 1000;
    }

    .navbar h2 {
      font-size: 24px;
      color: white;
    }

    .navbar nav {
      display: flex;
      gap: 15px;
    }

    .navbar a {
      text-decoration: none;
      color: white;
      padding: 10px 15px;
      border-radius: 5px;
      transition: background-color 0.3s;
      font-size: 14px;
    }

    .navbar a:hover, .navbar a.active {
      background-color: #003c99;
    }

    .welcome-section {
      background-image: url('traveling-with-family.jpg');
      background-size: cover;
      background-position: center;
      color: white;
      text-align: center;
      padding: 100px 20px;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }

    .welcome-section h1 {
      font-size: 2.5rem;
      font-weight: bold;
      text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.4);
    }

    .welcome-section p {
      font-size: 1.2rem;
      text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.4);
    }

    .hotel-image {
      width: 100%;
      border-radius: 8px;
    }

    .card img {
      height: 200px;
      object-fit: cover;
      border-radius: 8px;
    }

    .tourist-card {
      background-size: cover;
      background-position: center;
      color: white;
      text-align: center;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
      padding: 20px;
    }

    .tourist-card h3 {
      font-size: 1.5rem;
      text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.4);
    }

    .tourist-card p {
      font-size: 1rem;
      text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.4);
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <header class="navbar">
    <h2>Stay Smart</h2>
    <nav>
      <a href="user_dashboard.php" class="active">Dashboard</a>
      <a href="my_bookings.php">My Bookings</a>
      <a href="select_room.php">Book My Stay</a>
      <a href="chat_user.php">Chat Your Need</a>
      <a href="review.php">Review</a>
      <a href="homepage.php">Log Out</a>
    </nav>
  </header>

  <!-- Main Content -->
  <div class="container mt-5 pt-5">
    <!-- Welcome Section -->
    <section class="welcome-section mb-5">
      <h1>Welcome to Your Ultimate Travel Experience</h1>
      <p>Explore the vibrant beauty of city and the surrounding attractions. We’re here to make your stay unforgettable!</p>
    </section>

    <!-- Hotel Section with Features -->
    <section class="row align-items-center bg-white p-4 shadow rounded mb-5">
      <div class="col-md-6">
        <div id="hotelCarousel" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="hotel1.jpeg" class="d-block w-100 hotel-image" alt="Hotel Exterior">
            </div>
            <div class="carousel-item">
              <img src="hotel2.jpeg" class="d-block w-100 hotel-image" alt="Hotel Lobby">
            </div>
            <div class="carousel-item">
              <img src="hotel3.webp" class="d-block w-100 hotel-image" alt="Hotel Room">
            </div>
            <div class="carousel-item">
              <img src="hotel4.webp" class="d-block w-100 hotel-image" alt="Hotel Dining Area">
            </div>
            <div class="carousel-item">
              <img src="hotel5.jpeg" class="d-block w-100 hotel-image" alt="Hotel Pool">
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#hotelCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#hotelCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
      <div class="col-md-6">
        <h2>Welcome to SmartStay Hotel</h2>
        <p>Located in the heart of city, SmartStay offers luxurious accommodations, exceptional amenities, and unparalleled service. Whether you are traveling for business or leisure, we are here to provide you with the ultimate comfort and convenience during your stay.</p>
        
        <!-- Features Section -->
        <h4 class="mt-4">Features</h4>
        <ul class="list-unstyled">
          <li>🌊 Swimming Pool - Relax and unwind in our outdoor pool.</li>
          <li>🚗 Car Parking - Secure and spacious parking available.</li>
          <li>🍽️ On-site Restaurant - Enjoy local and international cuisine.</li>
          <li>🏋️‍♂️ Fitness Center - State-of-the-art gym for your fitness needs.</li>
          <li>📶 Free Wi-Fi - Stay connected during your stay.</li>
        </ul>
      </div>
    </section>

    <!-- Tourist Spots Section -->
    <section>
      <h1 class="text-center text-primary mb-4">Tourist Spots Near Us</h1>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card tourist-card" style="background-image: url('yelagiri.jpeg');">
            <h3>Yelagiri Hills</h3>
            <p>Distance: 25 km</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card tourist-card" style="background-image: url('ooty.jpeg');">
            <h3>Ooty Rose Garden</h3>
            <p>Distance: 335 km</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card tourist-card" style="background-image: url('marina.jpeg');">
            <h3>Marina Beach, Chennai</h3>
            <p>Distance: 250 km</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card tourist-card" style="background-image: url('goldentemple.jpeg');">
            <h3>Golden Temple, Vellore</h3>
            <p>Distance: 80 km</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card tourist-card" style="background-image: url('KRP_dam.jpeg');">
            <h3>KRP Dam, Krishnagiri</h3>
            <p>Distance: 125 km</p>
          </div>
        </div>
        <!-- New Tourist Spot -->
        <div class="col-md-4">
          <div class="card tourist-card" style="background-image: url('vellorefort.jpeg');">
            <h3>Vellore Fort</h3>
            <p>Distance: 75 km</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Transport Facilities Section -->
    <section class="mt-5">
      <h1 class="text-center text-primary mb-4">Transport Facilities</h1>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card shadow h-100">
            <img src="railway_station.jpeg" class="card-img-top" alt="Railway Station">
            <div class="card-body text-center">
              <h3 class="card-title">Railway Station</h3>
              <p>Distance: 3 km</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card shadow h-100">
            <img src="airport.jpeg" class="card-img-top" alt="Airport">
            <div class="card-body text-center">
              <h3 class="card-title">Airport</h3>
              <p>Distance: 170 km</p>
            </div>
          </div>
        </div>
        <!-- New Bus Stand -->
        <div class="col-md-4">
          <div class="card shadow h-100">
            <img src="busstand.jpg" class="card-img-top" alt="Bus Stand">
            <div class="card-body text-center">
              <h3 class="card-title">Bus Stand</h3>
              <p>Distance: 5 km</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  
  <script src="https://cdn.botpress.cloud/webchat/v2.2/inject.js"></script>
<script src="https://files.bpcontent.cloud/2024/11/22/06/20241122060815-OEX3ZWOJ.js"></script>
    
</body>
</html>

