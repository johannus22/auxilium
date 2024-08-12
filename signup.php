<?php
include "dbconnection.php";


$strengthMessage = "";
$strengthClass = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["passcode"];
    $password_verify = $_POST["passcode_verify"];
    $adminPassword = $_POST["admin-auth"];


    if ($password === $password_verify) {
       
        $strength = calculatePasswordStrength($password);

        if ($strength >= 66) {
            $strengthMessage = "Strong";
            $strengthClass = "strong";
        } elseif ($strength >= 33) {
            $strengthMessage = "Fair";
            $strengthClass = "fair";
        } else{
            $strengthMessage = "Weak";
            $strengthClass = "weak";
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sqlAdmin = "SELECT passcode FROM tblaccount WHERE power = 'chiefAdmin'";
        $resultAdmin = $conn->query($sqlAdmin);

        if ($resultAdmin->num_rows == 1) {
            $rowAdmin = $resultAdmin->fetch_assoc();
            $adminHashedPassword = $rowAdmin["passcode"];
            
            if (password_verify($adminPassword, $adminHashedPassword)) {
                $sql = "INSERT INTO tblaccount (username, passcode, power) VALUES ('$username', '$hashedPassword', 'subAdmin')";
                if ($conn->query($sql) === true) {
                    header("Location: signin.php");
                    exit();
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                $error_message = "Wrong Chief Admin Password";
            }
        }
    } else {
        $error_message = "</br>Passwords don't match";
    }
}


function calculatePasswordStrength($password) {

    $lengthStrength = strlen($password) / 12 * 100;
    $uppercaseStrength = preg_match("/[A-Z]/", $password) ? 25 : 0;
    $lowercaseStrength = preg_match("/[a-z]/", $password) ? 25 : 0;
    $digitStrength = preg_match("/[0-9]/", $password) ? 25 : 0;
    $specialCharStrength = preg_match("/[^A-Za-z0-9]/", $password) ? 25 : 0;

    $totalStrength = $lengthStrength + $uppercaseStrength + $lowercaseStrength + $digitStrength + $specialCharStrength;
    return $totalStrength;
}
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles/sign-up.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>
  </head>

  <body>
    <div class="wrapper">
      <form method="POST" action="">
        <h1>Register</h1>
        <div class="input-box">
          <input type="text" name="username" placeholder="Username" required>
          <i class='bx bx-user' ></i>
        </div>
        <div class="input-box">
          <input type="password" name="passcode" id="password" placeholder="Password" required>
          <i class='bx bxs-lock-alt' ></i>
        </div>
        
        <div class="input-box">
          <input type="password" name="passcode_verify" placeholder="Retype Password" required>
          <i class='bx bxs-lock-alt' ></i>
        </div>

        <div class="input-box">
          <input type="password" name="admin-auth" placeholder="Chief Admin Password" required>
          <i class='bx bxs-lock-alt' ></i>
        </div>

        <div class="password-strength-bar">
          <div class="password-strength <?php echo $strengthClass; ?>" id="strength"><?php echo $strengthMessage; ?></div>
        </div>

        <button type="submit" class="btn" id="registerBtn">Create</button>

        <div class="error-message">
          <?php echo $error_message; ?>
        </div>


        <div class="login_link">
          Already an admin? <a href="signin.php">Login</a>
        </div>
      </form>
    </div>

<script>
const passwordField = document.getElementById("password");
const registerBtn = document.getElementById("registerBtn");
const strengthField = document.getElementById("strength");

passwordField.addEventListener("input", () => {
    const password = passwordField.value;
    const strength = calculatePasswordStrength(password);

    if (password.length === 0) {
        strengthField.textContent = "";
        strengthField.classList.remove("strong", "fair", "weak");
        registerBtn.disabled = true;
    } else if (strength >= 66) {
        strengthField.textContent = "Strong";
        strengthField.classList = "password-strength strong";
        registerBtn.disabled = false;
    } else if (strength >= 33) {
        strengthField.textContent = "Fair";
        strengthField.classList = "password-strength fair";
        registerBtn.disabled = true;
    } else {
        strengthField.textContent = "Weak";
        strengthField.classList = "password-strength weak";
        registerBtn.disabled = true;
    }
});

function calculatePasswordStrength(password) {
    const lengthStrength = (password.length >= 5) ? 25 : 0;
    const uppercaseStrength = /[A-Z]{2,}/.test(password) ? 25 : 0;
    const lowercaseStrength = /[a-z]{2,}/.test(password) ? 25 : 0;
    const digitStrength = /[0-9]{2,}/.test(password) ? 25 : 0;
    const specialCharStrength = /[^A-Za-z0-9]{1,}/.test(password) ? 25 : 0;

    const totalStrength = lengthStrength + uppercaseStrength + lowercaseStrength + digitStrength + specialCharStrength;
    return totalStrength;
}

</script>
  </body>
</html>