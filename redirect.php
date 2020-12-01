<?php
require('inc/connect.php');
    if(isset($_GET['id'])) {
        if(strlen($_GET['id']) == 5) {
            $url = mysqli_real_escape_string($conn, $_GET['id']);
            $urlQuery = "SELECT * FROM url_data WHERE shortenedUrl = '{$url}'";
            $result = mysqli_query($conn, $urlQuery);
            if ($result) {
                $redirectUrl =  mysqli_fetch_assoc($result);
                $countQuery = "UPDATE count_data SET clickCount=clickCount + 1 WHERE id = {$redirectUrl['id']}  ";
                if(!mysqli_query($conn, $countQuery)) {
                    echo 'Error: ' . mysqli_error($conn);
                }
      

            }
                header('Location: ' . $redirectUrl['initialUrl']);
                die();
            }
        } else  {
            header('Location: index.php');
            die();
        }
?>