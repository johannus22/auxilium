<?php include "session_config.php"; 
?>
<?php


include "dbconnection.php";



if (isset($_GET['updateid'])) {
    $id = $_GET['updateid'];
    $sql="SELECT * FROM tblreslog WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $codename= $row["codename"];
    $disastertype = $row["disastertype"];
    $severity = $row["severity"];
    $exactdate= $row["exactdate"];
    $location= $row["loc"];
} else {

}


if (isset($_POST['update'])) {
    $uId = $_POST['update-id'];
    $uCodename = $_POST['u-codename'];
    $uDisastertype = $_POST['u-disastertype'];
    $uSeverity = $_POST['u-severity'];
    $uDate = $_POST['u-date'];
    $uLoc = $_POST['u-loc'];


    $query = "UPDATE tblreslog SET codename='$uCodename', disastertype='$uDisastertype', severity='$uSeverity', exactdate='$uDate', loc='$uLoc' WHERE id=$uId";
    $result = mysqli_query($conn, $query);

    if ($result) {

    } else {
        $_SESSION['error_message'] = "Failed to update profile.";
    }

    header("Location: responseLogM.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Response Log Management</title>
    <link rel="stylesheet" href="styles/responseLogM.css">
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
                            echo "WELCOME!," . $_SESSION["username"];;
                        }else{
                            header("Location: index.php"); 
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
            </li>
        <div class="active">  
            <li class="sidebar-li">
                <a href="responseLogM.php" class="nav-link">
                    <i class='bx bxs-book icon'></i>
                    <span class="link">Response Log</span>
                </a>
            </li></div>
            <!--child sidebar li-->
            <div class="child-sb">
                <div class="child-active">
                <li class="child-sidebar-li">
                    <a href="responseLogM.php">
                        <i class='bx bxs-edit-alt icon'></i>
                        <span class="child-link">Manage Records</span> 
                    </a>
                </li></div>
                
                <li class="child-sidebar-li">
                    <a href="responseLogA.php">
                        <i class='bx bxs-book-add icon'></i>
                        <span class="child-link">Add Record</span> 
                    </a>
                </li>
            </div>    

            <!---->
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
            <header class="cont-header"><p class="add">Manage</p> <p class="prof"> Disaster Records</p></header>
        <div class="table-container">
            <!--search bar-->
            <div class="search-result">
                <form action="" method="get" class="form-search">
                 <div class="input-box">
                <input type="text" name="search" value="<?php if(isset($_GET['search'])){echo $_GET['search'];} ?>" class="search-query" placeholder="Search a Disaster Response" required>
               </div>
               <button type="submit" class="search">Search</button>
                 </form>
            </div>
        <!--search bar end-->
            <table>
                <thead>
                    <th>ID</th>
                    <th>CodeName</th>
                    <th>Disaster Type</th>
                    <th>Severity</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th colspan="2" class="act-buttons">Actions</th>
                </thead>
                <tbody>
                <?php
                    include "dbconnection.php";

                        if (isset($_GET['search'])) {
                                $filtervalues = $_GET['search'];
                                $query = "SELECT * FROM tblreslog WHERE CONCAT(codename, disastertype, severity) LIKE '%$filtervalues%'";
                                $query_run = mysqli_query($conn, $query);

                               if (mysqli_num_rows($query_run) > 0) {
                                    foreach ($query_run as $items) {
                                       ?>
                                       <tr>
                                           <td><?= $items['id']; ?></td>
                                          <td><?= $items['codename']; ?></td>
                                          <td><?= $items['disastertype']; ?></td>
                                          <td><?= $items['severity']; ?></td>
                                          <td><?= $items['exactdate']; ?></td>
                                          <td><?= $items['loc']; ?></td>
                                          <td><a href='responseLogUpdate.php?updateid=<?= $items["id"] ?>'><i class='bx bxs-edit-alt icon-t-edit'></i></a></td>
                                          <?php echo "<td><a onclick=\"javascript:return confirm('Delete this Record?');\" href='responseLogM.php?id=" . $items['id'] . "'><i class='bx bxs-trash icon-t-del'></i></a></td>"; ?>
                                      </tr>
                                      <?php
                                   }
                                   echo "<tr><td colspan='8' align='center'>End of Search Results</td></tr>";
                               } else {
                                   ?>
                                    <tr>
                                       <td colspan="8">No Records Found</td>
                                    </tr>
                                   <?php
                                }
                            }
                            ?>


                <!--end of search results-->

                            <?php

                            include "dbconnection.php";
                            

                            $query = "SELECT id, codename, disastertype, severity, exactdate, loc FROM tblreslog";
                            $result = $conn->query($query);

                     
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . $row["codename"] . "</td>";
                                echo "<td>" . $row["disastertype"] . "</td>";
                                echo "<td>" . $row["severity"] . "</td>";
                                echo "<td>" . $row["exactdate"] . "</td>";
                                echo "<td>" . $row["loc"] . "</td>";
                                echo '<td><a href="responseLogUpdate.php?updateid=<?= $items["id"] ?>"><i class="bx bxs-edit-alt icon-t-edit"></i></a>';
                                echo "<td><a onclick=\" javascript:return confirm('Delete this Response?');\" href='responseLogM.php?id=" . $row['id'] . "'><i class='bx bxs-trash icon-t-del'></i></a></td>";
                                echo "</tr>";

                                
                            }
                            ?>
                    
                            
                          
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
    </div>

</div>
<!--wrapper-->

<div class="popup" id="popup">
        <div class="popup-cont">
            <header class="cont-header"><p class="add">Edit </p> <p class="prof"> Profile</p></header>
            <form action="responseLogUpdate.php" method="post" class="form-main">
                <input type="hidden" name="update-id" value="<?php echo $id; ?>">
                <div class="column">
                <div class="input-box">    
                    <label for="">CodeName: </label>
                    <input type="text" name="u-codename" placeholder="Enter Name:" value="<?php echo "$codename";?>">
                </div>
                <div class="input-box">
                    <label for="">Disaster Type: </label>
                    <input type="text" name="u-disastertype" placeholder="Enter Disaster Type" value="<?php echo "$disastertype";?>" required>
                </div>
                <div class="input-box">
                    <label for="">Severity </label>
                    <select name="u-severity" required>
                        <option value="Low" <?php if ($severity === 'Low') echo 'selected'; ?>>Low</option>
                        <option value="Medium" <?php if ($severity === 'Medium') echo 'selected'; ?>>Medium</option>
                        <option value="High" <?php if ($severity === 'High') echo 'selected'; ?>>High</option>
                    </select>
                </div>
                <div class="input-box">    
                    <label for="">Date: </label>
                    <input type="date" name="u-date" placeholder="Choose Date" value="<?php echo "$exactdate";?>">
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
                        <option value="Whole Candelaria" <?php if ($location === 'Whole Candelaria') echo 'selected'; ?>>Whole Candelaria</option>
                    </select>
                </div>
                <div class="buttons">
                <button type="submit" class="btnAdd" name="update">Update</button>
                    <button type="button" onclick="location.href='responseLogM.php';" class="btnRes">Close</button>
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