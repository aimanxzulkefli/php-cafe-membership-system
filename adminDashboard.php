<?php

    session_start();
    // Check if the user is logged in
    if (!isset($_SESSION["userid"])) {
        header("Location: login.php"); // Redirect to login page if not logged in
        exit();
    }
    
    $servername = "localhost";
    $username = "root";
    $password = "";

    $conn = new mysqli($servername, $username, $password, "cafe_membership");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . $conn->connect_error);
    }else {

        // Count the number of members
        $countSql = "SELECT COUNT(*) as totalMembers FROM memberships";
        $countResult = $conn->query($countSql);
        $row = $countResult->fetch_assoc();
        $totalMembers = $row['totalMembers'];
        

        // Get the count of paid and unpaid members
        $paidSql = "SELECT COUNT(*) as totalPaid FROM memberships WHERE status = 'Paid'";
        $paidResult = $conn->query($paidSql);
        $paidRow = $paidResult->fetch_assoc();
        $totalPaid = $paidRow['totalPaid'];

        $unpaidSql = "SELECT COUNT(*) as totalUnpaid FROM memberships WHERE status = 'Unpaid'";
        $unpaidResult = $conn->query($unpaidSql);
        $unpaidRow = $unpaidResult->fetch_assoc();
        $totalUnpaid = $unpaidRow['totalUnpaid'];

        $conn->close();
    }    
 ?>   

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
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

        .content-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            height :50vh;
        }

        .membership-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-right: 20px;
        }

        .number {
            font-size: 100px;
            margin:24px 0px;
        }

        .text {
            font-size: 24px;
        }

        .pie-container {
            display: flex;
            align-items: center;
            margin-left: 20px;
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
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>
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

    <div class="content-container">
        <div class="membership-container">
            <?php
                echo '<h1 class="number">' . $totalMembers . '</h1>';
            ?>
            <h3 class="text">membership</h3>
        </div>
        <div class="pie-container">
            <div id="chart" class="pie-chart"></div>
        </div>
    </div>
    <footer>
        <p>&copy; 2023 Cafe Membership System. All rights reserved.</p>
    </footer>
    <script>
        var options = {
            series: [<?php echo $totalPaid; ?>, <?php echo $totalUnpaid; ?>],
            labels: ['Paid', 'Unpaid'],
            chart: {
                type: 'pie',
                width: '400px', 
                height: '400px',
            },
            colors: ['#008000', '#ff0000'], 
            legend: {
                fontSize: '16px',
            }
        };

        var chart = new ApexCharts(document.querySelector('#chart'), options);
        chart.render();

    </script>
    
</body>
</html>