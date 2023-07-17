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

        if (isset($_POST["save_edit"])) {
            // Retrieve the updated values from the form
            $fullname = $_POST["fullname"];
            $address1 = $_POST["address1"];
            $address2 = $_POST["address2"];
            $postcode = $_POST["postcode"];
            $city = $_POST["city"];
            $state = $_POST["state"];

            // Update the user profile with the new values
            $updateProfileSql = "UPDATE memberships SET fullname = ?, address1 = ?, address2 = ?, postcode = ?, city = ?, state = ? WHERE membershipid = ?";
            $stmt = $conn->prepare($updateProfileSql);
            $stmt->bind_param("sssssss", $fullname, $address1, $address2, $postcode, $city, $state, $membershipid);

            if ($stmt->execute()) {
                $updateSuccess = "Profile updated successfully.";
                echo '<script>alert("' . $updateSuccess . '");</script>';
                header("Location: userProfile.php");
            } else {
                $updateError = "Error updating profile. Please try again.";
                echo '<script>alert("' . $updateError . '");</script>';
            }
            $stmt->close();
        }

        $conn->close();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
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

        form {
            margin: 0 auto;
            max-width: 400px;
            padding: 20px;
            box-sizing: border-box;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #e9ebee;
            border-radius: 5px;
            box-sizing: border-box;
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
                <h1>Edit Profile</h1>
                <form action="" method="POST">
                    <label for="fullname">Full Name</label>
                    <input type="text" id="fullname" name="fullname" value="<?php echo $fullname; ?>">

                    <label for="address1">Address 1</label>
                    <input type="text" id="address1" name="address1" value="<?php echo $address1; ?>">

                    <label for="address2">Address 2</label>
                    <input type="text" id="address2" name="address2" value="<?php echo $address2; ?>">

                    <label for="postcode">Postcode</label>
                    <input type="text" id="postcode" name="postcode" value="<?php echo $postcode; ?>">

                    <label for="city">City</label>
                    <input type="text" id="city" name="city" value="<?php echo $city; ?>">

                    <label for="state">State</label>
                    <input type="text" id="state" name="state" value="<?php echo $state; ?>">

                    <input type="submit" value="Save" name="save_edit">
                </form>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; 2023 Cafe Membership System. All rights reserved.</p>
    </footer>
</body>
</html>
