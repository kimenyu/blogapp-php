<?php
session_start();

//initializing variables
$username = "";
$email = "";
$errors = array();
$title = "";
$content = "";

//connect to the database
$db = mysqli_connect('localhost', 'jos', 'Boyfaded7552', 'blog');

//Register user
if(isset($_POST['reg_user'])){
    //receive all input values from the form
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

    //form validation: ensure that the form is correctly filled
    if(empty($username)){
        array_push($errors, "Username is required");
    }
    if(empty($email)){
        array_push($errors, "Email is required");
    }
    if(empty($password_1)){
        array_push($errors, "Password is required");
    }
    if($password_1 != $password_2){
        array_push($errors, "The two passwords do not match");
    }

    //register user if there are no errors in the form
    if(count($errors) == 0){
        $password = md5($password_1); //encrypt the password before saving in the database
        $query = "INSERT INTO users (username, email, password) VALUES('$username', '$email', '$password')";
        mysqli_query($db, $query);

        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: index.php');
    }
}



// LOGIN USER
if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
  
    if (empty($username)) {
          array_push($errors, "Username is required");
    }
    if (empty($password)) {
          array_push($errors, "Password is required");
    }
  
    if (count($errors) == 0) {
          $password = md5($password);
          $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
          $results = mysqli_query($db, $query);
          if (mysqli_num_rows($results) == 1) {
            $user = mysqli_fetch_assoc($results);
            $_SESSION['user_id'] = $user['user_id']; // Assuming 'user_id' is the column name in your 'users' table
            $_SESSION['username'] = $user['username']; // Set the username in the session
            $_SESSION['success'] = "You are now logged in";
            
            header('location: index.php');
          } else {
            array_push($errors, "Wrong username/password combination");
            }
        
    }
  }

//create a post

// Check if user is logged in and get their ID (assuming you have stored it in the session)
if (isset($_SESSION['user_id'])) {
    $author_id = $_SESSION['user_id'];

    if (isset($_POST['submit'])) {
        $title = mysqli_real_escape_string($db, $_POST['title']);
        $content = mysqli_real_escape_string($db, $_POST['content']);

        // Validation
        if (empty($title)) {
            array_push($errors, 'Title is required');
        }

        if (empty($content)) {
            array_push($errors, 'Content is required');
        }

        if (count($errors) == 0) {
            $query = "INSERT INTO posts (title, content, author_id) VALUES ('$title', '$content', '$author_id')";
            $result = mysqli_query($db, $query);
            if ($result) {
                $_SESSION["success"] = "Post created successfully";
                header("location: index.php");
                exit(); // Make sure to exit after redirecting
            } else {
                array_push($errors, "Error creating post: " . mysqli_error($db));
            }
        }
    }
} else {
    // Handle case where user is not logged in or their ID is not available
    // You can redirect them to a login page or handle it based on your application's logic
    echo "User not logged in or ID not available";
}
mysqli_close($db);
