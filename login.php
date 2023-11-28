<?php
    // Creating the page title and adding the header page 
    $pagetitle = "Login to your account";
    require_once "assets/header.php";

    // Creating a connection to the database
    require_once 'assets/db_connect.php';

    $email = "";
    $paerr = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Validating username and password
        $sql = "SELECT * FROM users WHERE email = '$email' OR username = '$email' OR phonenumber = '$phonenumber'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['user_role'] = $user['user_role'];

                header('Location: index.php');
                exit();
            } else {
                $paerr = "Invalid username or password";
            }
        } else {
            $paerr = "Invalid username or password";
        }
    }
    
    // Close the database connection
    mysqli_close($conn);
?>
<style>
    form {
        margin: 20px 400px;
    }
</style>
<form action="" method="post">
    <p>Don't have an account? <a href="register.php">Sign Up</a></p>
    <h1>Login your account</h1>
    
    <input type="text" maxlength="100" placeholder="Enter Email Address | Username | Phone Number" name="email" value="<?php echo $email ?>" required/>
   
    <input type="password" placeholder="Password" name="password" required/>
    <span id='error'><?php echo $paerr; ?></span>
    
    <input type="submit" value="Login">
</form>