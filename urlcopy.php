<?php
    $errorMessage = '';
    $shortenedUrl = '';
    if(isset($_POST['submit'])) {
        if(filter_var($_POST['url'], FILTER_VALIDATE_URL)) {
            require('inc/connect.php');
            $url = mysqli_real_escape_string($conn, $_POST['url']);
            $characters = 'abcdefghjklmnoqprstuvwxyz';
            
            // perform a loop if the random 5 string character exist in the db
            do {
                $urlCode = $characters[mt_rand(0, 24)] . mt_rand(0,9) . $characters[mt_rand(0, 24)] . mt_rand(0,9) . $characters[mt_rand(0, 24)];
                $urlCodeQuery = "SELECT * FROM url_data WHERE urlCode = '{$urlCode}'";
                $urlCodeResult = mysqli_query($conn, $urlCodeQuery);
            } while (mysqli_num_rows($urlCodeResult) > 0);

            $urlQuery = "INSERT INTO url_data (initialUrl, urlCode) VALUES ('{$url}', '{$urlCode}')";
            if( mysqli_query($conn, $urlQuery)) {

                // getting the shortened url and formating it
                $shortenedUrl = $_SERVER['HTTP_HOST'] . str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']) . $urlCode;
                
                
            // now creating a new row in count_data db
                $countSearchQuery = "SELECT * FROM count_data WHERE urlCode = '{$urlCode}'";            
                if(mysqli_num_rows(mysqli_query($conn, $countSearchQuery)) < 1) {
                    $countQuery = "INSERT INTO count_data (clickCount, urlCode) VALUES (0, '{$urlCode}') ";
                    
                    if(!mysqli_query($conn, $countQuery)) {
                        echo 'Error: ' . mysqli_error($conn);
                    } 
                }
            } else {
                $errorMessage = 'Error: ' . mysqli_error($conn);
                header('Location: index.php?message=' . $errorMessage);
                die();
            }
                

        } else {
                $errorMessage = 'Please provide a valid url.';
                header('Location: index.php?message=' . $errorMessage);
                die();
        }
    } else {
            header('Location: index.php');
            die();
    }
?>

<!DOCTYPE html>
    <?php require('inc/header.php'); ?>
    <div class="main">
        <h1>URL SHORTENER</h1>
        <div class="wrapper copy-to-clipboard active">
            <form action="">
                <div class="input-container">
                    <input type="text" value="<?php echo $shortenedUrl ? $shortenedUrl : ''; ?>" class="copy-text">
                </div>
                <button id="copy">Copy</button>
            </form>
        </div> 
    </div>
<script src="js/script.js"></script>
</body>
</html>