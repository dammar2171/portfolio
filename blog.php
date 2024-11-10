<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - My Thoughts</title>
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
            max-width: 1200px;
            margin: 20px auto;
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

        .blog-posts {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .blog-post {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .blog-post:hover {
            transform: translateY(-5px);
        }

        .blog-image img {
            width: 100%;
            height: auto;
        }

        .blog-content {
            padding: 20px;
        }

        .blog-title {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }

        .blog-description {
            font-size: 16px;
            color: #666;
            margin-bottom: 15px;
        }

        .blog-link {
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
            display: block;
            transition: background-color 0.3s ease;
        }

        .blog-link:hover {
            background-color: #45a049;
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
    <h1>My Blog</h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="portfolio.php">Portfolio</a>
        <a href="blog.php">Blog</a>
        <a href="contact.php">Contact</a>
    </nav>
</header>

<div class="container">
    <h1>Recent Blog Posts</h1>
    <div class="blog-posts">
        <?php
        // Connect to the database
        $conn = new mysqli("localhost", "root", "", "portfolio");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch blog posts from the database
        $sql = "SELECT * FROM blog_posts ORDER BY created_at DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data for each blog post
            while($row = $result->fetch_assoc()) {
                echo "
                    <div class='blog-post'>
                        <div class='blog-image'>
                            <img src='uploads/" . $row["image"] . "' alt='" . $row["title"] . "'>
                        </div>
                        <div class='blog-content'>
                            <h2 class='blog-title'>" . $row["title"] . "</h2>
                            <p class='blog-description'>" . substr($row["description"], 0, 150) . "...</p>
                            <a href='blog_post.php?id=" . $row["id"] . "' class='blog-link'>Read More</a>
                        </div>
                    </div>
                ";
            }
        } else {
            echo "<p>No blog posts available.</p>";
        }

        $conn->close();
        ?>
    </div>
</div>

<footer>
    <p>&copy; 2024 My Blog. All rights reserved.</p>
</footer>

</body>
</html>
