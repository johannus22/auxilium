<?php include "session_config.php"; 
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
                                             <td><a href="profilingUpdate.php?updateid='<?php echo $items['id']; ?>'"><i class='bx bxs-edit-alt icon-t-edit'></i></a></td>
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
                            //delete
                            if (isset($_GET['id'])){
                                $id = $_GET['id'];
                                $delete = mysqli_query($conn, "DELETE FROM tblmanageprofile WHERE id='$id'");
                            }


                            
                            $query = "SELECT id, lastname, firstname, middlename, age, contactnumber, loc FROM tblmanageprofile";
                            $result = $conn->query($query);

                            // Loop through the query result and display data in the table
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] ."</td>";
                                echo "<td>" . $row["lastname"] . "</td>";
                                echo "<td>" . $row["firstname"] . "</td>";
                                echo "<td>" . $row["middlename"] . "</td>";
                                echo "<td>" . $row["age"] . "</td>";
                                echo "<td>" . $row["contactnumber"] . "</td>";
                                echo "<td>" . $row["loc"] . "</td>";
                                echo '<td><a href="profilingUpdate.php?updateid=' . $row['id'] . '"><i class="bx bxs-edit-alt icon-t-edit"></i></a></td>';
                                echo "<td><a onclick=\" javascript:return confirm('Delete this Profile?');\" href='profilingManage.php?id=" . $row['id'] . "'><i class='bx bxs-trash icon-t-del'></i></a></td>";
                                echo "</tr>";

                                
                            }
                            ?>


                                                        


                            
                                    
                        
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
