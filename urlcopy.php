<?php
    $shortenedUrl = '';
    if(isset($_GET['code'])) {
        require('inc/connect.php');
        $code = mysqli_real_escape_string($conn, $_GET['code']);

        // now creating a new row in count_data db
        $urlQuery = "SELECT * FROM url_data WHERE shortenedUrl = '{$code}'"; 
        if(mysqli_num_rows(mysqli_query($conn, $urlQuery)) > 0) {
            $urlData = mysqli_fetch_assoc(mysqli_query($conn, $urlQuery));
            $shortenedUrl = $_SERVER['HTTP_HOST'] . str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']) . $urlData['shortenedUrl'];
            $countSearchQuery = "SELECT * FROM count_data WHERE id = '{$urlData['id']}'";            
            if(mysqli_num_rows(mysqli_query($conn, $countSearchQuery)) < 1) {
                $countQuery = "INSERT INTO count_data (clickCount, id) VALUES (0, '{$urlData['id']}') ";
                
                if(!mysqli_query($conn, $countQuery)) {
                    echo 'Error: ' . mysqli_error($conn);
                } 
            }
        } else {
            $shortenedUrl = NULL;
        }
    }
?>

<!DOCTYPE html>
    <?php require('inc/header.php'); ?>
    <div class="main">
        <h1>URL SHORTENER</h1>
        <div class="wrapper copy-to-clipboard active">
            <form action="">
                <div class="input-container">
                    <input type="text" value="<?php echo $shortenedUrl? $shortenedUrl : ''; ?>" class="copy-text">
                </div>
                <button id="copy">Copy</button>
            </form>
        </div> 
    </div>
<script src="js/script.js"></script>
</body>
</html>