<?php
require('inc/connect.php');
    if(isset($_GET['id'])) {
        if(strlen($_GET['id']) == 5) {
            $url = mysqli_real_escape_string($conn, $_GET['id']);
            $query = "SELECT * FROM url_data WHERE shortenedUrl = '{$url}'";
            $result = mysqli_query($conn, $query);
            if ($result) {
                $redirect =  mysqli_fetch_assoc($result);
                $countSearchQuery = "SELECT * FROM count_data WHERE id = '{$redirect['id']}'";
                $countSearchResult = mysqli_query($conn, $countSearchQuery);
                if(mysqli_num_rows($countSearchResult)) {
                    $countQuery = "UPDATE count_data SET clickCount=clickCount + 1 WHERE id = {$redirect['id']}  ";
                    if(!mysqli_query($conn, $countQuery)) {
                        echo 'Error: ' . mysqli_error($conn);
                    }
                } else {
                    $countQuery = "INSERT INTO count_data ( clickCount, id) VALUES (clickCount + 1, '{$redirect['id']}') ";
                    if(!mysqli_query($conn, $countQuery)) {
                        echo 'Error: ' . mysqli_error($con);
                    }

                }
                header('Location: ' . $redirect['initialUrl']);
                die();
            }
        } else  {
            header('Location: index.php');
            die();
        }
    }
?>