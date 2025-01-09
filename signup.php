<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hoteldb"; 

$message = "Register successful";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $place = $_POST['place'];
    $user_password = $_POST['password'];  // Updated variable name

    $sql = "INSERT INTO signup (username, email, phone_no, place, password) 
    VALUES('$username','$email','$phone','$place','$user_password')";

    if ($conn->query($sql) === TRUE) {
        echo "<script type='text/javascript'>alert('$message');window.location.href='login.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stay Smart - Signup</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: white; /* Set the background color to white */
        }

        .container {
            display: flex;
            width: 800px;
            height: 700px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            background-color: white; /* Ensure the container has a white background */
        }

        .left-box {
            flex: 1;
            background-image: url('login bg.png'); /* Replace with the path of your uploaded image */
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .overlay {
            background-color: rgba(255, 255, 255, 0.7);
            width: 80%;
            height: 80%;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            text-align: center;
        }

        .overlay h1 {
            color: #3f51b5;
            font-size: 2em;
        }

        .signup-box {
            flex: 1;
            padding: 40px;
            background-color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .signup-box h2 {
            font-size: 1.8em;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        .signup-box label {
            color: #333;
            font-size: 0.9em;
        }

        .signup-box input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .signup-box button {
            width: 100%;
            padding: 12px;
            border: none;
            background-color: #3f51b5;
            color: white;
            font-size: 1em;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .signup-box button:hover {
            background-color: #2c3e9b;
        }

        .signup-link {
            margin-top: 15px;
            text-align: center;
            color: #333;
            font-size: 0.9em;
        }

        .signup-link a {
            color: #3f51b5;
            text-decoration: none;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-box">
            <div class="overlay">
                <h1>Stay Smart</h1>
            </div>
        </div>
        <div class="signup-box">
            <h2>Create Account</h2>
            <form action="" method="post">
                <label for="username">Name</label>
                <input type="text" id="username" name="username" placeholder="Enter your name" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="name@gmail.com" required>

                <label for="phone">Phone No</label>
                <input type="text" id="phone" name="phone" placeholder="With Country Code" required>

                <label for="place">Place</label>
                <input type="text" id="place" name="place" placeholder="Country Name" required>
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="6+ characters" required>

                <button type="submit">Register</button>
            </form>
            <p class="signup-link">
                By signing up you agree to <a href="#">terms and conditions</a>.<br>
                <a href="login.php">Login</a>
            </p>
        </div>
    </div>
</body>
</html>
