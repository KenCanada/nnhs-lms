<?php 
    require_once('../functions/connection.php');
    require_once('../functions/sessions.php');
    require_once('../functions/functions.php'); 
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

    if(ISSET($_GET['aID'])){
        $assignIDFromURL = $_GET['aID'];
    }
?>

<?php
    IF(ISSET($_POST['submitAssignment'])){
        $sub_desc = mysqli_real_escape_string($conn, $_POST['sub_desc']);
        $file_name = $_FILES["file_name"]["name"];
        $file_attach = $_FILES["file_name"];
        $move_location = "uploads/".basename($_FILES["file_name"]["name"]);
        $fileExt = explode('.', $file_name);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('pdf', 'docx', 'jpg', 'zip', 'rar', 'png', 'pptx');
        $insertLessonQuery = "INSERT INTO `tbl_assignment_record`(`assignment_id`, `student_id`, `filename`, `submission_desc`, `grade`, `submission_status`, `datetimestamp`, `subjectid`) VALUES ('$assignIDFromURL','$userid','$file_name','$sub_desc','0','S', NOW(), '$subjectidFromURL')";
        
        if(!(in_array($fileActualExt, $allowed))){
            $_SESSION['errorMessage'] = "File type is invalid!";
        }
        else{
            if(!($_FILES['file_name']['size'] > 25000000)){
                $checkIfSubmittedAlready = "SELECT COUNT(*) AS 'subCheck' FROM tbl_assignment_record WHERE assignment_id = '$assignIDFromURL' AND student_id = '$userid'";

                $resultIfSubAlready = mysqli_query($conn, $checkIfSubmittedAlready);

                While($DataRows = mysqli_fetch_assoc($resultIfSubAlready)){
                    $countSubAlready = $DataRows['subCheck'];
                }

                if($countSubAlready >= 1){
                    $_SESSION['errorMessage'] = "You've already submit your assignment!";

                    header("Refresh: 3;url=view-assignment.php?id=$subjectidFromURL");
                }
                else{
                    if(move_uploaded_file($_FILES["file_name"]["tmp_name"], $move_location)){
                        if(mysqli_query($conn, $insertLessonQuery)){
                            $_SESSION['successMessage'] = "Assignment successfully submitted!";

                            header("Refresh: 3;url=view-assignment.php?id=$subjectidFromURL");
                        }
                        else{
                            $_SESSION['errorMessage'] = mysqli_error($conn);
                        }
                    }
                    else{
                        $_SESSION['errorMessage'] = "Error uploading";
                    }
                }
            }
            else{
                $_SESSION['errorMessage'] = "Maximum file size limit of 25 mb exceeded!";
            }
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
                                <a href="subject-info-panel-student.php?id=<?php echo $subjectidFromURL; ?>" class="nav-link active link">Home</a>
                            </li>

                            <li class="nav-item mr-3">
                                <a href="lesson-panel-student.php?id=<?php echo $subjectidFromURL; ?>" class="nav-link link">Lesson</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle user-option" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Assignment
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="view-assignment.php?id=<?php echo $subjectidFromURL; ?>">Submit Assignment</a>
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

    <section id="file-blotter">
            <div class="container mb-5">
            <?php echo errorMessage(); echo successMessage(); ?>
                <div class="row">
                    <div class="card card-table" style="padding-left:0px;padding-right:0px;">
                        <div class="card-header card-table-header">
                            <h1>Submit Assignment</h1>
                        </div>
                        <div class="card-body">
                                <div class="container">
                                    <form class="needs-validation" action="submit-assignment.php?id=<?php echo $subjectidFromURL; ?>&amp;aID=<?php echo $assignIDFromURL; ?>" method="POST" id="add-resident-form"   enctype="multipart/form-data" novalidate>
                                       <div class="form-row mb-3">
                                            <div class="col">
                                                <label for="lastname" class="input-label">File&nbsp;&nbsp;<span class="text-muted"><p class="lead" style="display:inline-block;font-size:12px;">Max file size: 25mb</p></span></label>
                                                <input type="file" class="form-control" name="file_name" required>
                                                <div class="invalid-feedback">
                                                    File attachment is required!
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row mb-3">
                                            <div class="col">
                                                <label for="gender" class="input-label">Submission Description</label>
                                                <textarea class="form-control" rows="10" name="sub_desc"></textarea>
                                                <div class="invalid-feedback">
                                                    Required field!
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="submitAssignment" class="btn btn-success"><i class="far fa-check-circle"></i> Save changes</button>
                                    <a href="view-assignment.php?id=<?php echo $subjectidFromURL; ?>" class="btn btn-secondary"><i class="far fa-times-circle"></i> Close</a>
                                </div>
                                    </form>
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