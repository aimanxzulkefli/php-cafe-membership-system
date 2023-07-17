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
    $dbname = "cafe_membership";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $membershipId = $_SESSION["userid"];

    // Fetch membership information from the database
    $membershipSql = "SELECT * FROM memberships WHERE membershipid = '$membershipId'";
    $result = $conn->query($membershipSql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $balance = $row["balance"];
        $status = $row["status"];
    }

    if(isset($_POST["user_pay"])){
        if ($balance >= ($status == 'Paid' ? 0 : 15) && $status == 'Unpaid') {
            // Update membership table
            $updateMembershipSql = "UPDATE memberships SET status = 'Paid', balance = balance - 15 WHERE membershipid = '$membershipId'";
            $conn->query($updateMembershipSql);
        
            // Update payment table
            $updatePaymentSql = "UPDATE payment SET fee = 0, status = 'Paid', balance = balance - 15 WHERE paymentid = '$membershipId'";
            $conn->query($updatePaymentSql);
        
            // Update the balance variable
            $balance -= 15;
        
            echo '<script>alert("Payment successful.");</script>';
            echo '<script>window.location.href = "userBill.php";</script>';
        } else if ($status == 'Paid') {
            echo '<script>alert("Payment has already been made.");</script>';
        } else {
            echo '<script>alert("Balance is insufficient for payment.");</script>';
        }
    }

    $conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bill</title>
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

        .bill-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .bank-card {
            width: 500px;
            height: 280px;
            background-color: #f0f0f0;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .bank-card h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        .bill-info {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            width: 100%;
            max-width: 600px;
        }


        .bill-info-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 20px;
            border-radius: 5px;
            flex: 1;
        }

        .bill-info-label {
            font-size: 20px;
            font-weight: bold;
        }

        .bill-info-value {
            font-size: 30px;
            margin-top: 5px;
        }

        .topup-pay-button {
            display: flex;
            justify-content: center;
            width: 100%;
            max-width: 400px;
            margin-top: 20px;
        }

        .topup-pay-button button {
            padding: 10px 20px;
            background-color: #1877f2;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin: 0 10px;
            font-size:16px;
        }

        .topup-pay-button button:hover {
            background-color: #1565c0;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 300px;
            max-width: 80%;
            text-align: center;
            border-radius: 5px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .modal p {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .modal input[type="number"] {
            padding: 5px;
            width: 100%;
            border-radius: 3px;
            border: 1px solid #ccc;
        }

        .modal button {
            padding: 10px 20px;
            background-color: #1877f2;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        .modal button:hover {
            background-color: #1565c0;
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
        <h1>Bill</h1>
        <div class="bill-container">
            <div class="bank-card">
                <h2>Membership Card</h2>
                <!-- Add bank card information or image here -->
            </div>
            <div class="bill-info">
                <div class="bill-info-item">
                    <span class="bill-info-label">Balance</span>
                    <span class="bill-info-value"><?php echo $balance; ?></span>
                </div>
                <div class="bill-info-item">
                    <span class="bill-info-value"><?php echo $status; ?></span>
                </div>
                <div class="bill-info-item">
                    <span class="bill-info-label">Fee</span>
                    <span class="bill-info-value"><?php echo ($status == 'Paid') ? '0' : '15'; ?></span>
                </div>
            </div>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="topup-pay-button">
                    <button type="button" onclick="openTopUpModal()">Top Up</button>
                    <button type="submit" name="user_pay">Pay</button>
                </div>
            </form>
        </div>

        <div id="topUpModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeTopUpModal()">&times;</span>
                <p>Enter the top-up amount:</p>
                <input type="number" id="topUpAmount" placeholder="Enter amount" min="1" required>
                <button onclick="confirmTopUp()">Top Up</button>
            </div>
        </div>

    </main>

    <script>
        function openTopUpModal() {
            document.getElementById("topUpModal").style.display = "block";
        }

        function closeTopUpModal() {
            document.getElementById("topUpModal").style.display = "none";
        }

        function confirmTopUp() {
            // Retrieve the top-up amount from the input field
            var topUpAmount = parseInt(document.getElementById("topUpAmount").value);

            // Check if the input is a valid integer
            if (Number.isInteger(topUpAmount) && topUpAmount > 0) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "topup.php", true); // Replace "topup.php" with the actual PHP script to handle the top-up process
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // Update the balance and handle the top-up process accordingly
                        var response = xhr.responseText;
                        if (response === "success") {
                            closeTopUpModal();
                            alert("Top-up successful.");
                            window.location.href = "userBill.php";
                        } else {
                            // Top-up failed
                            alert("Top-up failed. Please try again.");
                        }
                    }
                };
                xhr.send("amount=" + topUpAmount);
            } else {
                alert("Invalid input. Please enter a valid integer amount.");
            }
        }
    </script>

    <footer>
        <p>&copy; 2023 Cafe Membership System. All rights reserved.</p>
    </footer>
</body>
</html>
