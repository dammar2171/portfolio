<?php
// Database connection
$host = 'localhost';
$db = 'portfolio'; // Replace with your database name
$user = 'root'; // Default username for XAMPP
$pass = ''; // Default password is usually empty

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name']; // Image name
    $link = $_POST['link'];

    // Define the path to store the image
    $target_dir = "uploads/"; // Ensure this directory exists
    $target_file = $target_dir . basename($image);

    // Upload the file
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        // Prepare SQL statement to insert project
        $stmt = $pdo->prepare("INSERT INTO portfolio_items (title, description, image, link) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$title, $description, $target_file, $link])) {
            $message = "Project added successfully.";
        } else {
            $message = "Error adding project.";
        }
    } else {
        $message = "Sorry, there was an error uploading your file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Project</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh; /* Full height of the viewport */
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f9f9f9;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 5px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="text"],
        input[type="url"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #5cb85c;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #4cae4c;
        }

        .message {
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
        }
        /* Link style for "Back to Dashboard" */
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

    </style>
</head>
<body>

    <div class="container">
        <h1>Add New Project</h1>
        <?php if (isset($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="title">Project Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="image">Project Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>

            <label for="link">Project Link:</label>
            <input type="url" id="link" name="link" required>

            <input type="submit" value="Add Project">
            <p><a href="admin_dashboard.php" class="back-to-dashboard">Back to Dashboard</a></p>

        </form>
    </div>

</body>
</html>
