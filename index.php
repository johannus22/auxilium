<?php
include "dbconnection.php";


$username = "";
$passcode = "";
$error_message = "";



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $passcode = $_POST["passcode"];


    $sql = "SELECT * FROM tblaccount WHERE username = '$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row["passcode"];
        $userRole = $row["power"];
        
        if (password_verify($passcode, $hashedPassword)) {

          session_start();
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $username;
            $_SESSION["user_power"] = $userRole;
            
            header("Location: dash-home.php"); 
            exit();
        }
    }


    $error_message = "Invalid username or password.";
}
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="styles/sign-in.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  </head>
  
  <body>
    <div class="wrapper">
      <form method="POST" action="">
        <h1>AUXILIUM</h1>
        <div class="input-box">
          <input type="text" name="username" placeholder="Username" required>
          <i class='bx bx-user' ></i>
        </div>
        <div class="input-box">
          <input type="password" name="passcode" placeholder="Password" required>
          <i class='bx bxs-lock-alt' ></i>
        </div>


        <button type="submit" class="btn">Login</button>

        <div class="error-message">
          <?php echo $error_message; ?>
        </div>

        <div class="register-link">
          <p>Don't have an account?</p>
          <a href="signup.php">Register as sub-Admin</a>
        </div>
      </form>
    </div>
  </body>
</html>

