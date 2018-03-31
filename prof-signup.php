<?php 
    require_once('functions/connection.php');
    require_once('functions/sessions.php'); 
?>

<?php
  global $conn;

  if(ISSET($_POST['submit'])){
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $usernameExistingQuery = "SELECT * FROM tbl_account WHERE username = '$username'";

    $result = mysqli_query($conn, $usernameExistingQuery);

    $resultCount = mysqli_num_rows($result);

    if($resultCount > 0){
      $_SESSION['errorMessage'] = "Username already exists!";
    }
    else{
      $insertTeacherAccountQuery = "INSERT INTO `tbl_account`(`fname`, `lname`, `username`, `password`, `usertype`, `profileimg`, `gender`, `birthdate`, `age`, `contactno`, `email`, `bio`, `hobbies`, `enrollment_id`) VALUES ('$fname', '$lname', '$username', '$password', 'teacher', 'user.png', 'NONE', 'NONE', '0', 'NONE', 'NONE', 'NONE', 'NONE', '0')";

      if(mysqli_query($conn, $insertTeacherAccountQuery)){
        $_SESSION['successMessage'] = "Account successfully created!";
      }
      else{
        $_SESSION['errorMessage'] = mysqli_error($conn);
      }
    }
  }
?>

<!DOCTYPE html>
<html>

<head>
    <title>NNHS</title>

    <meta name="viewport" content="width=device-width" intial-scale="1.0">

    <link rel="icon" href="img/nnhs-lms-logo.png">
    
    <link rel="stylesheet" href="css/login.css" />
    <link rel="stylesheet" type="text/css" href="semantic/dist/semantic.min.css">
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="fonts/webfonts/fontawesome-all.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">

    <script
      src="https://code.jquery.com/jquery-3.1.1.min.js"
      integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
      crossorigin="anonymous"></script>
    <script src="semantic/dist/semantic.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="bootstrap/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body id="login-body">
    <div class="container">
      <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 text-center">
        <?php echo errorMessage(); echo successMessage(); ?>
            <div class="card signup-teacher-panel text-center">
              <a href = "login.php" class="back-link"><p align="right">Back &nbsp&nbsp </p></a><div class="card-header"><img src="img/teacher.png" class="img-fluid" alt="teacher" width="100px"></div>
                <div class="card-body px-2">
                  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" novalidate class="needs-validation">
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