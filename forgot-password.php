<?php
include "dbconnection.php";


$username = "";
$oldPassword = "";
$newPassword = "";
$message = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["username"]) && isset($_POST["old_password"]) && isset($_POST["new_password"]) && isset($_POST["passcode_verify"])) {
        $username = $_POST["username"];
        $oldPassword = $_POST["old_password"];
        $newPassword = $_POST["new_password"];
        $password_verify = $_POST["passcode_verify"];

       
       
        $stmt = $conn->prepare("SELECT passcode FROM tblaccount WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $storedPassword = $row["passcode"];

            // Verify the old password
            if (password_verify($oldPassword, $storedPassword)) {
                

                
                if ($newPassword == $password_verify) {
                    // Hash the new password
                    $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                    // Update the password with the hashed new one
                    $stmt = $conn->prepare("UPDATE tblaccount SET passcode = ? WHERE username = ?");
                    $stmt->bind_param("ss", $hashedNewPassword, $username);

                    if ($stmt->execute()) {
                       
                        echo "<script>alert('Profile updated successfully.'); window.location='account-info.php';</script>";
                        exit();
                    } else {
                        $message = "Error updating password: " . $stmt->error;
                    }
                } else {
                    echo "<script>alert('Passwords don't match'); window.location='forgot-password.php';</script>";
                }
            } else {
              echo "<script>alert('Old Password Incorrect'); window.location='forgot-password.php';</script>";
            }
        } else {
          echo "<script>alert('Username not found'); window.location='forgot-password.php';</script>";
        }

        
        $stmt->close();
    }
}


?>



<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <link rel="stylesheet" href="styles/sign-in.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>
    <style>
      
    </style>
  </head>
  <body>
    <div class="wrapper">
      <form method="post" action="forgot-password.php">
        <h1>Change Password</h1>
        <div class="input-box">
          <input type="text" name="username" placeholder="Username" required>
          <i class='bx bx-user'></i>
        </div>
        <div class="input-box">
          <input type="password" name="old_password" placeholder="Old Password" required>
          <i class='bx bxs-lock-alt' ></i>
        </div>
        <div class="input-box">
          <input type="password" name="new_password" placeholder="New Password" required>
          <i class='bx bxs-lock-alt' ></i>
        </div>
        <div class="input-box">
          <input type="password" id="passcode_verify" name="passcode_verify" placeholder="Retype Password" required>
          <i class='bx bxs-lock-alt' ></i>
        </div>
       

        <button type="submit" class="btn" id="changeBtn">Change</button>
       
        <div class="message">
          <?php echo $message; ?>
        </div>
        <div class="register-link">
          <a href="account-info.php">Back</a>
        </div>
      </form>
    </div>

    <script>
      
      <?php if (!empty($message)) { ?>
        document.querySelector('.message').style.display = 'block';
      <?php } ?>
    </script>
  

  </body>
</html>
