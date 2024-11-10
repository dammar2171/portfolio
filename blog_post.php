<?php
$host = 'localhost'; // Database host
$db = 'portfolio'; // Database name
$user = 'root'; // Database username
$pass = ''; // Database password

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize the input

    // Prepare the SQL query to fetch the blog post
    $query = "SELECT title, content, published_date FROM blog_posts WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);

    // Fetch the blog post
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the post exists
    if ($post) {
        $title = htmlspecialchars($post['title']);
        $content = htmlspecialchars($post['content']);
        $published_date = htmlspecialchars($post['published_date']);
    } else {
        // Redirect or display a message if the post is not found
        die('Blog post not found.');
    }
} else {
    // Redirect or display a message if no ID is provided
    die('No blog post ID specified.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - My Blog</title>
    <!-- Link to your CSS file -->
     <style>
        /* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Arial', sans-serif;
    line-height: 1.6;
    background-color: #f4f4f4;
    color: #333;
    padding: 20px;
}

/* Header Styles */
header {
    background: #007bff; /* Bootstrap primary color */
    color: #fff;
    padding: 20px;
    border-radius: 5px;
    margin-bottom: 20px;
}

header h1 {
    margin-bottom: 10px;
}

header p {
    font-style: italic;
}

/* Article Styles */
article {
    background: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.post-content {
    margin-top: 20px;
}

/* Footer Styles */
footer {
    margin-top: 20px;
    text-align: center;
}

footer a {
    text-decoration: none;
    color: #007bff; /* Bootstrap primary color */
}

footer a:hover {
    text-decoration: underline;
}

/* Responsive Design */
@media (max-width: 600px) {
    body {
        padding: 10px;
    }

    header {
        padding: 15px;
    }

    article {
        padding: 15px;
    }
}

     </style>
</head>
<body>
    <header>
        <h1><?php echo $title; ?></h1>
        <p>Published on: <?php echo $published_date; ?></p>
    </header>

    <article>
        <div class="post-content">
            <?php echo nl2br($content); // Convert new lines to <br> for HTML display ?>
        </div>
    </article>

    <footer>
        <a href="blog.php">Back to Blog</a>
    </footer>
</body>
</html>
