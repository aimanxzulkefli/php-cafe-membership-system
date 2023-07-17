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

        $membershipId = $_GET['membershipId'];

        $sql = "SELECT * FROM memberships WHERE membershipid = '$membershipId'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            $userDetails = $result->fetch_assoc();
            echo json_encode($userDetails);
        } else {
            echo json_encode(null);
        }
    
        $conn->close();

    }
?>