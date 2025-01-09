<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stay Smart</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #ffff;
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            background-color: #fff;
            padding: 20px;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 20px;
        }

        .navbar .logo h2 {
            color: #4f6dff;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 3rem;
        }

        .navbar .menu a {
            color: #333;
            text-decoration: none;
            margin-right: 40px;
            font-weight: 600;
            font-size: 20px;
        }

        .navbar .login {
            background-color: #4f6dff;
            color: #fff;
            padding: 8px 20px;
            border-radius: 5px;
            text-decoration: none;
        }

        .main-content {
            display: flex;
            margin-top: 20px;
            height: 400px;
            flex-wrap: wrap;
        }

        .text-content {
            flex: 1;
            margin-top: 0px;
            padding-right: 20px;
        }

        .text-content h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 10px;
        }

        .text-content p {
            color: #666;
            margin-bottom: 40px;
            font-size: 1.2rem;
            width: 50%;
        }

        .text-content .show-more {
            display: inline-block;
            background-color: #4f6dff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            font-size: 0.9rem;
        }

        .image-content {
            flex: 1;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .image-content img {
            width: 90%;
            height: 90%;
            border-radius: 15px;
        }

        .features {
            display: flex;
            flex-wrap: wrap;
            margin-top: 20px;
            color: #999;
            font-size: 0.9rem;
        }

        .features div {
            display: flex;
            align-items: center;
            margin-right: 20px;
            margin-left: 51%;
            font-size: 20px;
        }

        .features img {
            width: 24px;
            margin-right: 10px;
            margin-left: 20px;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 40px;
            color: #666;
            font-size: 1rem;
            flex-wrap: wrap;
        }

        .footer .text-content h2 {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
            margin-left: 37%;
            margin-bottom: 5px;
        }

        .footer .text-content p {
            color: #666;
            font-size: 0.9rem;
            margin-left: 37%;
        }

        .owner {
            display: flex;
            flex-direction: column;
        }

        .owner p {
            padding: 10px;
            color: black;
            font-weight: 700;
        }

        .owner a {
            background-color: #4f6dff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            text-align: center;
            font-weight: bold;
            font-size: 1rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .copyright {
            text-align: center;
            margin-top: 20px;
            color: #999;
            font-size: 0.8rem;
        }

        /* Popup styles */
        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .popup .popup-content {
            background-color: #fff;
            padding: 30px;
            width: 80%;
            max-width: 800px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .popup .popup-content h3 {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .popup .popup-content p {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .popup .popup-content .contact-details {
            margin-top: 20px;
        }

        .popup .popup-content .contact-details a {
            color: #4f6dff;
            text-decoration: none;
            font-size: 1.2rem;
            display: block;
            margin: 10px 0;
            transition: color 0.3s;
        }

        .popup .popup-content .contact-details a:hover {
            color: #3659b1;
        }

        .popup .popup-content .contact-details .icon {
            margin-right: 15px;
            font-size: 1.4rem;
        }

        .popup .popup-content .popup-buttons {
            margin-top: 20px;
        }

        .popup .popup-content .popup-buttons button {
            background-color: #4f6dff;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            margin-top: 20px;
            transition: all 0.3s ease;
        }

        .popup .popup-content .popup-buttons button:hover {
            background-color: #3659b1;
        }

        .close-popup {
            background-color: #f44336;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            margin-top: 20px;
            transition: all 0.3s ease;
        }

        .close-popup:hover {
            background-color: #d32f2f;
        }

    </style>
</head>
<body>

<div class="container">
    <div class="navbar">
        <div class="logo"><h2>Stay Smart</h2></div>
        <div class="menu">
            <a href="#">Home</a>
            <a href="javascript:void(0);" onclick="openAboutPopup()">About</a>
            <a href="javascript:void(0);" onclick="openContactPopup()">Contact</a>
            <a href="login.php" class="login">Login</a>
        </div>
    </div>

    <div class="main-content">
        <div class="text-content">
            <h1>Forget Busy Work, Start Next Vacation</h1>
            <p>Discover everything you need to create the perfect holiday with your loved ones, where every moment is filled with joy, laughter, and togetherness. Let us help you craft unforgettable experiences that you’ll cherish for a lifetime. From breathtaking destinations to tailored activities, we ensure every detail is perfect for your family. It’s time to turn your family getaway into another cherished chapter of memories—one that will be retold and relived for years to come!</p>
            <a href="#" class="show-more">Explore World</a>
        </div>
        <div class="image-content">
            <img src="home page bg.png" alt="Vacation Image">
        </div>
    </div>

    <div class="features">
        <div><img src="user_icon.png" alt="icon"> 40 Users
        <img src="review_icon.jpg" alt="icon"> 30 Reviews</div>
    </div>

    <div class="footer">
        <p class="copyright">Copyright © 2024 • All rights reserved • Salman Faris</p>
        <div class="text-content">
            <h2>Owner</h2>
            <p>Salman Faris</p>
        </div>
    </div>
</div>

<!-- About Popup -->
<div class="popup" id="about-popup">
    <div class="popup-content">
        <h3>About Stay Smart</h3>
        <p>Stay Smart is your go-to platform for curating the perfect vacation experience. We specialize in creating seamless travel solutions tailored to your needs. Whether you’re traveling with family, friends, or solo, our platform ensures that every aspect of your trip is well-organized, from booking hotels to arranging activities and excursions.</p>
        <div class="popup-buttons">
            <button onclick="closeAboutPopup()">Close</button>
        </div>
    </div>
</div>

<!-- Contact Popup -->
<div class="popup" id="contact-popup">
    <div class="popup-content">
        <h3>Contact Us</h3>
        <div class="contact-details">
            <p>Email: <a href="mailto:contact@staysmart.com"><span class="icon">📧</span> contact@staysmart.com</a></p>
            <p>Instagram: <a href="https://instagram.com/StaySmart" target="_blank"><span class="icon">📸</span> @StaySmart</a></p>
            <p>Phone: <a href="tel:+1234567890"><span class="icon">📞</span> +1 234 567 890</a></p>
            <p>Twitter: <a href="https://twitter.com/StaySmart" target="_blank"><span class="icon">🐦</span> @StaySmart</a></p>
            <p>Facebook: <a href="https://facebook.com/StaySmart" target="_blank"><span class="icon">📘</span> StaySmart</a></p>
            <p>LinkedIn: <a href="https://linkedin.com/company/StaySmart" target="_blank"><span class="icon">🔗</span> StaySmart</a></p>
        </div>
        <div class="popup-buttons">
            <button onclick="closeContactPopup()">Close</button>
        </div>
    </div>
</div>

<script>
    function openAboutPopup() {
        document.getElementById('about-popup').style.display = 'flex';
    }

    function closeAboutPopup() {
        document.getElementById('about-popup').style.display = 'none';
    }

    function openContactPopup() {
        document.getElementById('contact-popup').style.display = 'flex';
    }

    function closeContactPopup() {
        document.getElementById('contact-popup').style.display = 'none';
    }
</script>

</body>
</html>
