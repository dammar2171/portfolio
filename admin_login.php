<?php
// Start the session
session_start();

// Check if the user is already logged in, redirect to dashboard if true
if (isset($_SESSION["user_id"])) {
    header("Location: admin_dashboard.php");
    exit; // Ensure no further code is executed after redirection
}

// Database connection
$conn = new mysqli("localhost", "root", "", "portfolio");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$message = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username exists in the database
    $stmt = $conn->prepare("SELECT id, password FROM admin WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Set session variables and redirect to the admin dashboard
            $_SESSION["user_id"] = $user['id'];
            header("Location: admin_dashboard.php");
            exit; // Make sure the code stops executing after redirection
        } else {
            $message = "Invalid password!";
        }
    } else {
        $message = "Username not found!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to the CSS file -->
    <style>
        /* General Body Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Container for Login Form */
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        /* Header Styles */
        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        /* Form Styles */
        form {
            display: flex;
            flex-direction: column;
        }

        /* Label Styles */
        label {
            font-size: 16px;
            margin-bottom: 8px;
            color: #333;
        }

        /* Input Field Styles */
        input[type="text"],
        input[type="password"] {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #007BFF;
            outline: none;
        }

        /* Submit Button Styles */
        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Message Box */
        div {
            text-align: center;
            margin: 10px 0;
            color: #d9534f;
        }

        /* Footer Links */
        p {
            text-align: center;
        }

        a {
            color: #007BFF;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Responsive Design for Small Screens */
        @media (max-width: 600px) {
            .container {
                width: 90%;
            }

            h1 {
                font-size: 20px;
            }

            input[type="text"],
            input[type="password"] {
                font-size: 14px;
            }

            input[type="submit"] {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Login</h1>
        <?php if (isset($message)): ?>
            <div><?php echo $message; ?></div>
        <?php endif; ?>

        <form action="admin_login.php" method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>
            
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
            
            <input type="submit" value="Login">
        </form>

        <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
    </div>
</body>
</html>
