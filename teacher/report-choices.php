<?php 
    require_once('../functions/connection.php');
    require_once('../functions/sessions.php');
    require_once('../functions/functions.php');
    require('../fpdf181/fpdf.php'); 
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

    if(ISSET($_GET['sID'])){
        $subjectIDFromURL = $_GET['sID'];
    }
    
    if(ISSET($_POST['generateReport'])){
        $filterBy = mysqli_real_escape_string($conn, $_POST['filterBy']);
        $retriveResidentQuery = "";                                           

        if($filterBy == "Subject Details"){
            class PDF1 extends FPDF {
                function Header(){
                    $this->SetFont('Arial','B',14);
                    $this->Cell(12);
                    
                    //put logo
                    $this->Image('../img/brand-pic-1.png',10,10,35);
                    $this-> SetXY(50,16); 
                    $this->Cell(190,10,'NNHS Innovated and Computerized Education',0,1);
                    $this->SetFont('Arial','B',15);
                    $this-> SetXY(10,40);

                    $conn = mysqli_connect('localhost', 'root', '', 'nnhslms-db');

                    if(ISSET($_GET['sID'])){
                        $subjectIDFromURL = $_GET['sID'];
                    }

                    $this->Cell(170,10,'SUBJECT INFORMATION',0,1,'L');

                    $retrieveSubjName = "SELECT subjectname FROM tbl_subject WHERE subjectid = '$subjectIDFromURL'";

                    $resultSubjName = mysqli_query($conn, $retrieveSubjName);
                    $this->Cell(50,15, '', 0, 1, 'L');
                    while($DataRows = mysqli_fetch_assoc($resultSubjName)){
                        $this->Cell(100,10,'SUBJECT NAME: '.$DataRows['subjectname'],0,1);
                    }
                }
                function Footer(){
                    //add table's bottom line
                    $this->Cell(190,0,'','T',1,'',true);
                    
                    //Go to 1.5 cm from bottom
                    $this->SetY(-15);
                            
                    $this->SetFont('Arial','',8);
                    
                    //width = 0 means the cell is extended up to the right margin
                    $this->Cell(0,10,'Page '.$this->PageNo()." / {pages}",0,0,'C');
                }
            }
            
            $pdf = new PDF1('P', 'mm', 'Letter');
            $pdf->SetMargins(25.4, 25.4);
            $pdf->SetRightMargin(100);
            $pdf->AliasNbPages('{pages}');
            $pdf->SetAutoPageBreak(true,15);
            $pdf->AddPage();

            $dateNow = "SELECT EXTRACT(YEAR FROM NOW()) AS 'yearNow', MONTHNAME(NOW()) AS 'monthNow', EXTRACT(DAY FROM NOW()) AS 'dayNow', EXTRACT(HOUR FROM NOW()) AS 'hourNow', EXTRACT(MINUTE FROM NOW()) AS 'minNow'";

                $resultDateNow = mysqli_query($conn, $dateNow);

                while($DataRows = mysqli_fetch_array($resultDateNow)){
                    $pdf->SetFont('Arial','B', 8);
                    $pdf-> SetXY(290,10);
                    $pdf->Cell(50,10, $DataRows['monthNow']." ".$DataRows['dayNow'].", ".$DataRows['yearNow'], 0, 1, 'R');
                }
            $pdf->SetFont('Arial','B', 14);

            $pdf-> SetY(60);

            $retrieveSubjectInfo = "SELECT * FROM tbl_subject WHERE subjectid = '$subjectIDFromURL'";

            $resultSubjectInfo = mysqli_query($conn, $retrieveSubjectInfo);

            while($DataRows = mysqli_fetch_assoc($resultSubjectInfo)){
                $pdf->Cell(50,15, '', 0, 1, 'L');
                $pdf->Cell(50,15, '', 0, 1, 'L');
                $pdf->Cell(50,10, 'DATE CREATED: '.$DataRows['datetime'], 0, 1, 'L');
                $userid = $DataRows['userid'];
                $accesscode = $DataRows['accesscode'];
                    $retrieveCreator = "SELECT fname, lname from tbl_account WHERE userid = '$userid'";
                    $pdf->Cell(50,15, '', 0, 1, 'L');
                    $resultCreator = mysqli_query($conn, $retrieveCreator);

                    while($DataRows1 = mysqli_fetch_assoc($resultCreator)){
                        $pdf->Cell(50,10, 'CREATED BY: '.$DataRows1['lname']." ".$DataRows1['fname'], 0, 1, 'L');
                    }

                    $countEnrolledStudents = "SELECT COUNT(*) AS 'enrolledCount' FROM tbl_enrollment WHERE accesscode='$accesscode'";
                                                        
                    $resultCountEnrolled = mysqli_query($conn, $countEnrolledStudents);

                    $pdf->Cell(50,15, '', 0, 1, 'L');
                    while($DataRows1 = mysqli_fetch_assoc($resultCountEnrolled)){
                        $pdf->Cell(50,10, 'ENROLLED STUDENTS: '.$DataRows1['enrolledCount'], 0, 1, 'L');
                    }
            }

            $dateNow = "SELECT EXTRACT(YEAR FROM NOW()) AS 'yearNow', MONTHNAME(NOW()) AS 'monthNow', EXTRACT(DAY FROM NOW()) AS 'dayNow', EXTRACT(HOUR FROM NOW()) AS 'hourNow', EXTRACT(MINUTE FROM NOW()) AS 'minNow'";

            $resultDateNow = mysqli_query($conn, $dateNow);

            while($DataRows = mysqli_fetch_array($resultDateNow)){
                $pdf->Output('I', $DataRows['yearNow']."_".$DataRows['monthNow']."_".$DataRows['dayNow']."_".$DataRows['hourNow']."_".$DataRows['minNow']."_subject_details.pdf");
            }
        }
        else if($filterBy == "List of Students(Alphabetically Arranged)"){
        
            class PDF2 extends FPDF {
                function Header(){
                    $this->SetFont('Arial','B',14);
                    $this->Cell(12);
                    
                    //put logo
                    $this->Image('../img/brand-pic-1.png',10,10,35);
                    $this-> SetXY(50,16); 
                    $this->Cell(190,10,'NAVOTAS NATIONAL HIGH SCHOOL Innovated and Computerized Education',0,1);
                    $this->SetFont('Arial','B',15);
                    $this-> SetXY(10,40);

                    $conn = mysqli_connect('localhost', 'root', '', 'nnhslms-db');

                    if(ISSET($_GET['sID'])){
                        $subjectIDFromURL = $_GET['sID'];
                    }

                    $retrieveSubjName = "SELECT subjectname FROM tbl_subject WHERE subjectid = '$subjectIDFromURL'";

                    $resultSubjName = mysqli_query($conn, $retrieveSubjName);

                    while($DataRows = mysqli_fetch_assoc($resultSubjName)){
                        $this->Cell(100,10,'Master List (Alphabetically Arranged) for SUBJECT: '.$DataRows['subjectname'],0,1);
                    }

                    $this->Ln(5);
                    
                    $this->SetFont('Arial','B',11);
                    
                    $this->SetDrawColor(0,0,0);
                    $this->Cell(45,5,'LASTNAME',1,0,'',false);
                    $this->Cell(45,5,'FIRSTNAME',1,0,'',false);
                    $this->Cell(22,5,'GNDR',1,0,'',false);
                    $this->Cell(30,5,'BIRTHDATE',1,0,'',false);
                    $this->Cell(10,5,'AGE',1,0,'',false);
                    $this->Cell(55,5,'EMAIL',1,0,'',false);
                    $this->Cell(35,5,'CONTACT NO',1,0,'',false);
                    $this->Cell(70,5,'DATE JOINED',1,1,'',false);
                }
                function Footer(){
                    //add table's bottom line
                    $this->Cell(190,0,'','T',1,'',true);
                    
                    //Go to 1.5 cm from bottom
                    $this->SetY(-15);
                            
                    $this->SetFont('Arial','',8);
                    
                    //width = 0 means the cell is extended up to the right margin
                    $this->Cell(0,10,'Page '.$this->PageNo()." / {pages}",0,0,'C');
                }
            }
            
            $pdf = new PDF2('L', 'mm', 'Legal');
            $pdf->SetMargins(25.4, 25.4);
            $pdf->SetRightMargin(100);
            $pdf->AliasNbPages('{pages}');
            $pdf->SetAutoPageBreak(true,15);
            $pdf->AddPage();

            $dateNow = "SELECT EXTRACT(YEAR FROM NOW()) AS 'yearNow', MONTHNAME(NOW()) AS 'monthNow', EXTRACT(DAY FROM NOW()) AS 'dayNow', EXTRACT(HOUR FROM NOW()) AS 'hourNow', EXTRACT(MINUTE FROM NOW()) AS 'minNow'";

                $resultDateNow = mysqli_query($conn, $dateNow);

                while($DataRows = mysqli_fetch_array($resultDateNow)){
                    $pdf->SetFont('Arial','B', 8);
                    $pdf-> SetXY(290,10);
                    $pdf->Cell(50,10, $DataRows['monthNow']." ".$DataRows['dayNow'].", ".$DataRows['yearNow'], 0, 1, 'R');
                }
            $pdf->SetFont('Arial','B', 14);

            $pdf-> SetY(60);

            $retrieveListAlphabetically = "SELECT fname, lname, gender, birthdate, age, email, contactno, datestamp FROM tbl_account A JOIN tbl_enrollment E ON A.enrollment_id = E.enrollment_id_student JOIN tbl_subject S ON E.accesscode = S.accesscode WHERE S.archivestatus = 0 AND subjectid = '$subjectIDFromURL' ORDER BY lname ASC";

            $resultListAlphabetically = mysqli_query($conn, $retrieveListAlphabetically);

            while($DataRows = mysqli_fetch_assoc($resultListAlphabetically)){
                $pdf->Cell(45,8,$DataRows['lname'],1,0,'',false);
                $pdf->Cell(45,8,$DataRows['fname'],1,0,'',false);
                $pdf->Cell(22,8,$DataRows['gender'],1,0,'',false);
                $pdf->Cell(30,8,$DataRows['birthdate'],1,0,'',false);
                $pdf->Cell(10,8,$DataRows['age'],1,0,'',false);
                $pdf->Cell(55,8,$DataRows['email'],1,0,'',false);
                $pdf->Cell(35,8,$DataRows['contactno'],1,0,'',false);
                $pdf->Cell(70,8,$DataRows['datestamp'],1,1,'',false);
            }
            $dateNow = "SELECT EXTRACT(YEAR FROM NOW()) AS 'yearNow', MONTHNAME(NOW()) AS 'monthNow', EXTRACT(DAY FROM NOW()) AS 'dayNow', EXTRACT(HOUR FROM NOW()) AS 'hourNow', EXTRACT(MINUTE FROM NOW()) AS 'minNow'";

            $resultDateNow = mysqli_query($conn, $dateNow);

            while($DataRows = mysqli_fetch_array($resultDateNow)){
                $pdf->Output('I', $DataRows['yearNow']."_".$DataRows['monthNow']."_".$DataRows['dayNow']."_".$DataRows['hourNow']."_".$DataRows['minNow']."_student_list_alphabetical.pdf");
            }
        }
        else if($filterBy == "List of Students(Gender- Male)"){
            class PDF3 extends FPDF {
                function Header(){
                    $this->SetFont('Arial','B',14);
                    $this->Cell(12);
                    
                    //put logo
                    $this->Image('../img/brand-pic-1.png',10,10,35);
                    $this-> SetXY(50,16); 
                    $this->Cell(190,10,'NAVOTAS NATIONAL HIGH SCHOOL Innovated and Computerized Education',0,1);
                    $this->SetFont('Arial','B',15);
                    $this-> SetXY(10,40);

                    $conn = mysqli_connect('localhost', 'root', '', 'nnhslms-db');

                    if(ISSET($_GET['sID'])){
                        $subjectIDFromURL = $_GET['sID'];
                    }

                    $retrieveSubjName = "SELECT subjectname FROM tbl_subject WHERE subjectid = '$subjectIDFromURL'";

                    $resultSubjName = mysqli_query($conn, $retrieveSubjName);

                    while($DataRows = mysqli_fetch_assoc($resultSubjName)){
                        $this->Cell(100,10,'Master List (Male Students) for SUBJECT: '.$DataRows['subjectname'],0,1);
                    }

                    $this->Ln(5);
                    
                    $this->SetFont('Arial','B',11);
                    
                    $this->SetDrawColor(0,0,0);
                    $this->Cell(45,5,'LASTNAME',1,0,'',false);
                    $this->Cell(45,5,'FIRSTNAME',1,0,'',false);
                    $this->Cell(22,5,'GNDR',1,0,'',false);
                    $this->Cell(30,5,'BIRTHDATE',1,0,'',false);
                    $this->Cell(10,5,'AGE',1,0,'',false);
                    $this->Cell(55,5,'EMAIL',1,0,'',false);
                    $this->Cell(35,5,'CONTACT NO',1,0,'',false);
                    $this->Cell(70,5,'DATE JOINED',1,1,'',false);
                }
                function Footer(){
                    //add table's bottom line
                    $this->Cell(190,0,'','T',1,'',true);
                    
                    //Go to 1.5 cm from bottom
                    $this->SetY(-15);
                            
                    $this->SetFont('Arial','',8);
                    
                    //width = 0 means the cell is extended up to the right margin
                    $this->Cell(0,10,'Page '.$this->PageNo()." / {pages}",0,0,'C');
                }
            }
            
            $pdf = new PDF3('L', 'mm', 'Legal');
            $pdf->SetMargins(25.4, 25.4);
            $pdf->SetRightMargin(100);
            $pdf->AliasNbPages('{pages}');
            $pdf->SetAutoPageBreak(true,15);
            $pdf->AddPage();

            $dateNow = "SELECT EXTRACT(YEAR FROM NOW()) AS 'yearNow', MONTHNAME(NOW()) AS 'monthNow', EXTRACT(DAY FROM NOW()) AS 'dayNow', EXTRACT(HOUR FROM NOW()) AS 'hourNow', EXTRACT(MINUTE FROM NOW()) AS 'minNow'";

                $resultDateNow = mysqli_query($conn, $dateNow);

                while($DataRows = mysqli_fetch_array($resultDateNow)){
                    $pdf->SetFont('Arial','B', 8);
                    $pdf-> SetXY(290,10);
                    $pdf->Cell(50,10, $DataRows['monthNow']." ".$DataRows['dayNow'].", ".$DataRows['yearNow'], 0, 1, 'R');
                }
            $pdf->SetFont('Arial','B', 14);

            $pdf-> SetY(60);

            $retrieveListAlphabetically = "SELECT fname, lname, gender, birthdate, age, email, contactno, datestamp FROM tbl_account A JOIN tbl_enrollment E ON A.enrollment_id = E.enrollment_id_student JOIN tbl_subject S ON E.accesscode = S.accesscode WHERE S.archivestatus = 0 AND subjectid = '$subjectIDFromURL' AND gender='MALE' ORDER BY lname ASC";

            $resultListAlphabetically = mysqli_query($conn, $retrieveListAlphabetically);

            while($DataRows = mysqli_fetch_assoc($resultListAlphabetically)){
                $pdf->Cell(45,8,$DataRows['lname'],1,0,'',false);
                $pdf->Cell(45,8,$DataRows['fname'],1,0,'',false);
                $pdf->Cell(22,8,$DataRows['gender'],1,0,'',false);
                $pdf->Cell(30,8,$DataRows['birthdate'],1,0,'',false);
                $pdf->Cell(10,8,$DataRows['age'],1,0,'',false);
                $pdf->Cell(55,8,$DataRows['email'],1,0,'',false);
                $pdf->Cell(35,8,$DataRows['contactno'],1,0,'',false);
                $pdf->Cell(70,8,$DataRows['datestamp'],1,1,'',false);
            }
            $dateNow = "SELECT EXTRACT(YEAR FROM NOW()) AS 'yearNow', MONTHNAME(NOW()) AS 'monthNow', EXTRACT(DAY FROM NOW()) AS 'dayNow', EXTRACT(HOUR FROM NOW()) AS 'hourNow', EXTRACT(MINUTE FROM NOW()) AS 'minNow'";

            $resultDateNow = mysqli_query($conn, $dateNow);

            while($DataRows = mysqli_fetch_array($resultDateNow)){
                $pdf->Output('I', $DataRows['yearNow']."_".$DataRows['monthNow']."_".$DataRows['dayNow']."_".$DataRows['hourNow']."_".$DataRows['minNow']."_male_student_list.pdf");
            }
        }
        else{
            class PDF4 extends FPDF {
                function Header(){
                    $this->SetFont('Arial','B',14);
                    $this->Cell(12);
                    
                    //put logo
                    $this->Image('../img/brand-pic-1.png',10,10,35);
                    $this-> SetXY(50,16); 
                    $this->Cell(190,10,'NAVOTAS NATIONAL HIGH SCHOOL Innovated and Computerized Education',0,1);
                    $this->SetFont('Arial','B',15);
                    $this-> SetXY(10,40);

                    $conn = mysqli_connect('localhost', 'root', '', 'nnhslms-db');

                    if(ISSET($_GET['sID'])){
                        $subjectIDFromURL = $_GET['sID'];
                    }

                    $retrieveSubjName = "SELECT subjectname FROM tbl_subject WHERE subjectid = '$subjectIDFromURL'";

                    $resultSubjName = mysqli_query($conn, $retrieveSubjName);

                    while($DataRows = mysqli_fetch_assoc($resultSubjName)){
                        $this->Cell(100,10,'Master List (Female Students) for SUBJECT: '.$DataRows['subjectname'],0,1);
                    }

                    $this->Ln(5);
                    
                    $this->SetFont('Arial','B',11);
                    
                    $this->SetDrawColor(0,0,0);
                    $this->Cell(45,5,'LASTNAME',1,0,'',false);
                    $this->Cell(45,5,'FIRSTNAME',1,0,'',false);
                    $this->Cell(22,5,'GNDR',1,0,'',false);
                    $this->Cell(30,5,'BIRTHDATE',1,0,'',false);
                    $this->Cell(10,5,'AGE',1,0,'',false);
                    $this->Cell(55,5,'EMAIL',1,0,'',false);
                    $this->Cell(35,5,'CONTACT NO',1,0,'',false);
                    $this->Cell(70,5,'DATE JOINED',1,1,'',false);
                }
                function Footer(){
                    //add table's bottom line
                    $this->Cell(190,0,'','T',1,'',true);
                    
                    //Go to 1.5 cm from bottom
                    $this->SetY(-15);
                            
                    $this->SetFont('Arial','',8);
                    
                    //width = 0 means the cell is extended up to the right margin
                    $this->Cell(0,10,'Page '.$this->PageNo()." / {pages}",0,0,'C');
                }
            }
            
            $pdf = new PDF4('L', 'mm', 'Legal');
            $pdf->SetMargins(25.4, 25.4);
            $pdf->SetRightMargin(100);
            $pdf->AliasNbPages('{pages}');
            $pdf->SetAutoPageBreak(true,15);
            $pdf->AddPage();

            $dateNow = "SELECT EXTRACT(YEAR FROM NOW()) AS 'yearNow', MONTHNAME(NOW()) AS 'monthNow', EXTRACT(DAY FROM NOW()) AS 'dayNow', EXTRACT(HOUR FROM NOW()) AS 'hourNow', EXTRACT(MINUTE FROM NOW()) AS 'minNow'";

                $resultDateNow = mysqli_query($conn, $dateNow);

                while($DataRows = mysqli_fetch_array($resultDateNow)){
                    $pdf->SetFont('Arial','B', 8);
                    $pdf-> SetXY(290,10);
                    $pdf->Cell(50,10, $DataRows['monthNow']." ".$DataRows['dayNow'].", ".$DataRows['yearNow'], 0, 1, 'R');
                }
            $pdf->SetFont('Arial','B', 14);

            $pdf-> SetY(60);

            $retrieveListAlphabetically = "SELECT fname, lname, gender, birthdate, age, email, contactno, datestamp FROM tbl_account A JOIN tbl_enrollment E ON A.enrollment_id = E.enrollment_id_student JOIN tbl_subject S ON E.accesscode = S.accesscode WHERE S.archivestatus = 0 AND subjectid = '$subjectIDFromURL' AND gender='FEMALE' ORDER BY lname ASC";

            $resultListAlphabetically = mysqli_query($conn, $retrieveListAlphabetically);

            while($DataRows = mysqli_fetch_assoc($resultListAlphabetically)){
                $pdf->Cell(45,8,$DataRows['lname'],1,0,'',false);
                $pdf->Cell(45,8,$DataRows['fname'],1,0,'',false);
                $pdf->Cell(22,8,$DataRows['gender'],1,0,'',false);
                $pdf->Cell(30,8,$DataRows['birthdate'],1,0,'',false);
                $pdf->Cell(10,8,$DataRows['age'],1,0,'',false);
                $pdf->Cell(55,8,$DataRows['email'],1,0,'',false);
                $pdf->Cell(35,8,$DataRows['contactno'],1,0,'',false);
                $pdf->Cell(70,8,$DataRows['datestamp'],1,1,'',false);
            }
            $dateNow = "SELECT EXTRACT(YEAR FROM NOW()) AS 'yearNow', MONTHNAME(NOW()) AS 'monthNow', EXTRACT(DAY FROM NOW()) AS 'dayNow', EXTRACT(HOUR FROM NOW()) AS 'hourNow', EXTRACT(MINUTE FROM NOW()) AS 'minNow'";

            $resultDateNow = mysqli_query($conn, $dateNow);

            while($DataRows = mysqli_fetch_array($resultDateNow)){
                $pdf->Output('I', $DataRows['yearNow']."_".$DataRows['monthNow']."_".$DataRows['dayNow']."_".$DataRows['hourNow']."_".$DataRows['minNow']."_female_student_list.pdf");
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

        <section id="file-blotter">
            <div class="container" style="margin-bottom: 212px;">
            <?php echo errorMessage(); echo successMessage(); ?>
                <div class="row">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-6">
                        <div class="card card-table" style="padding-left:0px;padding-right:0px;">
                            <div class="card-header card-table-header">
                                <h1>Report of:</h1>
                            </div>
                            <div class="card-body">
                                <div class="container">
                                    <div class="row mb-5">
                                        <div class="col">
                                        <form class="needs-validation" action="report-choices.php?sID=<?php echo $subjectIDFromURL; ?>" method="post" id="add-resident-form" novalidate>
                                            <div class="form-row mb-5">
                                                <div class="col">
                                                    <label for="datepicker" class="input-label">Filter by:</label>
                                                    <select name="filterBy" id="" class="form-control">
                                                        <option value="Subject Details">Subject Details</option>
                                                        <option value="List of Students(Alphabetically Arranged)">List of Students(Alphabetically Arranged)</option>
                                                        <option value="List of Students(Gender- Male)">List of Students(Gender- Male)</option>
                                                        <option value="List of Students(Gender- Female)">List of Students(Gender- Female)</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="generateReport" class="btn btn-success"><i class="far fa-check-circle"></i> Generate report</button>
                            </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-3">
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