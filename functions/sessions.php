<?php
    session_start();

    function errorMessage(){
        if(isset($_SESSION['errorMessage'])){
            $output = "<div class=\"alert alert-danger alert-dismissable fade show\">";
            $output.=htmlentities($_SESSION['errorMessage']);
            $output.="<button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span>&times;</span></button></div>";
            $_SESSION['errorMessage'] = null;
            return $output;
        }
    }

    function successMessage(){
        if(isset($_SESSION['successMessage'])){
            $output = "<div class=\"alert alert-success alert-dismissable fade show\">";
            $output.=htmlentities($_SESSION['successMessage']);
            $output.="<button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span>&times;</span></button></div>";
            $_SESSION['successMessage'] = null;
            return $output;
        }
    }
?>
