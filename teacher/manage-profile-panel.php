<?php 
    require_once('../functions/connection.php');
    require_once('../functions/sessions.php'); 
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

    if(ISSET($_POST['updateProfile'])){
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        $birthdate = mysqli_real_escape_string($conn, $_POST['birthdate']);
		$age = mysqli_real_escape_string($conn, $_POST['age']);
        $profileimg = $_FILES["profileimg"]["name"];
        $contactno = mysqli_real_escape_string($conn, $_POST['contactno']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $bio = mysqli_real_escape_string($conn, $_POST['bio']);
        $hobbies = mysqli_real_escape_string($conn, $_POST['hobbies']);
		$move_location = "uploads/".basename($_FILES["profileimg"]["name"]);
		
        $updateUserInfo = "UPDATE tbl_account 
                           SET gender = '$gender', birthdate = '$birthdate',age='$age',profileimg = '$profileimg', contactno = '$contactno', email = '$email', bio = '$bio', hobbies = '$hobbies'
                           WHERE userid = '$userid'";

        if(mysqli_query($conn, $updateUserInfo)){
            move_uploaded_file($_FILES["profileimg"]["tmp_name"], $move_location);
            $_SESSION['successMessage'] = "Profile successfully updated!";
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

        <section id="manage-profile" class="mb-5">
            <div class="container">
            <?php echo errorMessage(); echo successMessage(); ?>
                <div class="card card-table" style="padding-left:0px;padding-right:0px;">
			        <div class="card-header card-table-header"> 
				        <h1>Customize your profile</h1>
			        </div>
			            <div class="card-body">
                            <?php
								$retrieveUserInfo = "SELECT * FROM tbl_account WHERE userid = '$userid'";

								$resultUserInfo = mysqli_query($conn, $retrieveUserInfo);

								while($DataRows = mysqli_fetch_assoc($resultUserInfo)){
									$birthdate = $DataRows['birthdate'];
									$age = $DataRows['age'];
									$gender = $DataRows['gender'];
                                    $profileimg = $DataRows['profileimg'];
                                    $contactno = $DataRows['contactno'];
                                    $email = $DataRows['email'];
                                    $bio = $DataRows['bio'];
                                    $hobbies = $DataRows['hobbies'];
                                    $userid = $DataRows['userid'];
                                    
                                    // if($birthdate == "NONE"){
                                    //     $newBirthdate = "";
                                    // }
                                    // if($age == 0){
                                    //     $newAge = "";
                                    // }
                                    // if($contactno == "NONE"){
                                    //     $newContactno = "";
                                    // }
                                    // else{
                                    //     $newBirthdate = $birthdate;
                                    //     $newAge = $age;
                                    //     $newContactno = $contactno;
                                    // }

						    ?>
                            <form class="needs-validation" action="manage-profile-panel.php" method="POST" enctype="multipart/form-data" novalidate>
                                <div class="form-row mb-3">
                                    <div class="col">
                                        <label for="lbl_date_start">Profile Image</label>
                                        <input type ="file" name="profileimg" class="form-control form-control-lg" placeholder="e.g. 18" required>
                                        <div class="invalid-feedback">
                                            Required field!
                                        </div>
                                    </div>
                                </div>
        
                                <div class="form-row mb-3">
                                    <div class="col-md-4">
                                        <label for="lbl_date_start">Gender</label>
                                        <select class="form-control form-control-lg" name="gender">
                                            <option>Male</option>
                                            <option>Female</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Required field!
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="lbl_date_start">Age</label>
                                        <input type ="text" name="age" value="<?php echo $age; ?>" class="form-control form-control-lg" placeholder="e.g. 18" required>
                                        <div class="invalid-feedback">
                                            Required field!
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="lbl_date_start">Birthdate</label>
                                        <input type ="date" name="birthdate" value="<?php echo $birthdate; ?>" class="form-control form-control-lg" required>
                                        <div class="invalid-feedback">
                                            Required field!
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row mb-3">
                                    <div class="col-md-6">
                                        <label for="lbl_date_start">Contact No</label>
                                        <input type ="text" value="<?php echo $contactno; ?>" name="contactno" class="form-control form-control-lg" placeholder="e.g. 0912xxxxxxx" required>
                                        <div class="invalid-feedback">
                                            Required field!
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="lbl_date_start">Email</label>
                                        <input type ="email" value="<?php echo $email; ?>" name="email" class="form-control form-control-lg" placeholder="e.g. 123myemail@gmail.com" required>
                                        <div class="invalid-feedback">
                                            Required field!
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row mb-3">
                                    <div class="col">
                                        <label for="lbl_date_start">Bio</label>
                                        <textarea name="bio" class="form-control form-control-lg" rows="7" placeholder="e.g. This is my bio..." required><?php echo $bio; ?></textarea>
                                        <div class="invalid-feedback">
                                            Required field!
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row mb-3">
                                    <div class="col">
                                        <label for="lbl_date_start">Hobbies and Activities</label>
                                        <textarea name="hobbies" class="form-control form-control-lg" rows="7" placeholder="e.g. Playing basketball, watching movies" required><?php echo $hobbies; ?></textarea>
                                        <div class="invalid-feedback">
                                            Required field!
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" name="updateProfile" class="btn btn-success"><i class="far fa-check-circle"></i> Save changes</button>
                            <a  href="teacher-panel.php" type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-times-circle"></i> Back</a>
                        </div>
                    </form>
                                <?php } ?>
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
</body>
</html>