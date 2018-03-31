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

    if(isset($_POST['saveLessonFile'])){
        $lessonname = mysqli_real_escape_string($conn, $_POST['lessonname']);
        $lessondesc = mysqli_real_escape_string($conn, $_POST['lessondesc']);
        $datetime = dateTimeFormat();
        $lessonfile = $_FILES["lessonfile"]["name"];
        $lessonfil = $_FILES["lessonfile"];
        $move_location = "uploads/".basename($_FILES["lessonfile"]["name"]);
        $fileExt = explode('.', $lessonfile);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('pdf', 'docx', 'jpg', 'zip', 'rar', 'png', 'pptx');
        $insertLessonQuery = "INSERT INTO `tbl_lesson_file`(`lessonname_file`, `dateposted_file`, `filename`, `subjectid_file`, `archivestatus_file`, `lessondesc_file`, `datetimestamp`) VALUES ('$lessonname','$datetime','$lessonfile','$subjectidFromURL','0','$lessondesc', NOW())";
        
        if(file_exists($move_location)){
            $_SESSION['errorMessage'] = "File name already exists!";
        }
        else{
            if(!(in_array($fileActualExt, $allowed))){
                $_SESSION['errorMessage'] = "File type is invalid!";
            }
            else{
                if(!($_FILES['lessonfile']['size'] > 25000000)){
                    if(move_uploaded_file($_FILES["lessonfile"]["tmp_name"], $move_location)){
                        if(mysqli_query($conn, $insertLessonQuery)){
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

    if(isset($_POST['saveLessonURL'])){
        $lessonname = mysqli_real_escape_string($conn, $_POST['lessonname']);
        $lessonurl = mysqli_real_escape_string($conn, $_POST['lessonurl']);
        $lessondesc = mysqli_real_escape_string($conn, $_POST['lessondesc']);
        $datetime = dateTimeFormat();
        $insertLessonURLQuery = "INSERT INTO `tbl_lesson_url`(`lessonname_url`, `dateposted_url`, `url`, `subjectid_url`, `archivestatus_url`, `lessondesc_url`, `datetimestamp`) VALUES ('$lessonname','$datetime','$lessonurl','$subjectidFromURL','0','$lessondesc', NOW())";
        $existingURL = "SELECT * FROM `tbl_lesson_url` WHERE 'url' = '$lessonurl' AND archivestatus_url = '0' AND subjectid_url = '$subjectidFromURL'";

        $urlCount = mysqli_query($conn, $existingURL);
        $count = mysqli_num_rows($urlCount);

        if($count > 0){
            $_SESSION['errorMessage'] = "URL already exists!";
        }
        else{
            if(!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $lessonurl)){
                $_SESSION['errorMessage'] = "URL is invalid!";
            }
            else{
                if(mysqli_query($conn, $insertLessonURLQuery)){
                    $_SESSION['successMessage'] = "Lesson successfully added!";
                }
                else{
                    $_SESSION['errorMessage'] = mysqli_error($conn);
                }
            }
        }
    }
	
	if(ISSET($_GET['lld'])){
        $LessonFromFile = $_GET['lld'];

        $updateArchiveStatusQuery = "UPDATE tbl_lesson_file SET archivestatus_file = '1' WHERE lessonid_file = '$LessonFromFile'";

        if(mysqli_query($conn, $updateArchiveStatusQuery)){
            $_SESSION['successMessage'] = "Subject info successfully archived!";
            header("Refresh: 3;url=lesson-panel.php?id=$subjectidFromURL");
        }
        else{
            $_SESSION['errorMessage'] = mysqli_error($conn);
        }
    }
	if(ISSET($_GET['lld'])){
        $LessonFromURL = $_GET['lld'];

        $updateArchiveStatusQueryForUrl = "UPDATE tbl_lesson_url SET archivestatus_url = '1' WHERE lessonid_url = '$LessonFromURL'";

        if(mysqli_query($conn, $updateArchiveStatusQueryForUrl)){
            $_SESSION['successMessage'] = "Subject info successfully archived!";
            header("Refresh: 3;url=lesson-panel.php?id=$subjectidFromURL");
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
            <div class="row mb-5">
                <div class="col">
                    <button type="button" class="btn btn-submit-small btn-sm btn-block mb-5" data-toggle="modal" data-target="#add-lesson-file">
                        &plus; Add Lesson from File
                    </button>
                </div>

                <div class="col">
                    <button type="button" class="btn btn-submit-small btn-sm btn-block mb-5" data-toggle="modal" data-target="#add-lesson-url">
                        &plus; Add Lesson from URL
                    </button>
                </div>
            </div>
                
            <div class="row mb-5">
                <div class="card card-table mb-3" style="padding-left:0px; padding-right:0px;">
                    <div class="card-header card-table-header">
                        <h1>Lesson from File</h1>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Date Added</th>
                                        <th>Filename</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <?php
                                    $retrieveLessons = "SELECT *
                                                        FROM tbl_lesson_file
                                                        WHERE subjectid_file = '$subjectidFromURL' AND archivestatus_file = 0
                                                        ORDER BY datetimestamp DESC";

                                    $result = mysqli_query($conn, $retrieveLessons);

                                    while($DataRows = mysqli_fetch_assoc($result)){
                                        $lessonname_file = $DataRows['lessonname_file'];
                                        $dateposted_file = $DataRows['dateposted_file'];
                                        $filename = $DataRows['filename'];
										$lessonid_file = $DataRows['lessonid_file'];
										$subjectidFromURL = $DataRows['subjectid_file'];
                                            if(strlen($filename) > 50){
                                                $newFilename = substr($filename, 0, 50)." ...";
                                            }
                                            else{
                                                $newFilename = $filename;
                                            }
                                ?>
                                    <tr>
                                        <td><?php echo htmlentities($lessonname_file); ?></td>
                                        <td><?php echo htmlentities($dateposted_file); ?></td>
                                        <td><?php echo htmlentities($newFilename); ?></td>
                                        <td class="text-right"><a href="uploads/<?php echo $filename; ?>" class="btn btn-primary mr-3" style="width:40px;" target="_blank" data-toggle="tooltip" data-placement="top" title="VIEW"><i class="fas fa-external-link-alt"></i></a><a href="" class="btn btn-warning mr-3" style="width:40px;"><i class="far fa-edit"></i></a><a href="lesson-panel.php?id=<?php echo $subjectidFromURL; ?>&amp;lld=<?php echo $lessonid_file?>" class="btn btn-danger mr-3" style="width:40px;"><i class="far fa-trash-alt"></i></a></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row mt-5 mb-5">
                <div class="card card-table mb-3" style="padding-left:0px; padding-right:0px;">
                    <div class="card-header card-table-header">
                        <h1>Lesson from URL</h1>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Date Added</th>
                                        <th>URL</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <?php
                                    $retrieveLessons = "SELECT *
                                                        FROM tbl_lesson_url
                                                        WHERE subjectid_url = '$subjectidFromURL' AND archivestatus_url = 0
                                                        ORDER BY datetimestamp DESC";

                                    $result = mysqli_query($conn, $retrieveLessons);

                                    while($DataRows = mysqli_fetch_assoc($result)){
                                        $lessonname_url = $DataRows['lessonname_url'];
                                        $dateposted_url = $DataRows['dateposted_url'];
                                        $url = $DataRows['url'];
										$subjectid_url = $DataRows['subjectid_url'];
										$lessonid_url = $DataRows['lessonid_url'];
                                            if(strlen($url) > 50){
                                                $newUrl = substr($url, 0, 50)." ...";
                                            }
                                            else{
                                                $newUrl = $url;
                                            }
                                ?>
                                    <tr>
                                        <td><?php echo htmlentities($lessonname_url); ?></td>
                                        <td><?php echo htmlentities($dateposted_url); ?></td>
                                        <td><?php echo htmlentities($newUrl); ?></td>
                                        <td class="text-right"><a href="<?php echo $url; ?>" class="btn btn-primary mr-3" style="width:40px;" target="_blank" data-toggle="tooltip" data-placement="top" title="VIEW"><i class="fas fa-external-link-alt"></i></a><a href="" class="btn btn-warning mr-3" style="width:40px;"><i class="far fa-edit"></i></a><a href="lesson-panel.php?id=<?php echo $subjectidFromURL; ?>&amp;lld=<?php echo $lessonid_url?>" class="btn btn-danger mr-3" style="width:40px;"><i class="far fa-trash-alt"></i></a></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="add-subject-modal">
        <div class="modal fade" id="add-lesson-file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">&plus; Add Lesson from File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="x-button" aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form class="needs-validation" action="lesson-panel.php?id=<?php echo $subjectidFromURL; ?>" method="post" id="add-lesson-form-file"  enctype="multipart/form-data" novalidate>
                        <div class="form-row mb-3">
                            <div class="col">
                                <label for="lessonname">Lesson name</label>
                                <input type="text" class="form-control" name="lessonname" id="lessonname" placeholder="e.g. FOIL Method" required>
                                <div class="invalid-feedback">
                                    Lesson name is required!
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-row mb-3">
                            <div class="col">
                                <label for="lessonfile">File <span><h1 class="text-muted" style="font-size:10px;display:inline-block;">Max file size: 25mb</h1></span></label>
                                <input type="file" class="form-control" name="lessonfile" id="lessonfile" placeholder="e.g. Mathematics" required>
                                <div class="invalid-feedback">
                                    Lesson File is required!
                                </div>
                            </div>
                        </div>

                        <div class="form-row mb-3">
                            <div class="col">
                                <label for="lessondesc">Description <span><h1 class="text-muted" style="font-size:10px;display:inline-block;">Character limit: 200</h1></span></label>
                                <textarea rows="9" class="form-control" name="lessondesc" id="lessondesc" required></textarea>
                                <div class="invalid-feedback">
                                    Description is required!
                                </div>
                            </div>
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" name="saveLessonFile" class="btn btn-success"><i class="far fa-check-circle"></i> Save changes</button>                      
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-times-circle"></i> Close</button>
                </form>
                </div>
            </div>
            </div>
        </div>

        <div class="modal fade" id="add-lesson-url" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">&plus; Add Lesson from URL</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="x-button" aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form class="needs-validation" action="lesson-panel.php?id=<?php echo $subjectidFromURL; ?>" method="post" id="add-lesson-form-url" novalidate>
                        <div class="form-row mb-3">
                            <div class="col">
                                <label for="lessonname">Lesson name</label>
                                <input type="text" class="form-control" name="lessonname" id="lessonname" placeholder="e.g. FOIL Method" required>
                                <div class="invalid-feedback">
                                    Lesson name is required!
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-row mb-3">
                            <div class="col">
                                <label for="lessonurl">URL</label>
                                <input type="text" class="form-control" name="lessonurl" id="lessonurl" placeholder="e.g. https://www.google.com.ph/" required>
                                <div class="invalid-feedback">
                                    Lesson URL is required!
                                </div>
                            </div>
                        </div>

                        <div class="form-row mb-3">
                            <div class="col">
                                <label for="lessondesc">Description <span><h1 class="text-muted" style="font-size:10px;display:inline-block;">Character limit: 200</h1></span></label>
                                <textarea rows="9" class="form-control" name="lessondesc" id="lessondesc" required></textarea>
                                <div class="invalid-feedback">
                                    Description is required!
                                </div>
                            </div>
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" name="saveLessonURL" class="btn btn-success"><i class="far fa-check-circle"></i> Save changes</button>                      
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