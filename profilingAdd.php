<?php include "session_config.php"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profiling Add</title>
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
            </li>
              
            <li id="sessionMessage"><a>
                <?php 
                        if (isset($_SESSION["loggedin"]) === true){
                            echo "WELCOME! " . $_SESSION["username"];;
                        }else{
                            header("Location: index.php"); 
                            exit();
                        }

                    ?>
                    </a>
                </li>
                <li><a href="logout.php" class="btn blue">Logout</a></li>
                </li>
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
        <div class="active">
            <li class="sidebar-li">
                <a href="profilingManage.php" class="nav-link">
                    <i class='bx bxs-user-circle icon'></i>
                    <span class="link">Profiling</span>
                </a>
            </li>
        </div>
            <!--child sidebar li-->
            <div class="child-sb">
                
                <li class="child-sidebar-li">
                    <a href="profilingManage.php">
                        <i class='bx bxs-user-detail icon'></i>
                        <span class="child-link">Manage Profile</span> 
                    </a>
                </li>
                <div class="child-active">
                <li class="child-sidebar-li">
                    <a href="profilingAdd.php">
                        <i class='bx bxs-user-plus icon'></i> 
                        <span class="child-link">Add Profile</span> 
                    </a>
                </li></div>
            </div>    

            <!---->
            <li class="sidebar-li">
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







    <div class="main-page">
        <div class="welcome-cont">
            <header class="cont-header"><p class="add">Add</p> <p class="prof"> Profile</p></header>
            
    <form action="" method="post" class="form-main">
        <div class="column">
            <div class="input-box">    
                <label for="">Last Name: </label>
                <input type="text" name="lastname" placeholder="Enter Last Name:" required>
            </div>
            <div class="input-box">
                <label for="">First Name: </label>
                <input type="text" name="firstname" placeholder="Enter First Name" required>
            </div>
            <div class="input-box">
                <label for="">Middle Name (optional): </label>
                <input type="text" name="middlename" placeholder="Enter FULL Middle Name" >
            </div>
        </div>
        <div class="column">
            <div class="input-box">
                <label for="">Age: </label>
                <input type="text" name="age" placeholder="Enter Age" required>
            </div>
            <div class="input-box">
                <label for="">Contact Number: </label>
                <input type="text" name="contactnumber" placeholder="Enter Contact Number" required>
            </div>
        </div>
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
                </select>
            </div>
            <div class="buttons">
                <button type="submit" class="btnAdd" name="submit">Add</button>
                <button type="reset" class="btnRes">Reset</button>
            </div>
    </form>


        </div>
    </div>
    <!--end of main-->
</div>
<script>
    setTimeout(function() {
        window.location.href = 'logout.php'; // Redirect to logout page
    }, <?php echo $timeout * 1000; ?>); // Timeout in milliseconds
</script>
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


<?php
include "dbconnection.php";


if (isset($_POST['submit'])){
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $age = $_POST['age'];
    $contactnum = $_POST['contactnumber'];
    $loc = $_POST['loc'];

    // Check for duplicate entry
    $query = "SELECT * FROM tblmanageprofile WHERE lastname = ? AND firstname = ? AND middlename = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $firstname, $middlename, $lastname);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // No duplicate entry found, proceed with insertion
        $query = "INSERT INTO tblmanageprofile (lastname, firstname, middlename, age, contactnumber, loc) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param("ssssss", $lastname, $firstname, $middlename, $age, $contactnum, $loc);

            if ($stmt->execute()) {
                echo "<script>swal('Done!', 'Profile added successfully!', 'success');</script>";
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        
        echo "<script>swal({
            title: 'Duplicate Found',
            text: 'A duplicate of firstname, lastname, and middlename was found in the database, this is to prevent data duplication',
            icon: 'warning',
          })</script>";
    }
}
?>
