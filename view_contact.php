<?php
// Include your database connection
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "portfolio"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetching contact messages from the database
$sql = "SELECT * FROM contact_messages ORDER BY submitted_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Contacts</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to external CSS file -->
    <style>
        /* Basic inline styles */
        /* Link style for "Back to Dashboard" */
.back-to-dashboard {
    display: inline-block;
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 5px;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

/* Hover effect for the link */
.back-to-dashboard:hover {
    background-color: #0056b3;
}

        .container {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .contact-message {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }

        .contact-message:last-child {
            border-bottom: none;
        }

        .contact-message h3 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }

        .contact-message p {
            margin: 5px 0;
            font-size: 16px;
            color: #666;
        }
        footer {
            text-align: center;
            margin-top: 20px;
            padding: 20px;
            background-color: #333;
            color: white;
        }
    </style>
</head>
<body>

<header>
    <h1>Contact Messages</h1><p><a href="admin_dashboard.php" class="back-to-dashboard">Back to Dashboard</a></p>

</header>

<div class="container">
    <h1>Submitted Contact Messages</h1>

    <?php
    if ($result->num_rows > 0) {
        // Output data for each row
        while($row = $result->fetch_assoc()) {
            echo "<div class='contact-message'>";
            echo "<h3>" . htmlspecialchars($row["name"]) . " <small>(" . htmlspecialchars($row["email"]) . ")</small></h3>";
            echo "<p><strong>Subject:</strong> " . htmlspecialchars($row["subject"]) . "</p>";
            echo "<p><strong>Message:</strong><br>" . nl2br(htmlspecialchars($row["message"])) . "</p>";
            echo "<p><small>Submitted on: " . $row["submitted_at"] . "</small></p>";
            echo "</div>";
        }
    } else {
        echo "<p>No contact messages found.</p>";
    }

    // Close the database connection
    $conn->close();
    ?>
</div>

<footer>
    <p>&copy; 2024 My Portfolio. All rights reserved.</p>
</footer>

</body>
</html>
