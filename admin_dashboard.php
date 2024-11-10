<?php
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION["user_id"])) {
    header("Location: admin_login.php");
    exit; // Ensure no further code is executed
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
        }

        nav {
            background-color: #333;
            color: white;
            width: 200px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            padding-top: 20px;
        }

        nav a {
            color: white;
            padding: 15px;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
            background-color: #444;
        }

        nav a:hover {
            background-color: #007bff;
        }

        .container {
            margin-left: 220px;
            padding: 20px;
        }

        .container h1 {
            color: #333;
        }

        /* Responsive Design for Smaller Screens */
        @media (max-width: 600px) {
            nav {
                width: 100%;
                height: auto;
                position: relative;
            }

            nav a {
                float: left;
                padding: 10px;
            }

            .container {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

<header>
    <h1>Admin Dashboard</h1>
</header>

<nav>
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="add_blog.php">Add Blog Post</a>
    <a href="view_contact.php">View Contacts</a>
    <a href="add_project.php">Add Project</a>
    <a href="change_password.php">Change Password</a>
    <a href="logout.php">Logout</a>
</nav>

<div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_id']); ?>!</h1>
    <p>Select a section from the sidebar to manage blog posts, contacts, or projects.</p>
</div>

</body>
</html>
