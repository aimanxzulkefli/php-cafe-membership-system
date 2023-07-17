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

    $membershipId = $_GET['membershipId'] ?? '';

    if (!empty($membershipId)) {
        $sql = "SELECT p.paymentid, m.fullname, p.balance, p.status, p.fee
                FROM payment p
                INNER JOIN memberships m ON p.paymentid = m.membershipid
                WHERE p.paymentid = '$membershipId'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $paymentDetails = $result->fetch_assoc();

            // Retrieve the balance and fee values from the paymentDetails array
            $balance = $paymentDetails['balance'];
            $fee = $paymentDetails['fee'];

            // Add the balance and fee to the paymentDetails array
            $paymentDetails['balance'] = $balance;
            $paymentDetails['fee'] = $fee;

            echo json_encode($paymentDetails);
        } else {
            echo "error";
        }
    } else {
        echo "error";
    }

    $conn->close();
?>
