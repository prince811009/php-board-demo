<?php
    $servername = "166.62.28.131";
    $username = "group2";
    $password = "dn2puorg30rtm";
    $dbname = "mtr03group2";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $conn->query("SET NAMES 'UTF8'");
    $conn->query("SET time_zone = '+08:00'");
?>