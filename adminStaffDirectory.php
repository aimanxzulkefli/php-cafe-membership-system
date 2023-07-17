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
  <title>Staff Directory</title>
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

        footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }


    </style>
</head>
<body>
    <div class="header">
        <ul class="nav">
            <li><a href="adminDashboard.php">Dashboard</a></li>
            <li><a href="adminUserDashboard.php">User</a></li>
            <li><a href="adminPayment.php">Payment</a></li>
            <li><a href="adminAbout.php">About</a></li>
            <li><a href="adminStaffDirectory.php">Staff Directory</a></li>
            <li><a href="adminPolicy.php">Website Policy</a></li>
            <li class="logout"><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <main>
        <h1>Staff Directory</h1>
        <p>This page displays the staff directory of the Membership System.</p>
    </main>
    <footer>
        <p>&copy; 2023 Cafe Membership System. All rights reserved.</p>
    </footer>
</body>
</html>
