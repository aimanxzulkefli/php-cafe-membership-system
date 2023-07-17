<?php
    session_start();
    // Check if the user is logged in
    if (!isset($_SESSION["userid"])) {
        header("Location: login.php"); // Redirect to login page if not logged in
        exit();
    }
    // Perform the payment update
    $membershipId = $_POST['membershipId'] ?? '';

    if (!empty($membershipId)) {
        $servername = "localhost";
        $username = "root";
        $password = "";

        $conn = new mysqli($servername, $username, $password, "cafe_membership");

         // Check connection
        if (!$conn) {
            die("Connection failed: " . $conn->connect_error);
        }
            // Check if the membership ID exists and the payment is eligible for update
            $checkSql = "SELECT * FROM payment WHERE paymentid = '$membershipId' AND status = 'Unpaid' AND balance >= 15";
            $checkResult = $conn->query($checkSql);

            if ($checkResult->num_rows > 0) {
                $updatePaymentSql = "UPDATE payment 
                            SET balance = balance - 15, fee = 0, 
                            status = 'Paid' 
                            WHERE paymentid = '$membershipId'";
                $updateMembershipsSql = "UPDATE memberships 
                            SET balance = balance - 15, 
                            status = 'Paid' 
                            WHERE membershipid = '$membershipId'";

                if ($conn->query($updatePaymentSql) === TRUE &&
                    $conn->query($updateMembershipsSql) === TRUE) {
                    echo "success";
                } else {
                    echo "error";
                }
            } else {
                echo "error";
            }

            $conn->close();
        } else {
            echo "error";
    }
?>