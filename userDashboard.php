<?php
    session_start();
    // Check if the user is logged in
    if (!isset($_SESSION["userid"])) {
        header("Location: login.php"); // Redirect to login page if not logged in
        exit();
    }
?>
<!DOCTYPE html>
<html>
<head>
  <title>About</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .header {
            background-color: #333;
            color: #fff;
            padding: 10px;
        }

        .nav {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
        }

        .nav li {
            display: inline-block;
            margin-right: 10px;
        }

        .nav li:last-child {
            margin-right: 0;
        }

        .nav a {
            color: #fff;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 3px;
        }

        .nav a:hover {
            background-color: #666;
        }

        .logout a {
            background-color: #f00;
        }

        .logout a:hover {
            background-color: #900;
        }

        .logout a,
        .logout a:hover {
            color: #fff;
        }

        .logout {
            margin-left: auto;
        }

        main {
            padding: 20px;
        }

        h1 {
            font-size: 32px;
        }

        p {
            font-size: 16px;
        }

        
        .promotion-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .promotion-item {
            width: 500px;
            height: 280px;
            background-color: #f0f0f0;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 10px;
            margin-bottom:10px;
        }

        .promotion-item img {
            width: 100%;
            max-width: 100%;
            height: auto;
        }

        @media (max-width: 768px) {
            .promotion-container {
                flex-direction: column; /* Change flex direction to display images vertically */
                align-items: flex-start; /* Adjust alignment for vertical display */
            }

            .promotion-item {
                width: 100%; /* Set the width to 100% for vertical display */
                margin: 0 0 10px; /* Adjust margin for vertical display */
            }
        }

        footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }s


    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="header">
        <ul class="nav">
            <li><a href="userDashboard.php"><i class="fas fa-home"></i></a></li>
            <li><a href="userProfile.php">Profile</a></li>
            <li><a href="userBill.php">Bill</a></li>
            <li><a href="userAbout.php">About</a></li>
            <li><a href="userStaffDirectory.php">Staff Directory</a></li>
            <li><a href="userPolicy.php">Website Policy</a></li>
            <li class="logout"><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <main>
        <h1>Welcome to Cafe Membership System</h1>
        <p>Join our exclusive membership program and enjoy a range of benefits and discounts.</p>
        <div class="promotion-container">
            <div class="promotion-item">
                <img src="image_url_1" alt="Promotion Image 1">
            </div>
            <div class="promotion-item">
                <img src="image_url_2" alt="Promotion Image 2">
            </div>
            <div class="promotion-item">
                <img src="image_url_3" alt="Promotion Image 3">
            </div>
        </div>
    <footer>
        <p>&copy; 2023 Cafe Membership System. All rights reserved.</p>
    </footer>
</body>
</html>
