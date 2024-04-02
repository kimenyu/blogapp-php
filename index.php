<?php 
session_start(); 
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}

// Database connection
$db = mysqli_connect('localhost', 'jos', 'Boyfaded7552', 'blog');
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT posts.*, users.username AS author_username
          FROM posts
          INNER JOIN users ON posts.author_id = users.user_id";
$result = mysqli_query($db, $query);
$allposts = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_close($db); // Close the database connection after fetching posts
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }

        .content {
            max-width: 800px;
            margin: 20px auto;
            padding: 0 20px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
        }

        .btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 10px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .container {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
        }

        .post-title {
            margin-top: 0;
        }

        .post-content {
            margin-bottom: 10px;
        }

        .author {
            font-style: italic;
            color: #666;
        }

        .post-actions {
            margin-top: 10px;
        }
    </style>
    
</head>
<body>

<div class="header">
    <h2>Home Page</h2>
</div>

<div class="content">
    <!-- Notification message -->
    <?php if (isset($_SESSION['success'])) : ?>
    <div class="success" id="successMessage">
        <h3><?php echo $_SESSION['success']; ?></h3>
    </div>
    <?php endif ?>


    <!-- Logged in user information -->
    <?php if (isset($_SESSION['username'])) : ?>
        <p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
        <p><a href="index.php?logout='1'" style="color: red;">Logout</a></p>
        <a href="createpost.php" class="btn">Create Post</a>
    <?php endif ?>
</div>

<h2>BLOGS</h2>

<?php if(empty($allposts)): ?>
    <p>There are no blogs</p>
<?php endif; ?>

<?php foreach($allposts as $post): ?>
    <div class="container">
        <div class="post">
            <h2 class="post-title"><?php echo $post['title']; ?></h2>
            <p class="post-content"><?php echo $post['content']; ?> </p>
            <div class="author">
                By <?php echo $post['author_username']; ?> on <?php echo date_format(
                    date_create($post['created_at']),
                    'g:ia \o\n l jS F Y'
                ); ?>
            </div>
            <div class="post-actions">
                <a href="#" class="btn">Read More</a>
            </div>
        </div>
    </div>
<?php endforeach; ?>


<script>
    // Wait for the document to fully load
    document.addEventListener("DOMContentLoaded", function() {
        // Get the success message element by its ID
        var successMessage = document.getElementById("successMessage");

        // Check if the success message element exists
        if (successMessage) {
            // Set a timer to hide the message after 3 seconds
            setTimeout(function() {
                successMessage.style.display = "none"; // Hide the message
            }, 3000); // 3000 milliseconds = 3 seconds
        }
    });
</script>


</body>
</html>