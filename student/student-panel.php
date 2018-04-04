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
                        <img src="../img/brand-pic.png" alt="" width="150px" class="mb-3">
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

        <section id="dashboard-panel" class="mb-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <a href="manage-blotter.php">
                            <div class="card text-center mb-3 card-table" style="width: 100%;">
                                <div class="card-header count-header-cont">
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
                            <div class="card text-center mb-3 card-table" style="width: 100%;">
                                <div class="card-header count-header-cont">
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
                            <div class="card text-center mb-3 card-table" style="width: 100%;">
                                <div class="card-header count-header-cont">
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
            <div class="container mb-3">
                <div class="row">
                    <div class="col">
                        <div id="accordion">
                            <div class="card card-table-collapse">
                                <div class="card-header card-table-header" id="headingOne">
                                <h5 class="mb-0">
                                    <button class="btn btn-link btn-collapse" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Latest Announcement&nbsp;&nbsp;<i class="fas fa-chevron-down"></i>
                                    </button>
                                </h5>
                                </div>
                            
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                                        <?php
                                            $accesscodeArray = array();
                                            $subjectidArray = array();
            
                                            $retrieveAccessCode = "SELECT accesscode FROM tbl_enrollment WHERE enrollment_id_student = '$enrollmentid'";
                
                                            $resultAccessCode = mysqli_query($conn, $retrieveAccessCode);
                                            
                                            while($DataRows = mysqli_fetch_array($resultAccessCode)){
                                                $accesscodeArray[] = $DataRows['accesscode'];
                                            }                                                                                                
                                            $retrieveSubjectID = "SELECT subjectid FROM tbl_subject WHERE accesscode IN ('".implode("','", $accesscodeArray)."')";
                                            $resultSubjectID = mysqli_query($conn, $retrieveSubjectID);
            
                                            while($DataRows0 = mysqli_fetch_array($resultSubjectID)){
                                                $subjectidArray[] = $DataRows0['subjectid'];
                                            }
                                            
                                            $retrieveUpdates = "SELECT content, datestamp, subjectname FROM tbl_updates U JOIN tbl_subject S ON U.subjectid = S.subjectid WHERE U.subjectid IN ('".implode("','", $subjectidArray)."') ORDER BY U.datetimestamp DESC LIMIT 1";
                                            $resultUpdates = mysqli_query($conn, $retrieveUpdates);
                
                                            while($DataRows1 = mysqli_fetch_array($resultUpdates)){
                                                $datestamp = $DataRows1['datestamp'];
                                                $content = $DataRows1['content'];
                                                $subjectname = $DataRows1['subjectname'];
                                        ?>
    
                                        <h1 class="announcement-content"><?php echo nl2br($content); ?></h1>
                                
                                    </div>
                                        <div class="card-footer card-footer-collapse">
                                            <p class="text-muted announcement-date">Posted: <?php echo $datestamp; ?>&nbsp;&nbsp;For subject: <?php echo $subjectname; ?></p>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="card card-table-collapse">
                                <div class="card-header card-table-header" id="headingOne">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed btn-collapse" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                    Upcoming Exam(s)&nbsp;&nbsp;<i class="fas fa-chevron-down"></i>
                                    </button>
                                </h5>
                                </div>
                            
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped text-center">
                                                <thead>
                                                    <tr>
                                                        <th>Title of Exam</th>
                                                        <th>Number of Items</th>
                                                        <th>Time Limit</th>
                                                        <th>Date Start</th>
                                                    </tr>
                                                </thead>
                                                        <?php
                                                            $accesscodeArray = array();
                                                            $subjectidArray = array();
                            
                                                            $retrieveAccessCode = "SELECT accesscode FROM tbl_enrollment WHERE enrollment_id_student = '$enrollmentid'";
                                
                                                            $resultAccessCode = mysqli_query($conn, $retrieveAccessCode);
                                                            
                                                            while($DataRows = mysqli_fetch_array($resultAccessCode)){
                                                                $accesscodeArray[] = $DataRows['accesscode'];
                                                            }                                                                                                
                                                            $retrieveSubjectID = "SELECT subjectid FROM tbl_subject WHERE accesscode IN ('".implode("','", $accesscodeArray)."')";
                                                            $resultSubjectID = mysqli_query($conn, $retrieveSubjectID);
                            
                                                            while($DataRows0 = mysqli_fetch_array($resultSubjectID)){
                                                                $subjectidArray[] = $DataRows0['subjectid'];
                                                            }
                                                        
                                                            $retrieveUpcomingExams = "SELECT exam_title, no_of_items, time_limit, DATE_FORMAT(date_start,'%M %d, %Y') AS 'exam_date', TIME_FORMAT(date_start, '%h:%i %p') AS 'exam_time' FROM tbl_exam_session WHERE CAST(date_start AS DATETIME) > NOW() AND subjectid IN ('".implode("','", $subjectidArray)."') ORDER BY CAST(date_start AS DATETIME) ASC LIMIT 5";

                                                            $result = mysqli_query($conn, $retrieveUpcomingExams);

                                                            while($DataRows = mysqli_fetch_assoc($result)){
                                                                $exam_title = $DataRows['exam_title'];
                                                                $no_of_items = $DataRows['no_of_items'];
                                                                $time_limit = $DataRows['time_limit'];
                                                                $exam_date = $DataRows['exam_date'];
                                                                $exam_time = $DataRows['exam_time'];
                                                                $exam_date_time = $exam_date." ".$exam_time;
                                                        ?>
                                                <tr>
                                                        <td><?php echo htmlentities($exam_title); ?></td>
                                                        <td><?php echo htmlentities($no_of_items); ?></td>
                                                        <td><?php echo htmlentities($time_limit); ?></td>
                                                        <td><?php echo htmlentities($exam_date_time); ?></td>
                                                        
                                                </tr>
                                                    <?php } ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card card-table-collapse">
                                <div class="card-header card-table-header" id="headingOne">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed btn-collapse" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                    Upcoming Assignment(s)&nbsp;&nbsp;<i class="fas fa-chevron-down"></i>
                                    </button>
                                </h5>
                                </div>
                            
                                <div id="collapseThree" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped text-center">
                                                <thead>
                                                    <tr>
                                                        <th>Assignment Name</th>
                                                        <th>Deadline</th>
                                                    </tr>
                                                </thead>
                                                        <?php
                                                            $accesscodeArray = array();
                                                            $subjectidArray = array();
                            
                                                            $retrieveAccessCode = "SELECT accesscode FROM tbl_enrollment WHERE enrollment_id_student = '$enrollmentid'";
                                
                                                            $resultAccessCode = mysqli_query($conn, $retrieveAccessCode);
                                                            
                                                            while($DataRows = mysqli_fetch_array($resultAccessCode)){
                                                                $accesscodeArray[] = $DataRows['accesscode'];
                                                            }                                                                                                
                                                            $retrieveSubjectID = "SELECT subjectid FROM tbl_subject WHERE accesscode IN ('".implode("','", $accesscodeArray)."')";
                                                            $resultSubjectID = mysqli_query($conn, $retrieveSubjectID);
                            
                                                            while($DataRows0 = mysqli_fetch_array($resultSubjectID)){
                                                                $subjectidArray[] = $DataRows0['subjectid'];
                                                            }
                                                        
                                                            $retrieveUpcomingExams = "SELECT assign_name, filename_assign, subjectid_assign, assign_id, assign_desc, DATE_FORMAT(deadline_assign,'%M %d, %Y') AS 'deadline_date', TIME_FORMAT(deadline_assign, '%h:%i %p') AS 'deadline_time' FROM tbl_assignment WHERE CAST(deadline_assign AS DATETIME) > NOW() AND subjectid_assign IN ('".implode("','", $subjectidArray)."') ORDER BY CAST(deadline_assign AS DATETIME) ASC LIMIT 5";

                                                            $result = mysqli_query($conn, $retrieveUpcomingExams);

                                                            while($DataRows = mysqli_fetch_assoc($result)){
                                                                $assignment_name = $DataRows['assign_name'];
                                                                $deadline_date = $DataRows['deadline_date'];
                                                                $deadline_time = $DataRows['deadline_time'];
                                                                $deadline_date_time = $deadline_date." ".$deadline_time;
                                                        ?>
                                                <tr>
                                                        <td><?php echo htmlentities($assignment_name); ?></td>
                                                        <td><?php echo htmlentities($deadline_date_time); ?></td>
                                                        
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