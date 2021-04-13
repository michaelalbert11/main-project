<?php


$user = "root";


$con = new mysqli("localhost", $user,  "studentdb");
if($con -> connect_error) {
    die("NO..");
}


?>