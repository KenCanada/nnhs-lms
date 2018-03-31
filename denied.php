<?php 
    require_once('functions/connection.php');
    require_once('functions/sessions.php'); 
?>

<?php

    global $conn;

    if(isset($_SESSION['id'])){
        $userid = $_SESSION['id'];
    }
    else{
        echo "<script>window.location.href='login.php';</script>";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>NNHS</title>

        <meta name="viewport" content="width=device-width" intial-scale="1.0">

        <link rel="icon" href="img/nnhs-lms-logo.png">

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
    <body>
        <section id="access-denied-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 d-none d-lg-block d-xl-block">
                    </div>

                    <div class="col-lg-6">
                        <div class="card access-d-panel text-center">
                            <div class="card-header"></div>
                            
                            <div class="card-body px-2 pb-5">
                                <h1 class="access-d-heading"><i class="fas fa-exclamation-triangle"></i> ACCESS DENIED</h1>
                            </div>

                            <div class="card-footer">
                                <h1 class="access-d-desc">
                                    You do not have permission to access this resource
                                </h1>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 d-none d-lg-block d-xl-block">
                    </div>
                </div>
            </div>
        </section>
        <script src='js/jquery-3.3.1.min.js'></script>
    </body>
</html>