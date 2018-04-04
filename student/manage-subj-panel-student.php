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

<?php
    global $conn;
    
    if(ISSET($_POST['enrollSubject'])){
        $accesscode = mysqli_real_escape_string($conn, $_POST['accesscode']);
        $datestamp = dateTimeFormat();

        $accesscodeExistingQuery = "SELECT * FROM tbl_subject WHERE accesscode = '$accesscode' AND archivestatus = '0'";
    
        $resultAccesscode = mysqli_query($conn, $accesscodeExistingQuery);

        $resultCountAccesscode = mysqli_num_rows($resultAccesscode);

        if($resultCountAccesscode == 0){
            $_SESSION['errorMessage'] = "Access code doesn't exists!";
        }
        else{
            $alreadyEnrolledQuery = "SELECT * FROM tbl_enrollment WHERE accesscode = '$accesscode' AND enrollment_id_student = '$enrollmentid'";

            $resultAlreadyEnrolled = mysqli_query($conn, $alreadyEnrolledQuery);

            $resultCountAlreadyEnrolled = mysqli_num_rows($resultAlreadyEnrolled);

            if($resultCountAlreadyEnrolled > 0){
                $_SESSION['errorMessage'] = "Subject already enrolled!";
            }
            else{
                $insertToEnrollment = "INSERT INTO `tbl_enrollment`(`enrollment_id_student`, `accesscode`, `datestamp`) VALUES ('$enrollmentid', '$accesscode', '$datestamp')";

                if(mysqli_query($conn, $insertToEnrollment)){
                    $_SESSION['successMessage'] = "Subject successfully enrolled!";
                }
                else{
                    $_SESSION['errorMessage'] = mysqli_error($conn);
                }
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
                    <a href="student-panel.php" class="navbar-brand brand mt-3 mr-5">
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

        <section id="manage-subj-menu">
            <div class="container mb-5">
            <?php echo errorMessage(); echo successMessage(); ?>
                <div class="row">
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                <button type="button" class="btn btn-submit-small btn-sm btn-block" data-toggle="modal" data-target="#enroll-subject">
                                    &plus; Enroll subject
                                </button>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col">
                                <div class="card card-table mb-3" style="padding-left:0px; padding-right:0px;">
                                <div class="card-header card-table-header">
                                    <h1>Enrolled Subjects</h1>
                                </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-striped text-center">
                                                <thead>
                                                    <tr>
                                                        <th>Subject Name</th>
                                                        <th>Access Code</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                            <?php
                                                $retrieveSubjectsQuery = "SELECT subjectname, S.accesscode, datetime, subjectid
                                                                          FROM tbl_subject S JOIN tbl_enrollment E
                                                                          ON S.accesscode = E.accesscode
                                                                          WHERE archivestatus = 0 AND enrollment_id_student = 1";

                                                $result = mysqli_query($conn, $retrieveSubjectsQuery);

                                                while($DataRows = mysqli_fetch_assoc($result)){
                                                    $subjectname = $DataRows['subjectname'];
                                                    $accesscode = $DataRows['accesscode'];
                                                    $subjectid = $DataRows['subjectid'];
                                            ?>
                                                <tr>
                                                    <td><a href="subject-info-panel-student.php?id=<?php echo $subjectid; ?>"><?php echo $subjectname; ?></a></td>
                                                    <td><?php echo $accesscode; ?></td>
                                                    <td>18</td>
                                                    <td><a href="manage-subj-panel.php?archive=<?php echo $subjectid; ?>" class="btn btn-warning btn-block">Archive</a></td>
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

        <section id="add-subject-modal">
            <div class="modal fade" id="enroll-subject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">&plus; Enroll subject</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="x-button" aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="add-subject-form">
                            <div class="form-row mb-3">
                                <div class="col">
                                    <label for="accesscode">Access code</label>
                                    <input type="text" class="form-control" name="accesscode" id="subjname" placeholder="e.g. 2099456filpm090" required>
                                </div>
                            </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" name="enrollSubject" class="btn btn-success"><i class="far fa-check-circle"></i> Save changes</button>                      
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

        <a href="javascript:" id="return-to-top" class="top-arr">
            <i class="fas fa-chevron-up"></i>
        </a>

        <script src="../js/index.js"></script>
        <script src='../js/jquery-3.3.1.min.js'></script>
    </body>
</html>