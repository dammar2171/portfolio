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

// Initialize variables for error handling
$title = $content = $category = '';
$title_err = $content_err = $category_err = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate title
    if (empty(trim($_POST["title"]))) {
        $title_err = "Please enter a title.";
    } else {
        $title = trim($_POST["title"]);
    }

    // Validate content
    if (empty(trim($_POST["content"]))) {
        $content_err = "Please enter the content.";
    } else {
        $content = trim($_POST["content"]);
    }

    // Validate category
    if (empty(trim($_POST["category"]))) {
        $category_err = "Please enter a category.";
    } else {
        $category = trim($_POST["category"]);
    }

    // Check for errors before inserting into the database
    if (empty($title_err) && empty($content_err) && empty($category_err)) {
        // Prepare an insert statement
        $stmt = $pdo->prepare("INSERT INTO blog_posts (title, content, category, published_date) VALUES (:title, :content, :category, NOW())");
        
        // Bind parameters
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':category', $category);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to the blog page or show success message
            header("Location: blog.php");
            exit();
        } else {
            echo "Something went wrong. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Blog Post</title>
    <link rel="stylesheet" href="styles.css"> <!-- Your CSS file -->
    <style>
        /* General Styles */
body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

h1, h2 {
    color: #333;
    text-align:center;
}

p {
    color: #555;
}

/* Header Styles */
header {
    background: #007bff;
    color: white;
    padding: 10px 0;
    text-align: center;
}

header a {
    color: white;
    text-decoration: none;
    padding: 10px 15px;
}

header a:hover {
    background: #0056b3;
}

/* Form Styles */
form {
    background: white;
    padding: 20px;
    margin: 20px auto;
    max-width: 600px;
    border-radius: 5px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

form div {
    margin-bottom: 15px;
}

form label {
    display: block;
    margin-bottom: 5px;
}

form input[type="text"],
form textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

form input[type="submit"] {
    background: #007bff;
    color: white;
    border: none;
    font-size:22px;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
}

form input[type="submit"]:hover {
    background: #0056b3;
}

/* Blog Post Styles */
.blog-post {
    background: white;
    padding: 20px;
    margin: 20px auto;
    max-width: 800px;
    border-radius: 5px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.blog-post h2 {
    margin: 0 0 10px;
}

.blog-post p {
    margin: 0 0 10px;
}
/* Link style for "Back to Dashboard" */
.back-to-dashboard {
    background: #007bff;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
}

/* Hover effect for the link */
.back-to-dashboard:hover {
    background-color: #0056b3;
}


/* Footer Styles */
footer {
    text-align: center;
    padding: 20px;
    background: #007bff;
    color: white;
    position: relative;
    bottom: 0;
    width: 100%;
}

    </style>
</head>
<body>
    <h1>Add Blog Post</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <label>Title</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>">
            <span><?php echo $title_err; ?></span>
        </div>
        <div>
            <label>Content</label>
            <textarea name="content"><?php echo htmlspecialchars($content); ?></textarea>
            <span><?php echo $content_err; ?></span>
        </div>
        <div>
            <label>Category</label>
            <input type="text" name="category" value="<?php echo htmlspecialchars($category); ?>">
            <span><?php echo $category_err; ?></span>
        </div>
        <div>
            <input type="submit" value="Add Blog Post">
            <p><a href="admin_dashboard.php" class="back-to-dashboard">Back to Dashboard</a></p>
        </div>
    </form>
    

</body>
</html>
