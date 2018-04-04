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

    if(isset($_POST['saveAssignment'])){
        $assign_name = mysqli_real_escape_string($conn, $_POST['assign_name']);
        $assign_desc = mysqli_real_escape_string($conn, $_POST['assign_desc']);
        $datetime = dateTimeFormat();
		$deadline_date = mysqli_real_escape_string($conn,$_POST['deadline_date']);
        $lessonfile = $_FILES["filename_assign"]["name"];
        $lessonfil = $_FILES["filename_assign"];
        $move_location = "uploads/".basename($_FILES["filename_assign"]["name"]);
        $fileExt = explode('.', $lessonfile);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('pdf', 'docx', 'jpg', 'zip', 'rar', 'png', 'pptx');
        $insertAssignmentQuery = "INSERT INTO `tbl_assignment`(`assign_id`,`assign_name`, `assign_date`, `filename_assign`, `subjectid_assign`, `archivestatus_assign`, `assign_desc`, `datetimestamp_assign`,`deadline_assign`) VALUES (DEFAULT,'$assign_name','$datetime','$lessonfile','$subjectidFromURL','0','$assign_desc', NOW(),'$deadline_date')";
        
        $dateToday = new DateTime(dateTime());
        $dateDeadline = new DateTime($deadline_date);

        if($dateToday > $dateDeadline){
            $_SESSION['errorMessage'] = "Invalid date/time input!";
        }
        else{
            if(!(in_array($fileActualExt, $allowed))){
                $_SESSION['errorMessage'] = "File type is invalid!";
            }
            else{
                if(!($_FILES['filename_assign']['size'] > 25000000)){
                    if(move_uploaded_file($_FILES["filename_assign"]["tmp_name"], $move_location)){
                        if(mysqli_query($conn, $insertAssignmentQuery)){
                            $_SESSION['successMessage'] = "Lesson successfully added!";
                        }
                        else{
                            $_SESSION['errorMessage'] = mysqli_error($conn);
                        }
                    }
                    else{
                        $_SESSION['errorMessage'] = "Error uploading";
                    }
                }
                else{
                    $_SESSION['errorMessage'] = "Maximum file size limit of 25 mb exceeded!";
                }
            }
        }
    }
	
	if(ISSET($_GET['lld'])){
        $assign_id = $_GET['lld'];

        $updateArchiveStatusQuery = "UPDATE tbl_assignment SET archivestatus_assign = '1' WHERE assign_id = '$assign_id'";

        if(mysqli_query($conn, $updateArchiveStatusQuery)){
            $_SESSION['successMessage'] = "Subject info successfully archived!";
            header("Refresh: 3;url=addassignment.php?id=$subjectidFromURL");
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
        <link rel="stylesheet" href="../css/style.css">

        <script src="../jquery/dist/jquery.min.js"></script>
        <script src="../jquery/dist/jquery.slim.min.js"></script>
        <script src="../popper.js/dist/popper.min.js"></script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script src="../gijgo/js/gijgo.min.js"></script>
        <link rel="stylesheet" href="../gijgo/css/gijgo.min.css">
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
            <div class="row mb-5">
                <div class="col">
                    <button type="button" class="btn btn-submit-small btn-sm btn-block mb-5" data-toggle="modal" data-target="#add-assignment">
                        &plus; Add Assignment
                    </button>
                </div>
            </div>
                
            <div class="row mb-5">
                <div class="card card-table mb-3" style="padding-left:0px; padding-right:0px;">
                    <div class="card-header card-table-header">
                        <h1>Assignment</h1>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>File Name</th>
										<th>Deadline</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <?php
                                    $retrieveLessons = "SELECT *
                                                        FROM tbl_assignment
                                                        WHERE subjectid_assign = '$subjectidFromURL' AND archivestatus_assign = 0
                                                        ORDER BY datetimestamp_assign DESC";

                                    $result = mysqli_query($conn, $retrieveLessons);

                                    while($DataRows = mysqli_fetch_assoc($result)){
                                        $assign_name = $DataRows['assign_name'];
                                        $assign_date = $DataRows['assign_date'];
                                        $filename_assign = $DataRows['filename_assign'];
										$assign_id = $DataRows['assign_id'];
										$subjectidFromURL = $DataRows['subjectid_assign'];
										$deadline_assign = $DataRows['deadline_assign'];
                                            if(strlen($filename_assign) > 50){
                                                $newFilename = substr($filename_assign, 0, 50)." ...";
                                            }
                                            else{
                                                $newFilename = $filename_assign;
                                            }											
                                ?>
                                    <tr>
                                        <td><?php echo htmlentities($assign_name); ?></td>
                                        <td><?php echo htmlentities($newFilename); ?></td>
										<td><?php echo $deadline_assign;?></td>
                                        <td class="text-right"><a href="uploads/<?php echo $filename_assign; ?>" class="btn btn-primary mr-3" style="width:40px;" target="_blank" data-toggle="tooltip" data-placement="top" title="VIEW"><i class="fas fa-external-link-alt"></i></a><a href="edit-assignment-info.php?id=<?php echo $subjectidFromURL; ?>&amp;aID=<?php echo $assign_id; ?>" class="btn btn-warning mr-3" style="width:40px;"><i class="far fa-edit"></i></a><a href="addassignment.php?id=<?php echo $subjectidFromURL; ?>&amp;lld=<?php echo $assign_id?>" class="btn btn-danger mr-3" style="width:40px;"><i class="far fa-trash-alt"></i></a></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            
        </div>
    </section>

    <section id="add-subject-modal">
        <div class="modal fade" id="add-assignment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">&plus; Add Assignment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="x-button" aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form class="needs-validation" action="addassignment.php?id=<?php echo $subjectidFromURL; ?>" method="post" id="add-assignment"  enctype="multipart/form-data" novalidate>
                        <div class="form-row mb-3">
                            <div class="col">
                                <label for="assign_name">Assignment Name</label>
                                <input type="text" class="form-control" name="assign_name" id="assign_name" placeholder="e.g. FOIL Method" required>
                                <div class="invalid-feedback">
                                    Lesson name is required!
                                </div>
                            </div>
                        </div>

                        <div class="form-row mb-3">
                            <div class="col">
                                <label for="assign_name">Date and Time</label>
                                <input type="text" class="form-control" name="deadline_date" id="datetimepicker" height="10" required>
								<script>
                                    var datepicker = $('#datetimepicker').datetimepicker({
                                    uiLibrary: 'bootstrap4', 
                                    iconsLibrary: 'fontawesome',
                                    size: 'default',
                                    format: 'yyyy-mm-dd HH:MM',
                                    modal: false,
                                    footer: false
                                    });
                                </script>
                                <div class="invalid-feedback">
                                    Deadline is required!
                                </div>
                            </div>
                        </div>
					
                        
                        <div class="form-row mb-3">
                            <div class="col">
                                <label for="filename_assign">File <span><h1 class="text-muted" style="font-size:10px;display:inline-block;">Max file size: 25mb</h1></span></label>
                                <input type="file" class="form-control" name="filename_assign" id="filename_assign" placeholder="e.g. Mathematics" required>
                                <div class="invalid-feedback">
                                    Lesson File is required!
                                </div>
                            </div>
                        </div>

                        <div class="form-row mb-3">
                            <div class="col">
                                <label for="assign_desc">Description <span><h1 class="text-muted" style="font-size:10px;display:inline-block;">Character limit: 200</h1></span></label>
                                <textarea rows="9" class="form-control" name="assign_desc" id="assign_desc" required></textarea>
                                <div class="invalid-feedback">
                                    Description is required!
                                </div>
                            </div>
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" name="saveAssignment" class="btn btn-success"><i class="far fa-check-circle"></i> Save changes</button>                      
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