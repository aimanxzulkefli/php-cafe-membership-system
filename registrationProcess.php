<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cafe_membership";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve user input data
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $fullname = $_POST["fullname"];
    $address1 = $_POST["address1"];
    $address2 = $_POST["address2"];
    $postcode = $_POST["postcode"];
    $city = $_POST["city"];
    $state = $_POST["state"];

    // Check if the password and confirm_password match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match. Please try again.');</script>";
        exit();
    }

    // Check if the username already exists in the database
    $checkUsernameSql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($checkUsernameSql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows > 0) {
        echo "<script>alert('Username already exists. Please choose a different username.'); window.history.back(); </script>";
        exit();
    }

    // Generate a unique 5-digit userid
    $userid = generateUniqueID();
    $membershipid = $userid;
    $paymentid = $userid;

    // Prepare and execute the SQL query to insert into the users table
    $insertUserSql = "INSERT INTO users (userid, username, password, accessrole) VALUES (?, ?, ?, 'User')";
    $stmt = $conn->prepare($insertUserSql);
    $stmt->bind_param("sss", $userid, $username, $password);
    $stmt->execute();
    $stmt->close();

    // Prepare and execute the SQL query to insert into the memberships table
    $insertMembershipSql = "INSERT INTO memberships (membershipid, fullname, address1, address2, postcode, city, state, balance, status) VALUES (?, ?, ?, ?, ?, ?, ?, 0, 'Unpaid')";
    $stmt = $conn->prepare($insertMembershipSql);
    $stmt->bind_param("sssssss", $membershipid, $fullname, $address1, $address2, $postcode, $city, $state);
    $stmt->execute();
    $stmt->close();

    // Prepare and execute the SQL query to insert into the payments table
    $insertPaymentSql = "INSERT INTO payment (paymentid, fee, status, balance) VALUES (?, 15, 'Unpaid', 0)";
    $stmt = $conn->prepare($insertPaymentSql);
    $stmt->bind_param("s", $paymentid);
    $stmt->execute();
    $stmt->close();

    // Registration successful, redirect to the login page
    header("Location: login.php");
    exit();
}

// Function to generate a unique 5-digit id (userid, membershipid, and paymentid)
function generateUniqueID() {
    $characters = '0123456789';
    $id = '';
    for ($i = 0; $i < 5; $i++) {
        $id .= $characters[rand(0, strlen($characters) - 1)];
    }

    // Check if the generated id is unique in users, memberships, and payment tables
    global $conn;
    $checkSql = "SELECT userid FROM users WHERE userid = ? UNION ALL SELECT membershipid FROM memberships WHERE membershipid = ? UNION ALL SELECT paymentid FROM payment WHERE paymentid = ?";
    $stmt = $conn->prepare($checkSql);
    $stmt->bind_param("sss", $id, $id, $id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        // If the id is not unique, generate a new one recursively
        $stmt->close();
        return generateUniqueID();
    }

    $stmt->close();
    return $id;
}

?>
