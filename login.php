<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["email"];
    $password = $_POST["password"];

    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "hoteldb";

    // Create connection
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Use prepared statements for security
    $stmt = $conn->prepare("SELECT * FROM signup WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // User authenticated
        $userInfo = $result->fetch_assoc();
        $_SESSION["logged_in"] = true;
        $_SESSION['user_id'] = $userInfo['id'];

        // Redirect based on username
        if ($username === "admin@gmail.com") {
            header("Location: owner_dashboard.php");
        } else {
            header("Location: user_dashboard.php");
        }
        exit();
    } else {
        // Invalid credentials
        echo "<script>alert('Invalid username or password.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stay Smart - Login</title>
    <style>
        /* Add your CSS here */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
        }

        .container {
            display: flex;
            width: 800px;
            height: 500px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }

        .left-box {
            flex: 1;
            background-image: url('login bg.png'); /* Replace with your image path */
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
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

        .login-box {
            flex: 1;
            padding: 40px;
            background-color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-box h2 {
            font-size: 1.8em;
            margin-bottom: 20px;
            color: #333;
        }

        .login-box label {
            color: #333;
            font-size: 0.9em;
        }

        .login-box input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .login-box button {
            width: 100%;
            padding: 12px;
            border: none;
            background-color: #3f51b5;
            color: white;
            font-size: 1em;
            border-radius: 5px;
            cursor: pointer;
        }

        .signup-link {
            margin-top: 15px;
            text-align: center;
            font-size: 0.9em;
        }

        .signup-link a {
            color: #3f51b5;
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
        <div class="login-box">
            <h2>Login Account</h2>
            <form action="login.php" method="post">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Email" required>
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter password" required>
                
                <button type="submit">Login</button>
            </form>
            <p class="signup-link">
                Don't have an account? <a href="signup.php">Create Account</a>
            </p>
        </div>
    </div>
</body>
</html>
