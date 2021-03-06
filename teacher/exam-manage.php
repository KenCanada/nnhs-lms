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
    
    if(ISSET($_GET['id'])){
        $subjectidFromURL = $_GET['id'];
    }
	if(ISSET($_GET['lld'])){
        $exam_session_id = $_GET['lld'];

        $updateArchiveStatusQuery = "UPDATE tbl_exam_session SET archive_exam = '1' WHERE exam_session_id = '$exam_session_id'";

        if(mysqli_query($conn, $updateArchiveStatusQuery)){
            $_SESSION['successMessage'] = "Subject info successfully archived!";
            header("Refresh: 3;url=exam-manage.php?id=$subjectidFromURL");
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
                        <img src="../img/brand-pic.png" alt="" width="100px" class="mb-3">
                    </a>

                    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNav">
                        <span> </span>
                        <span> </span>
                        <span> </span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item mr-3">
                                <a href="subject-info-panel.php?id=<?php echo $subjectidFromURL; ?>" class="nav-link active link">Home</a>
                            </li>

                            <li class="nav-item mr-3">
                                <a href="lesson-panel.php?id=<?php echo $subjectidFromURL; ?>" class="nav-link link">Lesson</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle user-option" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Assignment
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="addassignment.php?id=<?php echo $subjectidFromURL; ?>">Add Assignment</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="../logout.php">Assignment History</a>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle user-option" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Exam
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="exam-session.php?id=<?php echo $subjectidFromURL; ?>">Add Exam</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="exam-manage.php?id=<?php echo $subjectidFromURL; ?>">Manage Exam</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="../logout.php">Exam History</a>
                                </div>
                            </li>

                            <li class="nav-item mr-3">
                                <a href="student-list-panel.php?id=<?php echo $subjectidFromURL; ?>" class="nav-link link">Students</a>
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
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="../logout.php">Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </section>

    <section id="subject-info-panel">
        <div class="container mb-5">
        <?php echo errorMessage(); echo successMessage(); ?>
            <div class="row">
                <div class="col">
                    <div class="card card-table mb-5" style="padding-left:0px; padding-right:0px;">
                        <div class="card-header card-table-header">
                            <h1 class="card-title" id="exampleModalLabel">Exam</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Date and Time</th>
                                            <th>Time Limit</th>
                                            <th>Items</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <?php
                                        $retrieveExamSession = "SELECT *
                                                                FROM tbl_exam_session
                                                                WHERE subjectid = '$subjectidFromURL' AND archive_exam = 0
                                                                ORDER BY datetimestamp ASC";

                                        $resultExamSession = mysqli_query($conn, $retrieveExamSession);

                                        while($DataRows = mysqli_fetch_assoc($resultExamSession)){
                                            $dateStart = $DataRows['date_start'];
                                            $timeLimit = $DataRows['time_limit'];
                                            $exam_session_id = $DataRows['exam_session_id'];
                                            $examTitle = $DataRows['exam_title'];
                                            $noOfItems = $DataRows['no_of_items'];
											$subjectidFromURL = $DataRows['subjectid'];
                                                if(strlen($examTitle) > 50){
                                                    $newExamtitle = substr($examTitle, 0, 50)." ...";
                                                }
                                                else{
                                                    $newExamtitle = $examTitle;
                                                }
                                    ?>
                                        <tr>
                                            <td><?php echo htmlentities($newExamtitle); ?></td>
                                            <td><?php echo htmlentities($dateStart); ?></td>
                                            <td><?php echo htmlentities($timeLimit); ?></td>
                                            <td><?php echo htmlentities($noOfItems); ?></td>
                                            <td class="text-right"><a href="view-exam.php?id=<?php echo $subjectidFromURL ?>&amp;eID=<?php echo $exam_session_id; ?>" class="btn btn-primary mr-3" style="width:40px;" target="_blank" data-toggle="tooltip" data-placement="top" title="VIEW"><i class="fas fa-external-link-alt"></i></a><a href="" class="btn btn-warning mr-3" style="width:40px;"><i class="far fa-edit"></i></a><a href="exam-manage.php?id=<?php echo $subjectidFromURL; ?>&amp;lld=<?php echo $exam_session_id?>" class="btn btn-danger mr-3" style="width:40px;"><i class="far fa-trash-alt"></i></a></td>
                                        </tr>
                                    <?php } ?>
                                </table>
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

    <script src="../js/index.js"></script>
    <script src='../js/jquery-3.3.1.min.js'></script>
</body>
</html>