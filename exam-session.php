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
            $profileimg = $_SESSION['profileimg'];

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

<?php
    global $conn;
    
    if(ISSET($_GET['id'])){
        $subjectidFromURL = $_GET['id'];
    }

    if(ISSET($_POST['save_Exam'])){
        $examTitle = mysqli_real_escape_string($conn, $_POST['examTitle']);
        $dateStart = mysqli_real_escape_string($conn, $_POST['dateStart']);
        $dateEnd = mysqli_real_escape_string($conn, $_POST['dateEnd']);
        $timeLimit = mysqli_real_escape_string($conn, $_POST['timeLimit']);
        $examItems = mysqli_real_escape_string($conn, $_POST['examItems']);

        $countExamSession = "SELECT COUNT(*) AS 'countExamSession' FROM tbl_exam_session";

        $result = mysqli_query($conn, $countExamSession);

        while($DataRows = mysqli_fetch_assoc($result)){
            $countResult = $DataRows['countExamSession'];
        }

        if($countResult == 0){
            $exam_session_id = 1;
        }
        else{
            $exam_session_id = $countResult + 1;
        }
        
        $insertExamSession = "INSERT INTO tbl_exam_session (`date_start`,`date_end`,`time_limit`,`exam_session_id`,`subjectid`,`exam_title`,`no_of_items`)VALUES('$dateStart', '$dateEnd', '$timeLimit', '$exam_session_id', '$subjectidFromURL', '$examTitle', '$examItems')";

        if(mysqli_query($conn, $insertExamSession)){
            $_SESSION['successMessage'] = "Exam information successfully added!";

            $countExamSession = "SELECT COUNT(*) AS 'countExamSession' FROM tbl_exam_session";

            $result = mysqli_query($conn, $countExamSession);
    
            while($DataRows = mysqli_fetch_assoc($result)){
                $countResult = $DataRows['countExamSession'];
            }
            
            $subjectid = "SELECT subjectid FROM tbl_exam_session WHERE exam_session_id = '$countResult'";

            $result = mysqli_query($conn, $subjectid);
    
            while($DataRows = mysqli_fetch_assoc($result)){
                $subjectidFromDB = $DataRows['subjectid'];
            }

            header("Refresh: 3;url=exam-items.php?id=$subjectidFromDB&eID=$countResult");
            
        }
        else{
            $_SESSION['errorMessage'] = mysqli_error($conn);
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>NNHS</title>

        <meta name="viewport" content="width=device-width" intial-scale="1.0">

        <link rel="icon" href="../img/nnhs-lms-logo.png">

        <link rel="stylesheet" type="text/css" href="../semantic/dist/semantic.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="../fonts/webfonts/fontawesome-all.css" rel="stylesheet">
        <link rel="stylesheet" href="../css/style.css">

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script
          src="https://code.jquery.com/jquery-3.1.1.min.js"
          integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
          crossorigin="anonymous"></script>
        <script src="../semantic/dist/semantic.min.js"></script>
    </head>
<body>
    <section id="teacher-panel-header">
        <div class="overlay">
            <nav class="navbar navbar-expand-lg p-0 navigation sticky-top">
                <div class="container">
                    <a href="teacher-panel.php" class="navbar-brand brand mt-3 mr-5">
                        <img src="../img/nnhs-lms-logo.png" alt="" width="70px" class="mb-3">
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
                            <h1 class="card-title" id="exampleModalLabel">Exam Information</h5>
                        </div>
                        <div class="card-body">
                                    <?php
                                        $countExamSession = "SELECT COUNT(*) AS 'countExamSession' FROM tbl_exam_session";

                                        $result = mysqli_query($conn, $countExamSession);
                                
                                        while($DataRows = mysqli_fetch_assoc($result)){
                                            $countResult = $DataRows['countExamSession'];
                                    ?>
                                <form class="needs-validation" action="exam-session.php?id=<?php echo $subjectidFromURL; ?>" method="post" id="add-resident-form" novalidate>
                                    <?php } ?>
                                    <div class="form-row mb-3">
                                        <div class="col-md-6">
                                            <label for="lbl_title">Exam Title</label>
                                            <input type="text" class="form-control" name="examTitle" id="txt_title" placeholder="e.g. Quiz No. 1" required>
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
                                        <div class="col-md-3">
                                            <label for="lbl_date_start">Date Start</label>
                                            <input type="text" class="form-control" name="dateStart" id="txt_date_start" placeholder="e.g. 03/01/2018" required>
                                            
                                            <div class="invalid-feedback">
                                                Required field!
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="lbl_date_end">Date End</label>
                                            <input type="text" class="form-control" name="dateEnd" id="txt_date_end" placeholder="e.g. 03/01/2018" required>

                                            <div class="invalid-feedback">
                                                Required field!
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="lbl_date_end">Time Limit<span class="text-muted" style="margin-left: 10px; font-size:12px;">(in Minutes)</span></label>
                                            <input type="text" class="form-control" name="timeLimit" id="txt_date_end" placeholder="e.g. 20" required>
                                            
                                            <div class="invalid-feedback">
                                                Required field!
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="lbl_items">Number of Items</label>
                                            <input type="text" class="form-control" name="examItems" id="txt_items" placeholder="e.g. 10" required>
                                            <div class="invalid-feedback">
                                                Required field!
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                                    <div class="card-footer text-right">
                                        <button type="submit" name="save_Exam" class="btn btn-success"><i class="far fa-check-circle"></i> Save changes</button>
                                        <a  href="manage-resident.php" type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-times-circle"></i> Back</a>
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
                            <form class="needs-validation" action="" method="post" id="" novalidate>
                                <div class="form-row mb-3">
                                    <div class="col-md-6">
                                        <label for="lbl_question">Question</label>
                                        <input type="text" class="form-control" name="txt_question" id="txt_question" placeholder="" required style="height:215px;">
                                        <div class="invalid-feedback">
                                            Required field!
                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <p>Choices <span class="text-muted" style="margin-left: 10px; font-size:12px;">STATE: Put "A" if Correct Answer, "B" if Wrong Answer</span><p>
                                        
                                        <input type="text" class="form-control" name="txt_choices_a" id="txt_choices_a" placeholder="A" required>
                                        <div class="invalid-feedback">
                                            Required field!
                                        </div>
                                        
                                        <input type="text" class="form-control" name="txt_choices_b" id="txt_choices_b" placeholder="B" required>
                                        <div class="invalid-feedback">
                                            Required field!
                                        </div><br>
                                        <input type="text" class="form-control" name="txt_choices_c" id="txt_choices_c" placeholder="C" required>
                                        <div class="invalid-feedback">
                                            Required field!
                                        </div><br>
                                        <input type="text" class="form-control" name="txt_choices_d" id="txt_choices_d" placeholder="D" required>
                                        <div class="invalid-feedback">
                                            Required field!
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <p>State<p>
                                        
                                        <input type="text" class="form-control" name="txt_choices_a" id="txt_choices_a" placeholder="--" required>
                                        <div class="invalid-feedback">
                                            Required field!
                                        </div>
                                        
                                        <input type="text" class="form-control" name="txt_choices_b" id="txt_choices_b" placeholder="--" required>
                                        <div class="invalid-feedback">
                                            Required field!
                                        </div><br>
                                        <input type="text" class="form-control" name="txt_choices_c" id="txt_choices_c" placeholder="--" required>
                                        <div class="invalid-feedback">
                                            Required field!
                                        </div><br>
                                        <input type="text" class="form-control" name="txt_choices_d" id="txt_choices_d" placeholder="--" required>
                                        <div class="invalid-feedback">
                                            Required field!
                                        </div>
                                    </div>
                                </div>
                        </div>
                            
                                <div class="card-footer text-right">
                                    <button type="submit" name="submit" class="btn btn-success"><i class="far fa-check-circle"></i> Save changes</button>
                                    <a  href="manage-resident.php" type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-times-circle"></i> Back</a>
                                </div>
                            </form>
                        <!-- </div> -->
                    <!-- </div> -->
                </div><!--col-->
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

    
    <script>
      (function() {
          'use strict';
          window.addEventListener('load', function() {
          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.getElementsByClassName('needs-validation');
          // Loop over them and prevent submission
          var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
              if (form.checkValidity() === false) {
                  event.preventDefault();
                  event.stopPropagation();
              }
                  form.classList.add('was-validated');
              }, false);
              });
          }, false);
      })();
    </script>

    <script src="../js/index.js"></script>
    <script src='../js/jquery-3.3.1.min.js'></script>
</body>
</html>