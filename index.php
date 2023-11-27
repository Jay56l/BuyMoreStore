<?php
    // Creating the page title and adding the header page 
    $pagetitle = "Welcome to BuyMore Store";
    require_once "assets/header.php";

    if (isset($_SESSION['user_id'])) {
        require_once 'assets/db_connect.php';
        $user_id = $_SESSION['user_id'];
        $query = "SELECT * FROM users WHERE user_id = $user_id";
        $result = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($result);
?>
<h1>Welcome <?php echo $user['first_name']; ?></h1>
<p><?php echo $user['email']; ?></p>
<?php
    } else {
        echo "<h1>Welcome</h1>";
    }

?>
