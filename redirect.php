<?php
    if(isset($_GET['id'])) {
        if(strlen($_GET['id']) == 5) {
            require('inc/connect.php');
            $url = mysqli_real_escape_string($conn, $_GET['id']);
            $urlQuery = "SELECT * FROM url_data WHERE urlCode = '{$url}'";
            $result = mysqli_query($conn, $urlQuery);
            if (mysqli_num_rows($result) > 0) {
                $redirectUrl =  mysqli_fetch_assoc($result);
                $countQuery = "UPDATE count_data SET clickCount=clickCount + 1 WHERE urlCode = '{$redirectUrl['urlCode']}' ";
                if(!mysqli_query($conn, $countQuery)) {
                    header('Location: index.php');
                    die();
                }
            } else {
                header('Location: index.php');
            }
            header('Location: ' . $redirectUrl['initialUrl']);
            die();
        }
    } else  {
        header('Location: index.php');
        die();
    }
?>