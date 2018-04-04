<?php 
    require_once('../functions/connection.php');
    require_once('../functions/sessions.php'); 
?>

<?php

    global $conn;

    if(isset($_SESSION['id'])){
        if($_SESSION['usertype'] == 'student'){
            echo "<script>window.location.href='../denied.php';</script>";
        }
        else if($_SESSION['usertype'] == 'parent'){
            echo "<script>window.location.href='../denied.php';</script>";
        }
        else{
            $userid = $_SESSION['id'];

            $retrieveUserInfoQuery = "SELECT * FROM tbl_account WHERE userid='$userid'";

            $result = mysqli_query($conn, $retrieveUserInfoQuery);

            while($DataRows = mysqli_fetch_assoc($result)){
                $fname = $DataRows['fname'];
                $profileimg = $DataRows['profileimg'];
            }
        }
    }
    else{
        echo "<script>window.location.href='../login.php';</script>";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>| NNHS</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" href="../favicon.png">

        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link href="../fonts/webfonts/fontawesome-all.css" rel="stylesheet">
        <link rel="stylesheet" href="../gijgo/css/gijgo.min.css">
        <link rel="stylesheet" href="../css/style.css">

        <script src="../jquery/dist/jquery.min.js"></script>
        <script src="../jquery/dist/jquery.slim.min.js"></script>
        <script src="../popper.js/dist/popper.min.js"></script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script src="../gijgo/js/gijgo.min.js"></script>
    </head>
    <body>
        <section id="teacher-panel-header">
            <div class="overlay">
            <nav class="navbar navbar-expand-lg p-0 navigation sticky-top">
                <div class="container">
                    <a href="" class="navbar-brand brand mt-3 mr-5">
                        <img src="../img/brand-pic.png" alt="" width="150px" class="mb-3">
                    </a>

                    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNav">
                        <span> </span>
                        <span> </span>
                        <span> </span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item mr-3">
                                <a href="#header" class="nav-link active link"><i class="far fa-comments"></i></a>
                            </li>

                            <li class="nav-item mr-3">
                                <a href="#about" class="nav-link link"><i class="far fa-bell"></i></a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle user-option" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="uploads/<?php echo $profileimg; ?>" alt="" class="profile-img">
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#">Welcome <?php echo $fname.'!'; ?></a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="../logout.php">Logout</a>
                                </div>
                            </li>
                            <!-- <li class="nav-item mr-3">
                                <a href="#developer" class="nav-link link"><i class="far fa-user"></i> <i class="fas fa-angle-down"></i></a>
                            </li> -->
                        </ul>
                    </div>
                </div>
            </nav>
          </div>
        </section>

        <section id="teacher-menu">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-center mb-5" style="width: 100%;">
                            <div class="card-header">
                                <p class="lead">MANAGE SUBJECT</p>
                            </div>
                            <img class="card-img-top" src="../img/mng-subj-btn-bg.jpg" alt="Card image cap">
                            
                            <div class="card-footer">
                                <a href="manage-subj-panel.php" class="btn btn-submit btn-block btn-lg">Manage</a>
                            </div>
                          </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card text-center mb-5" style="width: 100%;">
                            <div class="card-header">
                                <p class="lead">MANAGE PROFILE</p>
                            </div>
                            <img class="card-img-top" src="../img/mng-prfle-btn-bg.jpg" alt="Card image cap">
                            
                            <div class="card-footer">
                                <a href="manage-profile-panel.php" class="btn btn-submit btn-block btn-lg">Manage</a>
                            </div>
                          </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card text-center mb-5" style="width: 100%;">
                            <div class="card-header">
                                <p class="lead">MANAGE REPORT</p>
                            </div>
                            <img class="card-img-top" src="../img/mng-stud-btn-bg.jpg" alt="Card image cap">
                            
                            <div class="card-footer">
                                <a href="manage-report-panel.php" class="btn btn-submit btn-block btn-lg">Manage</a>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
        </section>

        <footer id="main-footer">
            <div class="container">
                <div class="row">
                    <div class="col text-center my-3">
                    <img src="../img/brand-pic.png" alt="nnhs-logo" class="img-fluid" width="80px">
                    <p class="cdate" style="font-size: 15px; display:inline-block;">&copy; <?php echo date('Y');?></p>
                    </div>
                </div>
            </div>
        </footer>

        <a href="javascript:" id="return-to-top" class="top-arr">
            <i class="fas fa-chevron-up"></i>
        </a>

        <script src="../js/index.js"></script>
        <script src='../js/jquery-3.3.1.min.js'></script>
    </body>
</html>