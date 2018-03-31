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

<body id="login-body" class ="bg">
    <div class="container">
      <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 text-center">
            <div class="card login-panel text-center">
              <a href = "login.html"><p align="right">Back &nbsp&nbsp </p></a><div class="card-header"><img src="img/parent.png" class="img-fluid" alt="parent" width="150px"></div>
                <div class="card-body px-2">
                  <form>
                    <div class="form-group">
                        <input type ="text" name = "codes"
                          class = "form-control form-control-lg" placeholder="Access Code" <small>Enter the access code given by your child's teacher.</small>
                    </div>
					
					<div class="form-group">
                        <input type ="text" name = "fname"
                          class = "form-control form-control-lg" placeholder="First Name" style="width: 90%;margin:0 auto;">
                    </div>
					<div class="form-group">
                        <input type ="text" name = "lname"
                          class = "form-control form-control-lg" placeholder="Last Name" style="width: 90%;margin:0 auto;">
                    </div>
					 <div class="form-group">
                        <input type ="email" name = "email"
                          class = "form-control form-control-lg" placeholder="Email Address" style="width: 90%;margin:0 auto;">
                    </div>
                    <div class="form-group">
                        <input type ="password" name = "password"
                          class = "form-control form-control-lg" placeholder="Password" style="width: 90%;margin:0 auto;">
                    </div>
					<div class="form-group">
                        <input type ="password" name = "conpassword"
                          class = "form-control form-control-lg" placeholder="Confirm Password" style="width: 90%;margin:0 auto;">
                    </div>
                  <input type ="submit" value ="Register" onclick="myFunction()" class="btn btn-outline-secondary btn-block btn-submit" style="width: 85%;margin:0 auto;">
                  </form>
				  <script>
					function myFunction() {
					alert("Verification message has sent to your email. Please CONFIRM to proceed. Thank you for signing up!");
											}
				  </script>
                </div>
                <div class="card-footer bg-transparent"><br>
                 
                </div> 
              
              
            </div>
        </div>
        <div class="col-lg-3"></div>
      </div>
    </div>
</body>

</html>