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
                                <a class="nav-link dropdown-toggle user-option" href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
            <div class="row mb-5">
                <div class="card card-table mb-3" style="padding-left:0px; padding-right:0px;">
                    <div class="card-header card-table-header">
                        <h1>Students</h1>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Date Joined</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <?php
                                    $retrieveLessons = "SELECT fname, lname, A.userid, datestamp
                                                        FROM tbl_account A JOIN tbl_enrollment E
                                                        ON A.enrollment_id = E.enrollment_id_student
                                                        JOIN tbl_subject S ON E.accesscode = S.accesscode
                                                        WHERE S.archivestatus = 0 AND subjectid = '$subjectidFromURL'
                                                        ORDER BY datestamp DESC";

                                    $result = mysqli_query($conn, $retrieveLessons);

                                    while($DataRows = mysqli_fetch_assoc($result)){
                                        $fname = $DataRows['fname'];
                                        $lname = $DataRows['lname'];
                                        $userid = $DataRows['userid'];
                                        $datestamp = $DataRows['datestamp'];
                                ?>
                                    <tr>
                                        <td><?php echo htmlentities($fname." ".$lname); ?></td>
                                        <td><?php echo htmlentities($datestamp); ?></td>
                                        <td class="text-right"><a href="uploads/<?php echo $filename; ?>" class="btn btn-primary mr-3" style="width:40px;" target="_blank" data-toggle="tooltip" data-placement="top" title="VIEW"><i class="fas fa-external-link-alt"></i></a><a href="" class="btn btn-warning mr-3" style="width:40px;"><i class="far fa-edit"></i></a><a href="" class="btn btn-danger mr-3" style="width:40px;"><i class="far fa-trash-alt"></i></a></td>
                                    </tr>
                                <?php } ?>
                            </table>
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