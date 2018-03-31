<?php
    function dateTime(){
        date_default_timezone_set("Asia/Manila");
        $date = new DateTime();
        return $date->format('Y/n/j g:i a') ;
    }

    function dateTimeFormat(){
        date_default_timezone_set("Asia/Manila");
        $date = new DateTime();
        return $date->format('F d, Y h:i:s a') ;
    }

    function datee(){
        date_default_timezone_set("Asia/Manila");
        $date = new DateTime();
        return $date->format('Ynj') ;
    }

    function Timee(){
        date_default_timezone_set("Asia/Manila");
        $date = new DateTime();
        return $date->format('gias') ;
    }
?>