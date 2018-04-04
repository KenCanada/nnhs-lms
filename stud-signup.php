<?php 
    require_once('functions/connection.php');
    require_once('functions/sessions.php'); 
?>

<?php
  global $conn;

  if(ISSET($_POST['submit'])){
    $accesscode = mysqli_real_escape_string($conn, $_POST['accesscode']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $datestamp = dateTimeFormat();

    $accesscodeExistingQuery = "SELECT * FROM tbl_subject WHERE accesscode = '$accesscode' AND archivestatus = '0'";
    
    $resultAccesscode = mysqli_query($conn, $accesscodeExistingQuery);

    $resultCountAccesscode = mysqli_num_rows($resultAccesscode);

    if($resultCountAccesscode == 0){
      $_SESSION['errorMessage'] = "Access code doesn't exists!";
    }
    else{
      $usernameExistingQuery = "SELECT * FROM tbl_account WHERE username = '$username'";

      $resultUsername = mysqli_query($conn, $usernameExistingQuery);

      $resultCountUsername = mysqli_num_rows($resultUsername);

      if($resultCountUsername > 0){
        $_SESSION['errorMessage'] = "Username already exists!";
      }
      else{
        $countStudentQuery = "SELECT COUNT(*) AS 'studentCount' FROM tbl_account WHERE usertype = 'student'";

        $result = mysqli_query($conn, $countStudentQuery);

          while($DataRows = mysqli_fetch_assoc($result)){
            $studentCount = $DataRows['studentCount'];  
          }

            if($studentCount == 0){
              $enrollmentID = 1;
            }
            else{
              $enrollmentID = $studentCount + 1;
            }

        $insertStudentAccountQuery = "INSERT INTO `tbl_account`(`fname`, `lname`, `username`, `password`, `usertype`, `profileimg`, `gender`, `birthdate`, `age`, `contactno`, `email`, `bio`, `hobbies`, `enrollment_id`) VALUES ('$fname', '$lname', '$username', '$password', 'student', 'user.png', 'NONE', 'NONE', '0', 'NONE', 'NONE', 'NONE', 'NONE', '$enrollmentID')";
        $insertToEnrollment = "INSERT INTO `tbl_enrollment`(`enrollment_id_student`, `accesscode`, `datestamp`, `datetimestamp`) VALUES ('$enrollmentID', '$accesscode', '$datestamp', NOW())";

        if(mysqli_query($conn, $insertStudentAccountQuery) && mysqli_query($conn, $insertToEnrollment)){
          $_SESSION['successMessage'] = "Account successfully created!";
        }
        else{
          $_SESSION['errorMessage'] = mysqli_error($conn);
        }
      }
    }
  }
?>

<!DOCTYPE html>
<html>

  <head>
    <title>| NNHS</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="favicon.png">

    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link href="fonts/webfonts/fontawesome-all.css" rel="stylesheet">
    <link rel="stylesheet" href="gijgo/css/gijgo.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="jquery/dist/jquery.min.js"></script>
    <script src="jquery/dist/jquery.slim.min.js"></script>
    <script src="popper.js/dist/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="gijgo/js/gijgo.min.js"></script>
  </head>

<body id="login-body">
    <div class="container">
      <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 text-center">
        <?php echo errorMessage(); echo successMessage(); ?>
            <div class="card signup-teacher-panel text-center">
              <a href = "login.php" class="back-link"><p align="right">Back &nbsp&nbsp </p></a><div class="card-header"><img src="img/student.png" class="img-fluid" alt="teacher" width="100px"></div>
                <div class="card-body px-2">
                  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" novalidate class="needs-validation">
                    <div class="form-group">
                        <input type ="text" name = "accesscode" class = "form-control form-control-lg" placeholder="Access Code" style="width: 90%;margin:0 auto;" required>
                          <div class="invalid-feedback">
                            Access code is required!
                          </div>
                    </div>

                    <div class="form-group">
                        <input type ="text" name = "fname" class = "form-control form-control-lg" placeholder="First Name" style="width: 90%;margin:0 auto;" required>
                          <div class="invalid-feedback">
                            First name is required!
                          </div>
                    </div>
                    
                    <div class="form-group">
                        <input type ="text" name = "lname" class = "form-control form-control-lg" placeholder="Last Name" style="width: 90%;margin:0 auto;" required>
                          <div class="invalid-feedback">
                            Last name is required!
                          </div>
                    </div>
                    
                    <div class="form-group">
                        <input type ="text" name = "username" class = "form-control form-control-lg" placeholder="Username" style="width: 90%;margin:0 auto;" required>
                          <div class="invalid-feedback">
                            Username is required!
                          </div>
                    </div>
                    
                    <div class="form-group">
                        <input type ="password" name = "password" class = "form-control form-control-lg" placeholder="Password" style="width: 90%;margin:0 auto;" required>
                          <div class="invalid-feedback">
                            Password is required!
                          </div>
                    </div>

					          <input type ="submit" name="submit" value ="Register" class="btn btn-block btn-submit" style="width: 85%;margin:0 auto;">
                  </form>
				        </div>
                <div class="card-footer bg-transparent"><br>
                </div> 
              
              		
            </div>
        </div>
        <div class="col-lg-3"></div>
      </div>
    </div>

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