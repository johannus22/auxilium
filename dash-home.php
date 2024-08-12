<?php include "session_config.php"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard-Home</title>
    <link rel="stylesheet" href="/AUXILIUM/styles/dash-home.css">
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
            <div class="active">
                <li class="sidebar-li">
            
                    <a href="dash-home.php" class="nav-link">
                        <i class='bx bxs-home icon'></i>
                        <span class="link">Home</span>
                    </a>
                </li>
            </div>
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
                <li class="sidebar-li">
                    <a href="smsSys.php" class="nav-link">
                        <i class='bx bxs-message-dots icon'></i>
                        <span class="link">SMS</span>
                    </a>
                </li>
        </ul>
    </div>
    <!--SIDEBAR END-->

        <div class="main-page">
        <div class="welcome-cont">
                <h1>MDRRMO</h1>
                <p>Municipal Disaster Risk Reduction and Management Office is to ensure the successful and efficient execution of civil protection programs by the use of an integrated strategy and tactics that are community-based, multi-sectoral, and multi-disciplinary. This is done with the intention of protecting and preserving people's lives as well as property and the natural environment. AUXILIUM is a comprehensive framework designed to enhance disaster preparation and response capabilities. The primary goal of this program is to mitigate the adverse effects of imminent natural disasters by enhancing the degree of preparation among its users. The act of adequately preparing for a catastrophic event not only reduces the probability of experiencing casualties during an emergency situation, but it also conserves valuable resources in terms of time and finances. These resources are crucial elements in the process of both preparing for and responding to disasters. The system incorporates a profiling component that securely stores the personal information of family members inside a safeguarded database.  Furthermore, this system has a messaging component that is integrated into its framework. The objective of this integrated system is to effectively disseminate critical information by transmitting text messages to the mobile phone numbers that have been entered into the database. This web based system of AUXILIUM is created by John Rafael P. Masilungan and Riggs Christian M. Ramos</p>
            </div>
        <div class="welcome-cont">
            <h2>Contact</h2>
            <p>jmasilungan22@gmail.com</p>
            
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