<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Me</title>
    <style>
        /* Basic reset and layout styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        header {
            background-color: #4CAF50;
            color: white;
            padding: 10px 0;
            text-align: center;
        }

        nav {
            text-align: center;
            margin-top: 10px;
        }

        nav a {
            text-decoration: none;
            color: white;
            padding: 14px 20px;
            background-color: #333;
            margin: 0 10px;
            border-radius: 5px;
        }

        nav a:hover {
            background-color: #555;
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
            font-size: 36px;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        label {
            font-size: 18px;
            color: #333;
        }

        input, textarea {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
            max-width: 100%;
        }

        textarea {
            height: 150px;
            resize: none;
        }

        button {
            padding: 10px 20px;
            font-size: 18px;
            color: white;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        footer {
            text-align: center;
            margin-top: 20px;
            padding: 20px;
            background-color: #333;
            color: white;
        }

        .message {
            margin-bottom: 20px;
            text-align: center;
            font-size: 18px;
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>

<header>
    <h1>Contact Me</h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="portfolio.php">Portfolio</a>
        <a href="blog.php">Blog</a>
        <a href="contact.php">Contact</a>
    </nav>
</header>

<div class="container">
    <h1>Get In Touch</h1>
    
    <?php
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'portfolio'); // Adjust your database details

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form inputs
        $name = $conn->real_escape_string($_POST["name"]);
        $email = $conn->real_escape_string($_POST["email"]);
        $subject = $conn->real_escape_string($_POST["subject"]);
        $message = $conn->real_escape_string($_POST["message"]);
        $error = "";

        // Simple validation
        if (empty($name) || empty($email) || empty($subject) || empty($message)) {
            $error = "All fields are required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email format.";
        }

        if (empty($error)) {
            // Insert the message into the database
            $sql = "INSERT INTO contact_messages (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";
            
            if ($conn->query($sql)) {
                echo "<p class='message'>Your message has been sent successfully!</p>";
            } else {
                echo "<p class='message error'>Failed to send your message. Please try again later.</p>";
            }
        } else {
            echo "<p class='message error'>$error</p>";
        }
    }

    $conn->close();
    ?>

    <form action="contact.php" method="POST">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" placeholder="Your name">

        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Your email">

        <label for="subject">Subject</label>
        <input type="text" id="subject" name="subject" placeholder="Subject of your message">

        <label for="message">Message</label>
        <textarea id="message" name="message" placeholder="Write your message here"></textarea>

        <button type="submit">Send Message</button>
    </form>
</div>

<footer>
    <p>&copy; 2024 My Portfolio. All rights reserved.</p>
</footer>

</body>
</html>
