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

    if(ISSET($_POST['postUpdate'])){
        $updateContent = mysqli_real_escape_string($conn, $_POST['content']);
        $datetime = dateTimeFormat();

        $insertUpdateQuery = "INSERT INTO tbl_updates(subjectid, datestamp, content, datetimestamp) VALUES('$subjectidFromURL', '$datetime', '$updateContent', NOW())";

        if(mysqli_query($conn, $insertUpdateQuery)){
            $_SESSION['successMessage'] = "Update successfully posted!";
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
        <?php
            $retriveSubjectInfo = "SELECT * FROM `tbl_subject` WHERE subjectid = '$subjectidFromURL'";

            $result = mysqli_query($conn, $retriveSubjectInfo);

            while($DataRows = mysqli_fetch_assoc($result)){
                $subjectname = $DataRows['subjectname'];
                $accesscode = $DataRows['accesscode'];
                $datetime = $DataRows['datetime'];
            }
			
			
        ?>
        <div class="container">
        <?php echo errorMessage(); echo successMessage(); ?>
            <div class="row mb-3">
                <div class="col">
                    <h1 class="subject-name-heading"><?php echo $subjectname; ?>&nbsp;&nbsp;<a href="" class="btn btn-primary btn-updates" data-toggle="modal" data-target="#post-update"><i class="far fa-sticky-note"></i>&nbsp;&nbsp;Post Updates</a></h1>
                </div>
            </div>
    </section>

    <section id="dashboard-panel" class="mb-3">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <a href="manage-blotter.php">
                        <div class="card text-center mb-3 card-table" style="width: 100%;">
                            <div class="card-header count-header-cont">
                                <h5 class="card-title count-title">Enrolled student(s):</h5>
                            </div>
                            <div class="card-body count-blotter">
							<?php $retrieveCountStudents = "SELECT COUNT(*) AS studcount FROM tbl_enrollment WHERE accesscode = '$accesscode' ";
								  $result = mysqli_query($conn, $retrieveCountStudents);
								
								while($DataRows = mysqli_fetch_assoc($result)){
								$studcount = $DataRows['studcount'];
							?>
                                <p class="card-text count-lbl"><i class="far fa-user"></i>&nbsp;&nbsp;<?php echo htmlentities($studcount); ?></p>
								<?php } ?>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="manage-blotter.php">
                        <div class="card text-center mb-3 card-table" style="width: 100%;">
                            <div class="card-header count-header-cont">
                                <h5 class="card-title count-title">Exam(s):</h5>
                            </div>
                            <div class="card-body count-blotter">
							<?php $retrieveCountExams = "SELECT COUNT(*) AS examcount FROM tbl_exam_session WHERE subjectid = '$subjectidFromURL'";
								  $result = mysqli_query($conn, $retrieveCountExams);
								
								while($DataRows = mysqli_fetch_assoc($result)){
								$examcount = $DataRows['examcount'];
							?>
                                <p class="card-text count-lbl"><i class="far fa-copy"></i>&nbsp;&nbsp;<?php echo htmlentities($examcount); ?></p>
								<?php } ?>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="manage-blotter.php">
                        <div class="card text-center mb-3 card-table" style="width: 100%;">
                            <div class="card-header count-header-cont">
                                <h5 class="card-title count-title">Assignment(s):</h5>
                            </div>
                            <div class="card-body count-blotter">
							<?php $retrieveCountAssigns = "SELECT COUNT(*) AS assigncount FROM tbl_assignment WHERE subjectid_assign = '$subjectidFromURL'";
								  $result = mysqli_query($conn, $retrieveCountAssigns);
								
								while($DataRows = mysqli_fetch_assoc($result)){
								$assigncount = $DataRows['assigncount'];
							?>
                                <p class="card-text count-lbl"><i class="far fa-folder"></i></i>&nbsp;&nbsp;<?php echo htmlentities($assigncount); ?></p>
								<?php } ?>
							</div>
                        </div>
                    </a>
                </div>
            </div> 
        </div>
    </section>

    <section id="upcoming-events" class="mb-5">
        <div class="container">
            <div class="row">
                    <div class="col-md-6">
                        <div class="card card-table" style="padding-left:0px; padding-right:0px;">
                            <div class="card-header card-table-header">
                                <h1>Upcoming Exam</h1>
                            </div>
                            <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Items</th>
                                            <th>Date and Time</th>
                                        </tr>
                                    </thead>
                                    <?php
                                        $retrieveUpcomingExams = "SELECT exam_title, no_of_items, time_limit, DATE_FORMAT(date_start,'%M %d, %Y') AS 'exam_date', TIME_FORMAT(date_start, '%h:%i %p') AS 'exam_time' FROM tbl_exam_session WHERE CAST(date_start AS DATETIME) > NOW() AND subjectid = '$subjectidFromURL' ORDER BY CAST(date_start AS DATETIME) ASC LIMIT 5";

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
                                            <td><?php echo htmlentities($exam_date_time); ?></td>
                                        </tr>
                                        <?php } ?>
                                </table>
                            </div>
                        </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-table" style="padding-left:0px; padding-right:0px;">
                    <div class="card-header card-table-header">
                        <h1>Upcoming Assignment</h1>
                    </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Date and Time</th>
                                    </tr>
                                </thead>
                                <?php
                                    $retrieveUpcomingExams = "SELECT assign_name, filename_assign, subjectid_assign, assign_id, assign_desc, DATE_FORMAT(deadline_assign,'%M %d, %Y') AS 'deadline_date', TIME_FORMAT(deadline_assign, '%h:%i %p') AS 'deadline_time' FROM tbl_assignment WHERE CAST(deadline_assign AS DATETIME) > NOW() AND subjectid_assign = '$subjectidFromURL' ORDER BY CAST(deadline_assign AS DATETIME) ASC LIMIT 5";

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
    </section>

    <section id="add-subject-modal">
        <div class="modal fade" id="post-update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">&plus; Post New Update</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="x-button" aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form class="needs-validation" action="subject-info-panel.php?id=<?php echo $subjectidFromURL; ?>" method="post" id="post-update-form" novalidate>
                        <div class="form-row mb-3">
                            <div class="col">
                                <label for="content">Content <span><h1 class="text-muted" style="font-size:10px;display:inline-block;">Character limit: 500</h1></span></label>
                                <textarea rows="9" class="form-control" name="content" id="lessondesc" required></textarea>
                                <div class="invalid-feedback">
                                    Update content is required!
                                </div>
                            </div>
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" name="postUpdate" class="btn btn-success"><i class="far fa-check-circle"></i> Save changes</button>                      
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-times-circle"></i> Close</button>
                </form>
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