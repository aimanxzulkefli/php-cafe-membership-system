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
    }

    // Perform search if a query is submitted
    $searchName = $_GET['search_name'] ?? '';
    $searchMembershipID = $_GET['search_membershipid'] ?? '';
    $searchStatus = $_GET['search_status'] ?? '';

    $searchSql = "SELECT p.paymentid, m.fullname, p.balance, p.status, p.fee
              FROM payment p
              INNER JOIN memberships m ON p.paymentid = m.membershipid
              WHERE 1";

    if (!empty($searchName)) {
        $searchSql .= " AND m.fullname LIKE '%$searchName%'";
    }
    if (!empty($searchMembershipID)) {
        $searchSql .= " AND p.paymentid LIKE '%$searchMembershipID%'";
    }
    if (!empty($searchStatus) && $searchStatus !== 'all') {
        $searchSql .= " AND p.status = '$searchStatus'";
    }

    $searchResult = $conn->query($searchSql);

    $conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <style>
        /* CSS styles for the table, search form, etc. */
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

        .content {
            padding: 20px;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 6px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 10px;
        }

        .search-container {
            display: flex;
            align-items: center;
        }

        .search-container input[type="text"] {
            margin-right: 10px;
        }

        .search-container button[type="submit"] {
            margin-left: 5px;
            padding: 6px 10px;
            border: none;
            background-color: #333;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }

        .status-slicer {
            margin-left: auto;
            display: flex;
            align-items: center;
        }

        .status-slicer label {
            margin-right: 10px;
        }

        .status-slicer input[type="radio"] {
            display: none;
        }

        .status-slicer span {
            display: inline-block;
            padding: 6px 12px;
            background-color: #ddd;
            color: #333;
            border-radius: 20px;
            cursor: pointer;
        }

        .status-slicer input[type="radio"]:checked + span {
            background-color: #333;
            color: #fff;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            margin-top: -10px;
            margin-right: -10px;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .pay-button {
            margin-left: auto;
            padding: 6px 10px;
            border: none;
            background-color: #333;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
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

    <div class="content">
        <h1>Payment Record</h1>

        <form action="" method="GET">
            <div class="search-container">
                <div class="input-container">
                    <input type="text" name="search_membershipid" placeholder="Search by membership ID">
                    <input type="text" name="search_name" placeholder="Search by name">
                </div>
                <button type="submit">Search</button>
                <div class="status-slicer">
                    <label>
                        <input type="radio" name="search_status" value="all" checked>
                        <span>All</span>
                    </label>
                    <label>
                        <input type="radio" name="search_status" value="paid">
                        <span>Paid</span>
                    </label>
                    <label>
                        <input type="radio" name="search_status" value="unpaid">
                        <span>Unpaid</span>
                    </label>
                </div>
            </div>
        </form>


        <table>
            <thead>
                <tr>
                    <th>Membership ID</th>
                    <th>Full Name</th>
                    <th>Balance (RM)</th>
                    <th>Status</th>
                    <th>Fee</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $searchResult->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['paymentid']; ?></td>
                        <td><?php echo $row['fullname']; ?></td>
                        <td><?php echo $row['balance']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo $row['fee']; ?></td>
                        <td><a href="#" class="update-payment" data-membershipid="<?php echo $row['paymentid']; ?>">Update</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>


    <footer>
        <p>&copy; 2023 Cafe Membership System. All rights reserved.</p>
    </footer>

    <div id="paymentDetailsModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <table class="table">
                <tbody id="paymentDetailsTableBody"></tbody>
            </table>
            <p id="paymentMessage"></p>
            <button id="payButton" class="pay-button">Pay</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".update-payment").click(function() {
                var membershipId = $(this).data("membershipid");

                $.ajax({
                    url: "getPaymentDetails.php", // Replace with the actual PHP script to fetch payment details
                    method: "GET",
                    data: { membershipId: membershipId },
                    success: function(response) {
                        var paymentDetails = JSON.parse(response);

                        var tableHeaders = {
                            "paymentid": "Membership ID",
                            "fullname": "Full Name",
                            "balance": "Balance",
                            "status": "Status",
                            "fee": "Fee"
                        };

                        if (paymentDetails) {
                            // Check status and balance to determine the display and action in the modal
                            var status = paymentDetails.status;
                            var balance = parseFloat(paymentDetails.balance);
                            var fee = parseFloat(paymentDetails.fee);

                            $("#paymentDetailsTableBody").empty();

                            // Create rows with info and value cells for each payment detail
                            for (var key in paymentDetails) {
                                var row = $("<tr></tr>");
                                var infoCell = $("<td></td>").text(tableHeaders[key]);
                                var valueCell = $("<td></td>").text(paymentDetails[key]);
                                row.append(infoCell, valueCell);
                                $("#paymentDetailsTableBody").append(row);
                            }

                            // Modify the modal based on status and balance conditions
                            if (status === "Paid") {
                                $("#payButton").hide().prop("disabled", true);
                                $("#paymentMessage").text("Payment has already been made.");
                            } else if (balance >= fee) {
                                $("#payButton").show().prop("disabled", false);
                                $("#paymentMessage").text("");
                            } else {
                                $("#payButton").hide().prop("disabled", true);
                                $("#paymentMessage").text("Balance is insufficient for payment.");
                            }

                            // Store the membership ID in the pay button's data attribute
                            $("#payButton").data("membershipid", membershipId);

                            $("#paymentDetailsModal").show();
                        }
                    },
                    error: function() {
                        console.log("Error occurred while fetching payment details.");
                    }
                });
            });

            $(".close").click(function() {
                $("#paymentDetailsModal").hide();
            });

            $("#payButton").click(function() {
                var membershipId = $(this).data("membershipid");

                $.ajax({
                    url: "makePayment.php", // Replace with the actual PHP script to make the payment
                    method: "POST",
                    data: { membershipId: membershipId },
                    success: function(response) {
                        if (response === "success") {
                            // Update the UI or display a success message
                            alert("Payment successful.");
                            $("#paymentDetailsModal").hide();
                        } else {
                            // Handle payment failure or display an error message
                            alert("Payment failed. Please try again.");
                        }
                    },
                    error: function() {
                        console.log("Error occurred while making the payment.");
                    }
                });
            });
        });
    </script>


</body>
</html>
