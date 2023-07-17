<?php
    $servername = "localhost";
    $username = "root";
    $password = "";

    $conn = new mysqli($servername, $username, $password, "cafe_membership");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . $conn->connect_error);
    }else {
        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Retrieve form data
            $username = $_POST["username"];
            $password = $_POST["password"];

            // Prepare and execute the SQL query
            $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                // Login successful, set session variable and redirect
                session_start();
                $_SESSION["userid"] = $row["userid"];
                $_SESSION["username"] = $row["username"]; // Store the username in the session

                if ($row["accessrole"] === "admin") {
                    // Redirect to admin_welcome.php for admin
                    $_SESSION["accessrole"] = "admin"; // Set the access role in the session
                    header("Location: adminDashboard.php");
                    exit();
                } else {
                    // Redirect to user_welcome.php for regular users
                    $_SESSION["accessrole"] = "user"; // Set the access role in the session
                    header("Location: userDashboard.php");
                    exit();
                }
            } else {
                echo "<script>alert('Invalid credentials. Please enter the correct username and password.');</script>";
            }

            // Close the statement and result set
            $stmt->close();
            $result->close();
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <style>
    body {
      background-color: #F0F2F5;
      font-family: Arial, sans-serif;
    }

    .container {
      max-width: 500px;
      margin: auto;
      padding: 50px;
      background-color: #FFFFFF;
      border: 20px solid #E9EBEE;
      border-radius: 50px;
      box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
    }

    h1 {
      font-size: 24px;
      margin: 100px 0 10px;
      text-align: center;
    }

    .membership-label {
      font-size: 40px;
      font-weight: bold;
      margin-bottom: 10px;
      text-align: center;
      font-family: Klavika, Arial, sans-serif;
      color: blue;
    }

    label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #E9EBEE;
      border-radius: 5px;
      box-sizing: border-box;
    }

    .btn-login {
      display: block;
      width: 100%;
      padding: 10px;
      background-color: #1877F2;
      color: #FFFFFF;
      font-weight: bold;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .btn-login:hover {
      background-color: #1565C0;
    }

    .text-center {
      text-align: center;
    }

    .footer {
      margin-top: 20px;
      text-align: center;
      color: #65676B;
    }

    .error {
      color: red;
      font-size: 12px;
      margin-top: 5px;
    }

    .forgot-password {
      margin-top: 15px;
      text-align: center;
    }

    p{
      margin-bottom:0px;
    }
  </style>
</head>
<body>
  <h1 class="membership-label">Cafe Membership Login</h1>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Log In" class="btn-login">

        <?php if (isset($loginError)) : ?>
            <p class="error"><?php echo $loginError; ?></p>
        <?php endif; ?>

        </form>
        <p>Don't have an account? <a href="registration.php">Register here!</a></p>

    </div>

    <div class="footer">
        <p>&copy; 2023 Cafe Membership System. All rights reserved.</p>
    </div>
</body>
</html>

