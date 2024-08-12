<?php include "session_config.php"; 
?>


<?php
if (isset($_POST['send'])) {
    
    include "dbconnection.php";
    
    $selectedLocation = $_POST['loc'];

    $sql = "SELECT contactnumber FROM tblmanageprofile WHERE loc = '$selectedLocation'";


    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<div class='contact-numbers'>";
        while ($row = $result->fetch_assoc()) {
            echo "<p>Contact Number: " . $row['contactnumber'] . "</p>";
        }
        echo "</div>";
    } else {
        echo "No contact numbers found for the selected location.";
    }

    $conn->close();
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
                <a href="dash-home.php" class="nav-link">
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
            <li class="sidebar-li">
                    <a href="smsSys.php" class="nav-link">
                        <i class='bx bxs-message-dots icon'></i>
                        <span class="link">SMS</span>
                    </a>
                </li>
        </ul>
    </div>






    <div class="main-page">
        <div class="welcome-cont">
            <header class="cont-header"><p class="add">Account</p> <p class="prof"> Manager</p></header>
        <div class="table-container">
            <?php
        if ($_SESSION["user_power"] !== "chiefAdmin") {
                        echo "<p class='permission'>You don't have the permission to access this page.<p>";
                        echo "<li><a href='dash-home.php' class='forgot-password'>Back to home</a></li>";
                        exit();
                    }?>
            <a href="forgot-password.php" class="forgot-password">Change a Password</a>
        <table>
                <thead>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                <?php

                    include "dbconnection.php";
                    //delete
                    if (isset($_GET['id'])){
                        $id = $_GET['id'];

                        if ($id != '1'){
                            $delete = mysqli_query($conn, "DELETE FROM tblaccount WHERE id='$id'");
                        }else{
                            header("Location: dash-home.php"); 
                            exit();
                        }
                        
                        
                    }
                    $query = "SELECT id, username, power FROM tblaccount";
                    $result = $conn->query($query);

                    
                    while ($row = $result->fetch_assoc()) {

                    
                       echo "<tr>";
                       echo "<td>" . $row["username"] . "</td>";
                       echo "<td>" . $row["power"] . "</td>";

                    
                    if($row["id"] == "1"){
                            echo "<td><a onclick=\" javascript:return alert('You can't delete a Chief Administrator Account!');\"'><i class='bx bxs-trash icon-t-del'></i></a></td>";
                            echo "</tr>";
                       }else{
                            echo "<td><a onclick=\" javascript:return confirm('Delete this Account?');\" href='account-info.php?id=" . $row['id'] . "'><i class='bx bxs-trash icon-t-del'></i></a></td>";
                            echo "</tr>";   
                       }

                    }
                    ?>
                </tbody>
        </table>



        
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