<?php

include "session_config.php"; 
include "dbconnection.php";


if (isset($_GET['updateid'])) {
    $id = $_GET['updateid'];
    $sql = "SELECT * FROM tblaccount WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $username = $row["username"];
    $hashedPassword = $row["passcode"];
} else {
    // Handle this case as needed
}

if (isset($_POST['update'])) {
    $uId = $_POST['update-id'];
    $uUsername = $_POST["u-username"];
    $oldPassword = $_POST["oldPassword"];
    $newPassword = $_POST["newPassword"];
    $newPasswordVerify = $_POST["newPassword-verify"];

    // Verify the old password
    if (password_verify($oldPassword, $hashedPassword)) {
        
        if ($newPassword === $newPasswordVerify) {
            
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $query = "UPDATE tblaccount SET username='$uUsername', passcode='$hashedNewPassword' WHERE id=$uId";
            $result = mysqli_query($conn, $query);

            if ($result) {
                // Update successful
                echo "<script>alert('Profile updated successfully.'); window.location='account-info.php';</script>";
                exit();
            } else {
                echo "<script>alert('Failed to update profile.'); window.location='account-info.php';</script>";
                exit();
            }
        } else {
            echo "<script>alert('New passwords do not match.'); window.location='account-info.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Old password is incorrect.'); window.location='account-info.php';</script>";
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Information</title>
    <link rel="stylesheet" href="styles/acct-info.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <header>
        <nav>
        <div class="logo-container">
            <img src="assets/images/logo.png" alt="logo" class="logo-img">
            <label class="logo">AUXILIUM</label>
        </div>
            <ul>
            <li id="sessionMessage"><a>
                <?php 
                        if (isset($_SESSION["loggedin"]) === true){
                            echo "WELCOME! " . $_SESSION["username"];;
                        }else{
                            header("Location: signin.php"); 
                            exit();
                        }

                    ?>
                    </a>
                </li>
                <li><a href="logout.php" class="btn blue">Logout</a></li>
            </ul>
        </nav>
    </header>
<div class="wrapper">
    <div class="sidebar">
        <ul class="sidebar-ul">
            
            <li class="sidebar-li">
                <a href="dash-home.html" class="nav-link">
                    <i class='bx bxs-home icon'></i>
                    <span class="link">Home</span>
                </a>
            </li>
            <li class="sidebar-li">
                <a href="profilingManage.php" class="nav-link">
                    <i class='bx bxs-user-circle icon'></i>
                    <span class="link">Profiling</span>
                </a>
            </li><li class="sidebar-li">
                <a href="responseLogM.php" class="nav-link">
                    <i class='bx bxs-book icon'></i>
                    <span class="link">Response Log</span>
                </a>
            </li>
            <div class="active">
                <li class="sidebar-li">
                    <a href="account-info.php" class="nav-link">
                    <i class='bx bxs-user-account icon' ></i>
                    <span class="link">Account</span>
                    </a>
                </li>
            </div>
        </ul>
    </div>
        <div class="main-page">
            <div class="welcome-cont">
                <header class="cont-header"><p class="add">Account</p> <p class="prof"> Manager</p></header>
            <div class="table-container">
        <table>
                <thead>
                    <th>Username</th>
                    <th>Role</th>
                    <th colspan="2" class="act-buttons">Actions</th>
                </thead>
                <tbody>
                <?php
                    
                    $query = "SELECT id, username, power FROM tblaccount";
                    $result = $conn->query($query);

                    
                    while ($row = $result->fetch_assoc()) {
                       echo "<tr>";
                       echo "<td>" . $row["username"] . "</td>";
                       echo "<td>" . $row["power"] . "</td>";
                    if($row["power"] == "chiefAdmin"){
                            echo '<td><a><i class="bx bxs-lock-open icon-t-edit"></i></a></td>';
                            echo "<td><a><i class='bx bxs-trash icon-t-del'></i></a></td>";
                            echo "</tr>";
                       }else{
                            echo '<td><i class="bx bxs-lock-open icon-t-edit"></i></a></td>';
                            echo "<td><a><i class='bx bxs-trash icon-t-del'></i></a></td>";
                            echo "</tr>";
                       }

                    }
                    ?>
                </tbody>
        </table> 
            </div>
        </div>
    </div> 
</div>
<!--wrapper end-->


<div class="popup" id="popup">
        <div class="popup-cont">
            <header class="cont-header"><p class="add">Edit </p> <p class="prof"> Profile</p></header>
            <form action="accountUpdate.php" method="post" class="form-main">
                <input type="hidden" name="update-id" value="<?php echo $id; ?>">
            <div class="column">
                <div class="input-box">    
                    <label for="">Username: </label>
                    <input type="text" name="u-username" placeholder="Enter Username:" value="<?php echo "$username";?>" required>
                </div>
                <div class="input-box">
                    <label for="">Old Password: </label>
                    <input type="password" name="oldPassword" placeholder="Enter New Password" required>
                </div>
            </div>
            <div class="column">
                <div class="input-box">    
                    <label for="">New Password: </label>
                    <input type="password" name="newPassword" placeholder="Enter New Password">
                </div>
                <div class="input-box">
                    <label for="">Re-type New Password: </label>
                    <input type="password" name="newPassword-verify" placeholder="Re-type New Password">
                </div>
            </div>
                <div class="buttons">
                <button type="submit" class="btnAdd" name="update">Update</button>
                    <button type="button" onclick="location.href='account-info.php';" class="btnRes">Close</button>
                    </div>
               </form>
            </div>
        </div>




        <script>

var sessionMessage = document.getElementById("sessionMessage");

if (sessionMessage) {
    
    setTimeout(function() {
        sessionMessage.style.display = "none";
    }, 5000);
}
</script>
</body>
</html>


