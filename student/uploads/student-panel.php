<?php 
    require_once('../functions/connection.php');
    require_once('../functions/sessions.php'); 
?>

<?php

    global $conn;

    if(isset($_SESSION['id'])){
        if($_SESSION['usertype'] == 'teacher'){
            echo "<script>window.location.href='../denied.php';</script>";
        }
        else if($_SESSION['usertype'] == 'parent'){
            echo "<script>window.location.href='../denied.php';</script>";
        }
        else{
            $userid = $_SESSION['id'];
            $profileimg = $_SESSION['profileimg'];
            $enrollmentid = $_SESSION['enrollment_id'];

            $retrieveUserInfoQuery = "SELECT * FROM tbl_account WHERE userid='$userid'";

            $result = mysqli_query($conn, $retrieveUserInfoQuery);

            while($DataRows = mysqli_fetch_assoc($result)){
                $fname = $DataRows['fname'];
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
                        <img src="../img/nnhs-lms-logo.png" alt="" width="70px" class="mb-3">
                    </a>

                    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNav">
                        <span> </span>
                        <span> </span>
                        <span> </span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item mr-5">
                                <a href="manage-subj-panel-student.php" class="nav-link active link"><i class="fas fa-book" style="font-size: 20px;"></i>&nbsp;&nbsp;Subject</a>
                            </li>

                            <li class="nav-item mr-3">
                                <a href="#" class="nav-link link"><i class="fas fa-archive" style="font-size: 20px;"></i>&nbsp;&nbsp;Repository</a>
                            </li>
                        </ul>

                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item mr-3">
                                <a href="#header" class="nav-link active link"><i class="far fa-comments"></i></a>
                            </li>

                            <li class="nav-item mr-3">
                                <a href="#about" class="nav-link link"><i class="far fa-bell"></i></a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle user-option" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="../uploads/<?php echo $profileimg; ?>" alt="" class="profile-img">
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

        <section id="teacher-menu" class="mb-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <a href="manage-blotter.php">
                            <div class="card text-center mb-3" style="width: 100%;">
                                <div class="card-header count-header-cont" style="background-color: #F39C12;">
                                    <h5 class="card-title count-title">Subjects enrolled:</h5>
                                </div>
                                <div class="card-body count-blotter">
                                    <p class="card-text count-lbl"><i class="fas fa-clipboard link-icon"></i>&nbsp;&nbsp;5</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4">
                        <a href="manage-blotter.php">
                            <div class="card text-center mb-3" style="width: 100%;">
                                <div class="card-header count-header-cont" style="background-color: #F39C12;">
                                    <h5 class="card-title count-title">Subjects enrolled:</h5>
                                </div>
                                <div class="card-body count-blotter">
                                    <p class="card-text count-lbl"><i class="fas fa-clipboard link-icon"></i>&nbsp;&nbsp;5</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4">
                        <a href="manage-blotter.php">
                            <div class="card text-center mb-3" style="width: 100%;">
                                <div class="card-header count-header-cont" style="background-color: #F39C12;">
                                    <h5 class="card-title count-title">Subjects enrolled:</h5>
                                </div>
                                <div class="card-body count-blotter">
                                    <p class="card-text count-lbl"><i class="fas fa-clipboard link-icon"></i>&nbsp;&nbsp;5</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div> 
            </div>
        </section>

        <section id="announcement-section">
        <div class="container" class="mb-3">
                <div class="row">
                    <div class="col">
                        <div class="card card-table-collapse">
                           <div class="card-table-header">
                            <a class="btn btn-collapse" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Latest Announcement&nbsp;&nbsp;<i class="fas fa-chevron-down"></i></a>
                           </div> 
                        </div>
                    </div>
                </div> 

                <div class="collapse" id="collapseExample">
                    <div class="card card-table-collapse" style="padding-left:0px;padding-right:0px;">
                        <div class="card card-body">
                            <?php
                                $retrieveAccessCode = "SELECT accesscode FROM tbl_enrollment WHERE enrollment_id_student = '$enrollmentid'";
    
                                $resultAccessCode = mysqli_query($conn, $retrieveAccessCode);
    
                                while($DataRows = mysqli_fetch_assoc($resultAccessCode)){
                                    $accesscode = $DataRows['accesscode'];
    
                                $retrieveUpdates = "SELECT content, datestamp, subjectname FROM tbl_updates U JOIN tbl_subject S ON U.subjectid = S.subjectid WHERE U.subjectid = md5('$accesscode') ORDER BY U.datetimestamp DESC LIMIT 1";
    
                                $resultUpdates = mysqli_query($conn, $retrieveUpdates);
    
                                while($DataRows1 = mysqli_fetch_assoc($resultUpdates)){
                                    $datestamp = $DataRows1['datestamp'];
                                    $content = $DataRows1['content'];
                                    $subjectname = $DataRows1['subjectname'];
                            ?>
                            <h1 class="announcement-content"><?php echo $content; ?></h1>
                        </div>
                        <div class="card-footer card-footer-collapse">
                            <p class="text-muted announcement-date">Posted: <?php echo $datestamp; ?>&nbsp;&nbsp;For subject: <?php echo $subjectname; ?></p>
                        </div>
                        <?php 
                                } 
                            }
                        ?>
                    </div>
                </div>
            </div>
        </section>

        <footer id="main-footer">
            <div class="container">
                <div class="row">
                    <div class="col text-center my-3">
                        <img src="../img/nnhs-lms-logo.png" alt="nnhs-logo" class="img-fluid" width="50px">
                        <p class="cdate" style="font-size: 15px; display:inline-block;">&copy; 2018</p>
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