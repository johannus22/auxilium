<?php include "session_config.php"; 
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

// Load the .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Now you can access the environment variables
$apiKey = $_ENV['API_KEY'];

?> 
<?php
if (isset($_POST['send'])) {

    include "dbconnection.php";
    include "includes/smsAPIController.php";

    $selectedLocation = $_POST['loc'];
    $getMessage = $_POST['message'];


    $sql = "SELECT contactnumber FROM tblmanageprofile WHERE loc = '$selectedLocation'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            
            $contactnumber = $row['contactnumber'];
            $message = $getMessage;

            $send = new smsAPIController();

            $send->semaphore($apiKey, $contactnumber, $message);

            if ($send == false) {
                echo'server no response';
                header('location:smsSys.php?error=semaphore: no response from server');
                exit();
            }elseif ($send == true) {
                echo'sent!';
                echo '<script>alert("Sent Successfully");</script>';
                header('location:smsSys.php?error=none');
                exit();
            }else{
                echo'something went wrong';
                header('location:smsSys.php?error=something wrong happened');
                exit();
            }



        }
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
    <title>SMS</title>
    <link rel="stylesheet" href="styles/profilingA.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
                            header("Location:index.php"); 
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
            
                <li class="sidebar-li">
                    <a href="account-info.php" class="nav-link">
                    <i class='bx bxs-user-account icon' ></i>
                    <span class="link">Account</span>
                    </a>
                </li>
            <div class="active">
                <li class="sidebar-li">
                    <a href="smsSys.php" class="nav-link">
                        <i class='bx bxs-message-dots icon'></i>
                        <span class="link">SMS</span>
                    </a>
                </li>
            </div>
        </ul>
    </div>






    <div class="main-page">
        <div class="welcome-cont">
            <header class="cont-header"><p class="add">Send</p> <p class="prof"> Text Messages </p></header>
            
    <form action="" method="post" class="form-main">
        <div class="column">
            <div class="input-box">
                <label>Location: </label>
                <select name="loc" required>
                <option value="0" selected>Click to Select Location</option>
                <option value="Buenavista East">Buenavista East</option>
                <option value="Buenavista West">Buenavista West</option>
                <option value="Bukal Norte">Bukal Norte</option>
                <option value="Bukal sur">Bukal sur</option>
                <option value="Kinatihan I">Kinatihan I</option>
                <option value="Kinatihan II">Kinatihan II</option>
                <option value="Malabanban Norte">Malabanban Norte</option>
                <option value="Malabanban sur">Malabanban sur</option>
                <option value="Mangilag Norte">Mangilag Norte</option>
                <option value="Manglag sur">Manglag sur</option>
                <option value="Masalukot I">Masalukot I</option>
                <option value="Masalukot II">Masalukot II</option>
                <option value="Masalukot III">Masalukot III</option>
                <option value="Masalukot IV">Masalukot IV</option>
                <option value="Masalukot V">Masalukot V</option>
                <option value="Masin Norte">Masin Norte</option>
                <option value="Masin Sur">Masin Sur</option>
                <option value="Mayabobo">Mayabobo</option>
                <option value="Pahinga Norte">Pahinga Norte</option>
                <option value="Pahinga sur">Pahinga sur</option>
                <option value="Poblacion">Poblacion</option>
                <option value="San Andres">San Andres</option>
                <option value="San Isidro">San Isidro</option>
                <option value="Sta. Catalina Norte">Sta. Catalina Norte</option>
                <option value="Sta. Catalina sur">Sta. Catalina sur</option>
                <option value="Whole Candelaria">Whole Candelaria</option>
                </select>
            </div>
        </div>
            <div class="input-box">
                <label for="">Text Message: </label>
                <textarea type="text" name="message" rows="30" required>Enter text message here:</textarea>
            </div>


            <div class="buttons">
                <button type="submit" class="btnAdd" name="send">Send</button>
                <button type="reset" class="btnRes">Reset</button>
            </div>
    </form>


        </div>
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