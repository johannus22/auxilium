<?php include "session_config.php"; 
?>
<?php

include "dbconnection.php";



if (isset($_GET['updateid'])) {
    $id = $_GET['updateid'];
    $sql="SELECT * FROM tblmanageprofile WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $lastname= $row["lastname"];
    $firstname= $row["firstname"];
    $middlename=$row["middlename"];
    $age=$row["age"];
    $contactnumber=$row["contactnumber"];
    $location=$row["loc"];
} else {

}

if (isset($_POST['update'])) {
    $uId = $_POST['update-id'];
    $uLastname = $_POST['u-lastname'];
    $uFirstname = $_POST['u-firstname'];
    $uMiddlename = $_POST['u-middlename'];
    $uAge = $_POST['u-age'];
    $uContactnumber = $_POST['u-contactnumber'];
    $uLoc = $_POST['u-loc'];


    $query = "UPDATE tblmanageprofile SET lastname='$uLastname', firstname='$uFirstname', middlename='$uMiddlename', age='$uAge', contactnumber='$uContactnumber', loc='$uLoc' WHERE id=$uId";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['success_message'] = "Profile updated successfully.";
        
    } else {
        $_SESSION['error_message'] = "Failed to update profile.";
    }

    
    header("Location: profilingManage.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profiling Management</title>
    <link rel="stylesheet" href="styles/profilingM.css">
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
                    <div class="child-active">
                        <li class="child-sidebar-li">
                            <a href="profilingManage.php">
                                <i class='bx bxs-user-detail icon'></i>
                                <span class="child-link">Manage Profile</span> 
                            </a>
                        </li>
                    </div>
                    <li class="child-sidebar-li">
                        <a href="profilingAdd.php">
                            <i class='bx bxs-user-plus icon'></i> 
                            <span class="child-link">Add Profile</span> 
                        </a>
                    </li>
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
        <!--sidebar end-->
        <div class="main-page">
            <div class="welcome-cont">
                <header class="cont-header">
                    <p class="add">Manage</p>
                    <p class="prof"> Profiles</p>
                </header>
                <div class="table-container">
            <!--search bar -->
            <div class="search-result">
                <form action="" method="get" class="form-search">
                 <div class="input-box">
                <input type="text" name="search" value="<?php if(isset($_GET['search'])){echo $_GET['search'];} ?>" class="search-query" placeholder="Search a Profile" required>
               </div>
               <button type="submit" class="search">Search</button>
                 </form>
            </div>



                <!--search-->
                    <table>
                        <thead>
                            <th>ID</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Age</th>
                            <th>Contact Number</th>
                            <th>Location</th>
                            <th colspan="2" class="act-buttons">Actions</th>
                        </thead>
                        <tbody>

                            <?php
                                include "dbconnection.php";

                                if (isset($_GET['search'])) {
                                    $filtervalues = $_GET['search'];
                                   $query = "SELECT * FROM tblmanageprofile WHERE CONCAT(lastname, firstname, middlename) LIKE '%$filtervalues%'";
                                   $query_run = mysqli_query($conn, $query);
                                
                                  if (mysqli_num_rows($query_run) > 0) {
                                      foreach ($query_run as $items) {
                                          ?>
                                          <tr>
                                              <td><?= $items['id']; ?></td>
                                              <td><?= $items['lastname']; ?></td>
                                             <td><?= $items['firstname']; ?></td>
                                             <td><?= $items['middlename']; ?></td>
                                             <td><?= $items['age']; ?></td>
                                             <td><?= $items['contactnumber']; ?></td>
                                             <td><?= $items['loc']; ?></td>
                                               <td><a href="profilingUpdate.php"><i class='bx bxs-edit-alt icon-t-edit'></i></a></td>
                                              <?php echo "<td><a onclick=\"javascript:return confirm('Delete this Profile?');\" href='profilingManage.php?id=" . $items['id'] . "'><i class='bx bxs-trash icon-t-del'></i></a></td>"; ?>
                                           </tr>
                                           <?php
                                      }
                                       echo "<tr><td colspan='9' align='center'>End of Search Results</td></tr>";
                                   } else {
                                      ?>
                                      <tr>
                                            <td colspan="9">No Records Found</td>
                                        </tr>
                                       <?php
                                    }
                                }
                                ?>


                <!--end of search results-->
                           
                            <?php
                            
                            
                            include "dbconnection.php";

                            
                            $query = "SELECT id, lastname, firstname, middlename, age, contactnumber, loc FROM tblmanageprofile";
                            $result = $conn->query($query);

                            
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] ."</td>";
                                echo "<td>" . $row["lastname"] . "</td>";
                                echo "<td>" . $row["firstname"] . "</td>";
                                echo "<td>" . $row["middlename"] . "</td>";
                                echo "<td>" . $row["age"] . "</td>";
                                echo "<td>" . $row["contactnumber"] . "</td>";
                                echo "<td>" . $row["loc"] . "</td>";
                                echo '<td><a href="profilingUpdate.php?updateid=<?= $items["id"] ?>"><i class="bx bxs-edit-alt icon-t-edit"></i></a>';
                                echo "<td><a href='profilingManage.php'><i class='bx bxs-trash icon-t-del'></i></a></td>";
                                echo "</tr>";

                                
                            }
                            ?>



                                    
                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="popup" id="popup">
        <div class="popup-cont">
            <header class="cont-header"><p class="add">Edit </p> <p class="prof"> Profile</p></header>
            <form action="profilingUpdate.php" method="post" class="form-main">
                <input type="hidden" name="update-id" value="<?php echo $id; ?>">
                <div class="column">
                    <div class="input-box">    
                        <label for="">Last Name: </label>
                        <input type="text" name="u-lastname" placeholder="Enter Last Name:" value="<?php echo $lastname; ?>" required>
                    </div>
                    <div class="input-box">
                        <label for="">First Name: </label>
                        <input type="text" name="u-firstname" placeholder="Enter First Name" value="<?php echo $firstname; ?>" required>
                    </div>
                    <div class="input-box">
                        <label for="">Middle Name (optional): </label>
                        <input type="text" name="u-middlename" placeholder="Enter FULL Middle Name" value="<?php echo $middlename; ?>">
                    </div>
                </div>
                <div class="column">
                    <div class="input-box">
                        <label for="">Age: </label>
                        <input type="text" name="u-age" placeholder="Enter Age" value="<?php echo $age; ?>" required>
                    </div>
                    <div class="input-box">
                        <label for="">Contact Number: </label>
                        <input type="text" name="u-contactnumber" placeholder="Enter Contact Number" value="<?php echo $contactnumber; ?>" required>
                    </div>
                </div>
                <div class="input-box">
                    <label>Location: </label>
                    <select name="u-loc" required>
                        <option value="Buenavista East" <?php if ($location === 'Buenavista East') echo 'selected'; ?>>Buenavista East</option>
                        <option value="Buenavista West" <?php if ($location === 'Buenavista West') echo 'selected'; ?>>Buenavista West</option>
                        <option value="Bukal Norte" <?php if ($location === 'Bukal Norte') echo 'selected'; ?>>Bukal Norte</option>
                        <option value="Bukal sur" <?php if ($location === 'Bukal sur') echo 'selected'; ?>>Bukal sur</option>
                        <option value="Kinatihan I" <?php if ($location === 'Kinatihan I') echo 'selected'; ?>>Kinatihan I</option>
                        <option value="Kinatihan II" <?php if ($location === 'Kinatihan II') echo 'selected'; ?>>Kinatihan II</option>
                        <option value="Malabanban Norte" <?php if ($location === 'Malabanban Norte') echo 'selected'; ?>>Malabanban Norte</option>
                        <option value="Malabanban sur" <?php if ($location === 'Malabanban sur') echo 'selected'; ?>>Malabanban sur</option>
                        <option value="Mangilag Norte" <?php if ($location === 'Mangilag Norte') echo 'selected'; ?>>Mangilag Norte</option>
                        <option value="Manglag sur" <?php if ($location === 'Manglag sur') echo 'selected'; ?>>Manglag sur</option>
                        <option value="Masalukot I" <?php if ($location === 'Masalukot I') echo 'selected'; ?>>Masalukot I</option>
                        <option value="Masalukot II" <?php if ($location === 'Masalukot II') echo 'selected'; ?>>Masalukot II</option>
                        <option value="Masalukot III" <?php if ($location === 'Masalukot III') echo 'selected'; ?>>Masalukot III</option>
                        <option value="Masalukot IV" <?php if ($location === 'Masalukot IV') echo 'selected'; ?>>Masalukot IV</option>
                        <option value="Masalukot V" <?php if ($location === 'Masalukot V') echo 'selected'; ?>>Masalukot V</option>
                        <option value="Masin Norte" <?php if ($location === 'Masin Norte') echo 'selected'; ?>>Masin Norte</option>
                        <option value="Masin Sur" <?php if ($location === 'Masin Sur') echo 'selected'; ?>>Masin Sur</option>
                        <option value="Mayabobo" <?php if ($location === 'Mayabobo') echo 'selected'; ?>>Mayabobo</option>
                        <option value="Pahinga Norte" <?php if ($location === 'Pahinga Norte') echo 'selected'; ?>>Pahinga Norte</option>
                        <option value="Pahinga sur" <?php if ($location === 'Pahinga sur') echo 'selected'; ?>>Pahinga sur</option>
                        <option value="Poblacion" <?php if ($location === 'Poblacion') echo 'selected'; ?>>Poblacion</option>
                        <option value="San Andres" <?php if ($location === 'San Andres') echo 'selected'; ?>>San Andres</option>
                        <option value="San Isidro" <?php if ($location === 'San Isidro') echo 'selected'; ?>>San Isidro</option>
                        <option value="Sta. Catalina Norte" <?php if ($location === 'Sta. Catalina Norte') echo 'selected'; ?>>Sta. Catalina Norte</option>
                        <option value="Sta. Catalina sur" <?php if ($location === 'Sta. Catalina sur') echo 'selected'; ?>>Sta. Catalina sur</option>
                        
                    </select>

                </div>
                <div class="buttons">
                    <button type="submit" class="btnAdd" name="update">Update</button>
                    <button type="button" onclick="location.href='profilingManage.php';" class="btnRes">Close</button>
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
