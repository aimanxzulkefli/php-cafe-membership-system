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
  <title>Web Site Policy</title>
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
        <h1>Web Site Policy</h1>
        <p>This Privacy Policy governs the manner in which Cafe Membership System collects, uses, maintains, and discloses information collected from users (each, a "User") of the website ("Site"). This privacy policy applies to the Site and all products and services offered by Cafe Membership System..</p>
        <h3>Personal identification information.</h3>
        <p>We may collect personal identification information from Users in a variety of ways, including, but not limited to, when Users visit our site, register on the site, place an order, subscribe to the newsletter, respond to a survey, fill out a form, and in connection with other activities, services, features or resources we make available on our Site. Users may be asked for, as appropriate, name, email address, mailing address, phone number. Users may, however, visit our Site anonymously. We will collect personal identification information from Users only if they voluntarily submit such information to us. Users can always refuse to supply personal identification information, except that it may prevent them from engaging in certain Site-related activities.</p>
        <h3>Non-personal identification information</h3>
        <p>We may collect non-personal identification information about Users whenever they interact with our Site. Non-personal identification information may include the browser name, the type of computer, and technical information about Users' means of connection to our Site, such as the operating system and the Internet service providers utilized and other similar information.</p>
        <h3>Web browser cookies</h3>
        <p>Our Site may use "cookies" to enhance User experience. User's web browser places cookies on their hard drive for record-keeping purposes and sometimes to track information about them. Users may choose to set their web browser to refuse cookies or to alert you when cookies are being sent. If they do so, note that some parts of the Site may not function properly.</p>
        <h3>How we use collected information</h3>
        <p>Cafe Membership System may collect and use Users personal information for the following purposes:</p>
        <p>•	To improve customer service: Information you provide helps us respond to your customer service requests and support needs more efficiently.</p>
        <p>•	To personalize user experience: We may use information in the aggregate to understand how our Users as a group use the services and resources provided on our Site.</p>
        <p>•	To improve our Site: We may use feedback you provide to improve our products and services.</p>
        <p>•	To process payments: We may use the information Users provide about themselves when placing an order only to provide service to that order. We do not share this information with outside parties except to the extent necessary to provide the service.</p>
        <h3>How we use collected information</h3>
        <p>If you have any questions about this Privacy Policy, the practices of this site, or your dealings with this site, please contact us at CaféMembershipSystem@google.com.</p>
        <p>This document was last updated on 23-JUNE-2023.</p>    
    </main>
    <footer>
        <p>&copy; 2023 Cafe Membership System. All rights reserved.</p>
    </footer>
</body>
</html>
