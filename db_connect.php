<?php
    $servername = "localhost";
    $username = "root";
    $password = "Pvk@1710";
    $dbname = "Energain";
    // $port = "3307";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    // else{
    //     echo "Connected successfully";
    // }
    
?>