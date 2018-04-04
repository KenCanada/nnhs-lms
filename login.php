<?php 
    require_once('functions/connection.php');
    require_once('functions/sessions.php'); 
?>

<?php
  global $conn;

  if(ISSET($_POST['submit'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $usernameExistingQuery = "SELECT * FROM tbl_account WHERE username = '$username'";

    $result = mysqli_query($conn, $usernameExistingQuery);

    $resultCount = mysqli_num_rows($result);

    if($resultCount > 0){
        while($DataRows = mysqli_fetch_assoc($result)){
          $userid = $DataRows['userid'];
          $dbPassword = $DataRows['password'];
          $usertype = $DataRows['usertype'];
          $profileimg = $DataRows['profileimg'];
          $enrollmentid = $DataRows['enrollment_id'];
      }

          if($dbPassword == $password){

              $_SESSION['id'] = $userid;
              $_SESSION['usertype'] = $usertype;
              $_SESSION['profileimg'] = $profileimg;
              $_SESSION['enrollment_id'] = $enrollmentid;

              if($usertype == "teacher"){
                echo "<script>window.location.href='teacher/teacher-panel.php';</script>";
              }
              else if($usertype == "student"){
                echo "<script>window.location.href='student/student-panel.php';</script>";
              }
              else{
                echo "<script>window.location.href='parent/parent-panel.php';</script>";
              }
          }
          else{
              $_SESSION['errorMessage'] = "Incorrect password!";
          }
    }
    else{
        $_SESSION['errorMessage'] = "Account doesn't exists!";
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
            <div class="card login-panel text-center">
              <div class="card-header"><img src="img/login.png" class="nnhs-logo"></div>
                <div class="card-body px-2">
                  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" novalidate class="needs-validation">
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

                    <input type ="submit" name="submit" value ="Log in" class="btn btn-outline-secondary btn-block btn-submit" style="width: 85%;margin:0 auto;">
                    
                  </form>
                </div>
                <div class="card-footer bg-transparent">New to NNHS-LMS? 
                  <a data-toggle="modal" href="#myModal">Sign up.</a>
                </div> 
              
              <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Sign up as :</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <a href="prof-signup.php"><img src="img/teacher.png" class="img-fluid" alt="teacher" width="120px"></a>&nbsp&nbsp&nbsp&nbsp
					            <a href="parent-signup.php"><img src="img/parent.png" class="img-fluid" alt="parent" width="120px"></a>&nbsp&nbsp&nbsp&nbsp
					            <a href="stud-signup.php"><img src="img/student.png" class="img-fluid" alt="student" width="120px"></a><br>
					  <p><pre><b><font size="3px">  Teacher<b>      <b>Parent</b>      <b>Student  </font></b></pre></p>
					  
                    </div>
                    <div class="modal-footer">
                      
                      <button type="button" class="btn btn-secondary btn-warning" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
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