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
    
    if(isset($_POST['saveSubject'])){

        $subjectname = mysqli_real_escape_string($conn, $_POST['subjectname']);
        $datetime = dateTimeFormat();
        $subjectnamecode = substr($subjectname, 0, 3);
        $accesscode = datee().$subjectnamecode.Timee();
        
        $existingSubjectQuery = "SELECT * FROM tbl_subject WHERE subjectname = '$subjectname' AND userid = '$userid'";

        $result = mysqli_query($conn, $existingSubjectQuery);

        $subjectcount = mysqli_num_rows($result);

        if($subjectcount > 0){
            $_SESSION['errorMessage'] = "Subject already exists!";
        }
        else{
            $insertSubjectQuery = "INSERT INTO `tbl_subject`(`subjectname`, `accesscode`, `datetime`, `archivestatus`, `subjectid`, `userid`, `datetimestamp`) VALUES ('$subjectname','$accesscode','$datetime', '0', md5('$accesscode'), '$userid', NOW())";

            if(mysqli_query($conn, $insertSubjectQuery)){
                $_SESSION['successMessage'] = $subjectname." subject successfully added! ACCESS CODE: ".$accesscode;
            }
            else{
                $_SESSION['errorMessage'] = mysqli_error($conn);
            }
        }
    }

    if(ISSET($_GET['lld'])){
        $subjectidFromURL = $_GET['lld'];

        $updateArchiveStatusQuery = "UPDATE tbl_subject SET archivestatus = '0' WHERE subjectid = '$subjectidFromURL'";

        if(mysqli_query($conn, $updateArchiveStatusQuery)){
            $_SESSION['successMessage'] = "Subject info successfully unarchived!";
            header("Refresh: 3;url=archivedsubjects.php?id=$subjectidFromURL");
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
                        <img src="../img/brand-pic.png" alt="" width="150px" class="mb-3">
                    </a>

                    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNav">
                        <span> </span>
                        <span> </span>
                        <span> </span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
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
            <div class="container">
            <?php echo errorMessage(); echo successMessage(); ?>
                <div class="row">
                    <div class="col-md-9">
                        <div class="row">
                            
                        </div>

                        <div class="row mt-5">
                            <div class="col">
                                <div class="card card-table mb-3" style="padding-left:0px; padding-right:0px;">
                                <div class="card-header card-table-header">
                                    <h1>Archived Subjects</h1>
                                </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped text-center">
                                                <thead>
                                                    <tr>
                                                        <th>Subject Name</th>
                                                        <th>Access Code</th>
                                                        <th>Students Enrolled</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                            <?php
                                                $retrieveSubjectsQuery = "SELECT * FROM tbl_subject WHERE archivestatus = '1' AND userid = '$userid' ORDER BY datetimestamp DESC";

                                                $result = mysqli_query($conn, $retrieveSubjectsQuery);

                                                while($DataRows = mysqli_fetch_assoc($result)){
                                                    $subjectname = $DataRows['subjectname'];
                                                    $accesscode = $DataRows['accesscode'];
                                                    $subjectid = $DataRows['subjectid'];
                                            ?>
                                                <tr>
                                                    <td><a href="subject-info-panel.php?id=<?php echo $subjectid; ?>"><?php echo $subjectname; ?></a></td>
                                                    <td><?php echo $accesscode; ?></td>
                                                    <td>18</td>
                                                    <td><a href="archivedsubjects.php?id=<?php echo $userid; ?>&amp;lld=<?php echo $subjectid; ?>" class="btn btn-warning btn-block">Unarchive</a></td>
                                                </tr>
                                            <?php } ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="row mb-5">
                            <div class="col">
                                <div class="card text-center card-table" style="width: 100%;">
                                    <div class="card-header">
                                        <h5 class="card-title count-title">Subject/s</h5>
                                    </div>
                                    <div class="card-body">
                                    <?php
                                        $retrieveSubjectsCountQuery = "SELECT COUNT(*) AS subjectcount FROM tbl_subject WHERE archivestatus = '0' AND userid = $userid";

                                        $result = mysqli_query($conn, $retrieveSubjectsCountQuery);

                                        while($DataRows = mysqli_fetch_assoc($result)){
                                            $subjectcount = $DataRows['subjectcount'];
                                        }
                                    ?>
                                        <p class="card-text count-lbl"><i class="fas fa-book"></i>&nbsp;&nbsp;<?php echo $subjectcount; ?></p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="manage-subj-panel.php" class="btn btn-outline-submit btn-sm btn-block">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col">
                                <div class="card text-center card-table" style="width: 100%;">
                                    <div class="card-header">
                                        <h5 class="card-title count-title">Archived Subject/s</h5>
                                    </div>
                                    <div class="card-body">
                                    <?php
                                        $retrieveArchivedSubjectsCountQuery = "SELECT COUNT(*) AS subjectcount FROM tbl_subject WHERE archivestatus = '1' AND userid = $userid";

                                        $result = mysqli_query($conn, $retrieveArchivedSubjectsCountQuery);

                                        while($DataRows = mysqli_fetch_assoc($result)){
                                            $subjectcount = $DataRows['subjectcount'];
                                        }
                                    ?>
                                        <p class="card-text count-lbl"><i class="fas fa-archive"></i>&nbsp;&nbsp;<?php echo $subjectcount; ?></p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="#" class="btn btn-outline-submit btn-sm btn-block">View</a>
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