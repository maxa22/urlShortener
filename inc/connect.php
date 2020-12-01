<?php

    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'url_db';

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    
    if(!$conn) {
        echo 'Error: ' . mysqli_error($conn);
    }

?>
    