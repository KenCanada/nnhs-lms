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

    if(ISSET($_GET['eID'])){
        $exam_session_idFromURL = $_GET['eID'];
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
                                    <a class="dropdown-item" href="#">Add Assignment</a>
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
                                    <?php
                                        $retrieveExamSession = "SELECT * FROM tbl_exam_session WHERE exam_session_id='$exam_session_idFromURL'";

                                        $result = mysqli_query($conn, $retrieveExamSession);
                                
                                        while($DataRows = mysqli_fetch_assoc($result)){
                                            $dateStart = $DataRows['date_start'];
                                            $timeLimit = $DataRows['time_limit'];
                                            $examSessionId = $DataRows['exam_session_id'];
                                            $subjectId = $DataRows['subjectid'];
                                            $examTitle = $DataRows['exam_title'];
                                            $examItems = $DataRows['no_of_items'];
                                    ?>
                                <form class="needs-validation" action="exam-session.php?id=<?php echo $subjectidFromURL; ?>" method="post" id="add-resident-form" novalidate>
                                    <?php } ?>
                                    <div class="form-row mb-3">
                                        <div class="col-md-6">
                                            <label for="lbl_title">Exam Title</label>
                                            <input value="<?php echo $examTitle; ?>" type="text" class="form-control" name="examTitle" id="txt_title" placeholder="e.g. Quiz No. 1" disabled>
                                            <div class="invalid-feedback">
                                                Required field!
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="lbl_subj_name">Subject Name</label>
                                            <?php
                                                $retrieveSubjectName = "SELECT subjectname FROM tbl_subject WHERE subjectid = '$subjectidFromURL'";

                                                $result = mysqli_query($conn, $retrieveSubjectName);

                                                while($DataRows = mysqli_fetch_assoc($result)){
                                                    $sujectName = $DataRows['subjectname'];
                                            ?>
                                            <input type="text" value="<?php echo $sujectName; ?>" class="form-control" disabled>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="form-row mb-3">
                                        <div class="col-md-6">
                                            <label for="lbl_date_start">Date and Time</label>
                                            <input value="<?php echo $dateStart; ?>" type="text" class="form-control" name="dateStart" id="txt_date_start" placeholder="e.g. 03/01/2018" disabled>
                                            
                                            <div class="invalid-feedback">
                                                Required field!
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="lbl_date_end">Time Limit<span class="text-muted" style="margin-left: 10px; font-size:12px;">(in Minutes)</span></label>
                                            <input value="<?php echo $timeLimit; ?>" type="text" class="form-control" name="timeLimit" id="txt_date_end" placeholder="e.g. 20" disabled>
                                            
                                            <div class="invalid-feedback">
                                                Required field!
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="lbl_items">Number of Items</label>
                                            <input value="<?php echo $examItems; ?>" type="text" class="form-control" name="examItems" id="txt_items" placeholder="e.g. 10" disabled>
                                            <div class="invalid-feedback">
                                                Required field!
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>       
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
        <hr>
            <div class="row">
                <div class="col">
                    <div class="card card-table mb-5 mt-5" style="padding-left:0px; padding-right:0px;">
                        <div class="card-header card-table-header">
                            <h1 class="card-title" id="">Items</h1>
                        </div>
                        <div class="card-body">
                            <?php
                                $questionNum = 0;
                                $correctAnswer = "";
                                $retrieveQuestions = "SELECT * 
                                                      FROM tbl_question
                                                      WHERE exam_session_id = $exam_session_idFromURL
                                                      ORDER BY question_id ASC";
                                
                                $resultRetrieveQuestion = mysqli_query($conn, $retrieveQuestions);

                                while($DataRows = mysqli_fetch_assoc($resultRetrieveQuestion)){
                                    $questionContent = $DataRows['question_content'];
                                    $choice1 = $DataRows['choice1'];
                                    $choice2 = $DataRows['choice2'];
                                    $choice3 = $DataRows['choice3'];
                                    $choice4 = $DataRows['choice4'];
                                    
                                    $questionNum++;
                                    
                                    if(substr($choice1, 0,2) == "on"){
                                        $correctAnswer = substr($choice1, 2);
                                        $choice1 = substr($choice1, 2);
                                    }
                                    else if(substr($choice2, 0,2) == "on"){
                                        $correctAnswer = substr($choice2, 2);
                                        $choice2 = substr($choice2, 2);
                                    }
                                    else if(substr($choice3, 0,2) == "on"){
                                        $correctAnswer = substr($choice3, 2);
                                        $choice3 = substr($choice3, 2);
                                    }
                                    else{
                                        $correctAnswer = substr($choice4, 2);
                                        $choice4 = substr($choice4, 2);
                                    }
                            ?>
                            <div class="card card-question">
                                <h1 class="question-text"><?php echo $questionNum.".) ".$questionContent; ?></h1>
                                <br>
                                <h3 class="choice-text"><?php echo "A.) ".$choice1; ?></h3>
                                <br>
                                <h3 class="choice-text"><?php echo "B.) ".$choice2; ?></h3>
                                <br>
                                <h3 class="choice-text"><?php echo "C.) ".$choice3; ?></h3>
                                <br>
                                <h3 class="choice-text"><?php echo "D.) ".$choice4; ?></h3>
                                <br>
                                <h3 class="question-text" style="font-weight:bold;"><?php echo "CORRECT ANSWER: ".$correctAnswer; ?></h3>
                            </div>
                            <?php } ?>
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