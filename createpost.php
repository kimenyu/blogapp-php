<?php include('server.php') ?>
<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create New Post</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    .container {
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    input[type="text"],
    textarea {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    textarea {
        height: 200px;
    }

    .btn {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #0056b3;
    }
</style>
</head>
<body>

<div class="container">
    <h2>Create New Post</h2>
    <form action="createpost.php" method="POST">
        <?php include('errors.php'); ?>
        <div class="form-group">
            <label for="title">Post Title:</label>
            <input type="text" id="title" name="title" value="<?php echo $title; ?>" required>
        </div>
        <div class="form-group">
            <label for="content">Post Content:</label>
            <textarea id="content" name="content" required><?php echo $content; ?></textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn" name="submit">Submit Post</button>
            <a href="index.php" class="btn">Cancel</a>
        </div>
    </form>
</div>

</body>
</html>
