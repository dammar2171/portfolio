<?php
// Start the session
session_start();

// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION["user_id"])) {
    header("Location: admin_login.php");
    exit; // Ensure no further code is executed
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
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch the logged-in admin's current password from the database
    $stmt = $conn->prepare("SELECT password FROM admin WHERE id = ?");
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    // Check if the current password is correct
    if (password_verify($current_password, $admin['password'])) {
        // Check if new password and confirm password match
        if ($new_password === $confirm_password) {
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the password in the database
            $update_stmt = $conn->prepare("UPDATE admin SET password = ? WHERE id = ?");
            $update_stmt->bind_param('si', $hashed_password, $_SESSION['user_id']);
            if ($update_stmt->execute()) {
                $message = "Password changed successfully!";
            } else {
                $message = "Error updating password!";
            }
        } else {
            $message = "New passwords do not match!";
        }
    } else {
        $message = "Current password is incorrect!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
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

        /* Container for Form */
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
        input[type="password"] {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

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
        .back-to-dashboard {
    display: inline-block;
    width:92%;
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    text-align:center;
    border-radius: 5px;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

/* Hover effect for the link */
.back-to-dashboard:hover {
    background-color: #0056b3;
}

        /* Responsive Design for Small Screens */
        @media (max-width: 600px) {
            .container {
                width: 90%;
            }

            h1 {
                font-size: 20px;
            }

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
        <h1>Change Password</h1>
        <?php if (isset($message)): ?>
            <div><?php echo $message; ?></div>
        <?php endif; ?>

        <form action="change_password.php" method="POST">
            <label for="current_password">Current Password</label>
            <input type="password" name="current_password" id="current_password" required>

            <label for="new_password">New Password</label>
            <input type="password" name="new_password" id="new_password" required>

            <label for="confirm_password">Confirm New Password</label>
            <input type="password" name="confirm_password" id="confirm_password" required>

            <input type="submit" value="Change Password">
            <p><a href="admin_dashboard.php" class="back-to-dashboard">Back to Dashboard</a></p>
        </form>
    </div>
</body>
</html>
