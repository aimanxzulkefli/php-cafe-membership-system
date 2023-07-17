<!DOCTYPE html>
<html>
<head>
    <title>Register for Cafe Membership</title>
    <style>
        /* Custom CSS styles for the registration page */
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

        /* Add a border between the sections */
        .section-divider-top {
            border-bottom: 2px solid #E9EBEE;
            margin-bottom: 20px;
            padding-bottom: 10px;
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

        .btn-register {
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

        .btn-register:hover {
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

        p {
            margin-bottom: 0px;
        }

    </style>
</head>
<body>
    <h1 class="membership-label">Cafe Membership Registration</h1>
    <div class="container">
        <div class="section-divider-top">
            <h2>Username and Password</h2>
            <form action="registrationProcess.php" method="POST">
                <!-- First Section: Username and Password -->
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>

                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>

            <div class="section-divider">
                <h2>User Information</h2>
                <!-- Second Section: User Information -->
                <label for="fullname">Full Name</label>
                <input type="text" id="fullname" name="fullname" required>

                <label for="address1">Address 1</label>
                <input type="text" id="address1" name="address1" required>

                <label for="address2">Address 2</label>
                <input type="text" id="address2" name="address2">

                <label for="postcode">Postcode</label>
                <input type="text" id="postcode" name="postcode" required>

                <label for="city">City</label>
                <input type="text" id="city" name="city" required>

                <label for="state">State</label>
                <input type="text" id="state" name="state" required>

                <input type="submit" value="Register" class="btn-register">
            </form>
        </div>
        <p>Already have an account? <a href="login.php">Log In</a></p>
        <!-- You can add a link to the login page for users who already have an account -->
    </div>

    <div class="footer">
        <p>&copy; 2023 Cafe Membership System. All rights reserved.</p>
    </div>
</body>
</html>
