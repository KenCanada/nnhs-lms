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

    <section id="subject-info-panel">
        <div class="container mb-5">
        <?php echo errorMessage(); echo successMessage(); ?>
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
                                        <td class="text-right"><a href="../teacher/uploads/<?php echo $filename; ?>" class="btn btn-primary mr-3" style="width:40px;" target="_blank" data-toggle="tooltip" data-placement="top" title="VIEW"><i class="fas fa-external-link-alt"></i></a></td>
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
                                        <td class="text-right"><a href="<?php echo $url; ?>" class="btn btn-primary mr-3" style="width:40px;" target="_blank" data-toggle="tooltip" data-placement="top" title="VIEW"><i class="fas fa-external-link-alt"></i></a></td>
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