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

    // Retrieve the top-up amount from the POST data
    $topUpAmount = $_POST["amount"];

    // Perform the necessary SQL updates to update the balances in both tables
    $updateMembershipsSql = "UPDATE memberships SET balance = balance + $topUpAmount WHERE membershipid = '$membershipId'";
    $conn->query($updateMembershipsSql);

    $updatePaymentSql = "UPDATE payment SET balance = balance + $topUpAmount WHERE paymentid = '$membershipId'";
    $conn->query($updatePaymentSql);

    // Check if the updates were successful
    if ($conn->affected_rows > 0) {
        // Top-up successful
        echo "success";
    } else {
        // Top-up failed
        echo "failure";
    }

    $conn->close();
?>
