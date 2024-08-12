<?php include "session_config.php"; 
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
                                          <td><a href="responseLogUpdate.php?updateid='<?php echo $items['id']; ?>'"><i class='bx bxs-edit-alt icon-t-edit'></i></a></td>
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
                            //delete
                            if (isset($_GET['id'])){
                                $id = $_GET['id'];
                                $delete = mysqli_query($conn, "DELETE FROM tblreslog WHERE id='$id'");
                            }
                        

                            
                            $query = "SELECT id, codename, disastertype, severity, exactdate, loc FROM tblreslog";
                            $result = $conn->query($query);

                            // Loop through the query result and display data in the table
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . $row["codename"] . "</td>";
                                echo "<td>" . $row["disastertype"] . "</td>";
                                echo "<td>" . $row["severity"] . "</td>";
                                echo "<td>" . $row["exactdate"] . "</td>";
                                echo "<td>" . $row["loc"] . "</td>";
                                echo '<td><a href="responseLogUpdate.php?updateid=' . $row['id'] . '"><i class="bx bxs-edit-alt icon-t-edit"></i></a></td>';
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