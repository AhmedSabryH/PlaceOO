<?php
    $con = new mysqli("localhost", "root", "", "placeoo");
    if ($con->connect_errno) {
        die("connection error");
    }
?>
