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
    } else {

        $membershipId = $_SESSION["userid"];

        $userProfileSql = "SELECT * FROM memberships WHERE membershipid = '$membershipId'";
        $result = $conn->query($userProfileSql);

        if ($result->num_rows > 0) {
            // Fetch and display user profile information
            while ($row = $result->fetch_assoc()) {
                // Access the profile fields and display them as needed
                $membershipid = $row["membershipid"];
                $fullname = $row["fullname"];
                $address1 = $row["address1"];
                $address2 = $row["address2"];
                $postcode = $row["postcode"];
                $city = $row["city"];
                $state = $row["state"];
                $balance = $row["balance"];
                $status = $row["status"];
            }
        }

        if (isset($_POST["save_password"])) {
            $newPassword = $_POST["new_password"];
            $confirmPassword = $_POST["confirm_password"];

            // Validate password fields
            if ($newPassword !== $confirmPassword) {
                $passwordError = "Passwords do not match.";
            } else {
                $userid = $_SESSION["userid"];

                // Update the password in the users table
                $updatePasswordSql = "UPDATE users SET password = ? WHERE userid = ?";
                $stmt = $conn->prepare($updatePasswordSql);
                $stmt->bind_param("si", $newPassword, $userid);

                if ($stmt->execute()) {
                    $passwordSuccess = "Password updated successfully.";
                    echo '<script>alert("' . $passwordSuccess . '");</script>';
                } else {
                    $passwordError = "Error updating password. Please try again.";
                }
                $stmt->close();
            }
        }

        $conn->close();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table td {
            padding: 10px;
            border: 1px solid #e9ebee;
        }

        table tr:nth-child(even) td {
            background-color: #f0f2f5;
        }

        .edit-button {
            display: inline-block;
            padding: 10px 15px;
            background-color: #1877f2;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            float: right;
        }

        .edit-button:hover {
            background-color: #1565c0;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #e9ebee;
            border-radius: 5px;
        }

        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #1877f2;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #1565c0;
        }

        .field-label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .field-value {
            margin-bottom: 10px;
        }

        .profile-container {
            display: flex;
        }

        .profile-field {
            flex: 2;
            padding: 0px;
            border: none;
        }

        .profile-field h1 {
            margin-bottom: 20px;
        }

        .password-container {
            flex: 1;
            padding: 20px;
            border: 1px solid #e9ebee;
            margin-left: 20px;
        }

        .password-container h2 {
            margin-bottom: 20px;
        }

        .save-button{
            font-size:16px;
        }

        .password-container form {
            text-align: left;
        }

        input[type="password"] {
            width: 100%;
            box-sizing: border-box;
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
        <div class="profile-container">
            <div class="profile-field">
                <h1>Profile</h1>
                <table>
                    <tr>
                        <td>Membership ID</td>
                        <td><?php echo $membershipid; ?></td>
                    </tr>
                    <tr>
                        <td>Full Name</td>
                        <td><?php echo $fullname; ?></td>
                    </tr>
                    <tr>
                        <td>Address 1</td>
                        <td><?php echo $address1; ?></td>
                    </tr>
                    <tr>
                        <td>Address 2</td>
                        <td><?php echo $address2; ?></td>
                    </tr>
                    <tr>
                        <td>Postcode</td>
                        <td><?php echo $postcode; ?></td>
                    </tr>
                    <tr>
                        <td>City</td>
                        <td><?php echo $city; ?></td>
                    </tr>
                    <tr>
                        <td>State</td>
                        <td><?php echo $state; ?></td>
                    </tr>
                    <tr>
                        <td>Balance</td>
                        <td><?php echo $balance; ?></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td><?php echo $status; ?></td>
                    </tr>
                </table>
                <a href="editProfile.php" class="edit-button">Edit</a>
            </div>
            <div class="password-container">
                <h2>Change Password</h2>
                <form action="" method="POST">
                    <label for="new-password">New Password</label>
                    <input type="password" id="new-password" name="new_password" required>

                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm_password" required>

                    <input class ="save-button"type="submit" value="Save" name="save_password">
                </form>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; 2023 Cafe Membership System. All rights reserved.</p>
    </footer>
</body>
</html>
