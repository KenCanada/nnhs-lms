<?php 
    require_once('../functions/connection.php');
    require_once('../functions/sessions.php');
    require_once('../functions/functions.php'); 
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

<?php
    global $conn;
    
    if(isset($_POST['saveSubject'])){

        $subjectname = mysqli_real_escape_string($conn, $_POST['subjectname']);
        $datetime = dateTimeFormat();
        $subjectnamecode = substr($subjectname, 0, 3);
        $accesscode = datee().$subjectnamecode.Timee();
        
        $existingSubjectQuery = "SELECT * FROM tbl_subject WHERE subjectname = '$subjectname' AND userid = '$userid'";

        $result = mysqli_query($conn, $existingSubjectQuery);

        $subjectcount = mysqli_num_rows($result);

        if($subjectcount > 0){
            $_SESSION['errorMessage'] = "Subject already exists!";
        }
        else{
            $insertSubjectQuery = "INSERT INTO `tbl_subject`(`subjectname`, `accesscode`, `datetime`, `archivestatus`, `subjectid`, `userid`, `datetimestamp`) VALUES ('$subjectname','$accesscode','$datetime', '0', md5('$accesscode'), '$userid', NOW())";

            if(mysqli_query($conn, $insertSubjectQuery)){
                $_SESSION['successMessage'] = $subjectname." subject successfully added! ACCESS CODE: ".$accesscode;
            }
            else{
                $_SESSION['errorMessage'] = mysqli_error($conn);
            }
        }
    }

    if(ISSET($_GET['archive'])){
        $subjectidFromURL = $_GET['archive'];

        $updateArchiveStatusQuery = "UPDATE tbl_subject SET archivestatus = '1' WHERE subjectid = '$subjectidFromURL'";

        if(mysqli_query($conn, $updateArchiveStatusQuery)){
            $_SESSION['successMessage'] = "Subject info successfully archived!";
            header("Refresh: 3;url=manage-subj-panel.php");
        }
        else{
            $_SESSION['errorMessage'] = mysqli_error($conn);
        }
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
                    <a href="teacher-panel.php" class="navbar-brand brand mt-3 mr-5">
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
                                    <a class="dropdown-item" href="#">Another action</a>
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

        <section id="manage-subj-menu" class="mb-5">
            <div class="container">
            <?php echo errorMessage(); echo successMessage(); ?>
                <div class="row">
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                <div class="card card-table mb-3" style="padding-left:0px; padding-right:0px;">
                                <div class="card-header card-table-header">
                                    <h1>Generate Report for:</h1>
                                </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped text-center">
                                                <thead>
                                                    <tr>
                                                        <th>Subject Name</th>
                                                        <th>Access Code</th>
                                                        <th>Students Enrolled</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                            <?php
                                                $retrieveSubjectsQuery = "SELECT * FROM tbl_subject WHERE archivestatus = '0' AND userid = '$userid' ORDER BY datetimestamp DESC";

                                                $result = mysqli_query($conn, $retrieveSubjectsQuery);

                                                while($DataRows = mysqli_fetch_assoc($result)){
                                                    $subjectname = $DataRows['subjectname'];
                                                    $accesscode = $DataRows['accesscode'];
                                                    $subjectid = $DataRows['subjectid'];
                                            ?>
                                                <tr>
                                                    <td><?php echo $subjectname; ?></td>
                                                    <td><?php echo $accesscode; ?></td>
                                                    <?php
                                                        $countEnrolledStudents = "SELECT COUNT(*) AS 'enrolledCount' FROM tbl_enrollment WHERE accesscode='$accesscode'";
                                                        
                                                        $resultCountEnrolled = mysqli_query($conn, $countEnrolledStudents);

                                                        while($DataRows = mysqli_fetch_assoc($resultCountEnrolled)){
                                                            $enrolledCount = $DataRows['enrolledCount'];
                                                    ?>
                                                    <td><?php echo $enrolledCount; ?></td>
                                                    <?php } ?>
                                                    <td><a href="report-choices.php?sID=<?php echo $subjectid; ?>" class="btn btn-primary btn-block">Generate</a></td>
                                                </tr>
                                            <?php } ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
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