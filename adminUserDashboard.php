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

    $searchSql = "SELECT membershipid, fullname, balance, status FROM memberships WHERE fullname LIKE '%$searchName%' AND membershipid LIKE '%$searchMembershipID%'";
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

        button[type="submit"] {
            padding: 6px 10px;
            border: none;
            background-color: #333;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #666;
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
        <h1>User Profile</h1>

        <form action="" method="GET">
            <input type="text" name="search_membershipid" placeholder="Search by membership ID">
            <input type="text" name="search_name" placeholder="Search by name">
            <button type="submit">Search</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Membership ID</th>
                    <th>Full Name</th>
                    <th>Balance (RM)</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $searchResult->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['membershipid']; ?></td>
                        <td><?php echo $row['fullname']; ?></td>
                        <td><?php echo $row['balance']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td><a href="#" class="view-user" data-membershipid="<?php echo $row['membershipid']; ?>">View</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <footer>
        <p>&copy; 2023 Cafe Membership System. All rights reserved.</p>
    </footer>

    <div id="memberDetailsModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <table class="table">
                <tbody id="memberDetailsTableBody"></tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".view-user").click(function() {
                var membershipId = $(this).data("membershipid");

                $.ajax({
                    url: "getUserDetails.php", // Replace with the actual PHP script to fetch user details
                    method: "GET",
                    data: { membershipId: membershipId },
                    success: function(response) {
                        var userDetails = JSON.parse(response);

                        var tableHeaders = {
                            "membershipid": "Membership ID",
                            "fullname": "Full Name",
                            "address1": "Address 1",
                            "address2": "Address 2",
                            "postcode": "Postcode",
                            "city": "City",
                            "state": "State",
                            "balance": "Balance",
                            "status": "Status"
                            // Add more custom column names as needed
                        };

                        if (userDetails) {
                            $("#memberDetailsTableBody").empty();

                            // Create rows with info and value cells for each user detail
                            for (var key in userDetails) {
                                var row = $("<tr></tr>");
                                var infoCell = $("<td></td>").text(tableHeaders[key]);
                                var valueCell = $("<td></td>").text(userDetails[key]);
                                row.append(infoCell, valueCell);
                                $("#memberDetailsTableBody").append(row);
                            }

                            $("#memberDetailsModal").show();
                        }
                    },
                    error: function() {
                        console.log("Error occurred while fetching user details.");
                    }
                });
            });

            $(".close").click(function() {
                $("#memberDetailsModal").hide();
            });
        });
    </script>

</body>
</html>
