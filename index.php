<?php
    $errorMessage = '';
    $shortenedUrl = '';
    $url = '';
    if(isset($_POST['submit'])) {
        if(filter_var($_POST['url'], FILTER_VALIDATE_URL)) {
            require('inc/connect.php');
            $url = mysqli_real_escape_string($conn, $_POST['url']);
            $characters = 'abcdefghjklmnoqprstuvwxyz';
            
            // perform a loop if the random 5 string character exist in the db
            do {
                $urlCode = $characters[mt_rand(0, 24)] . mt_rand(0,9) . $characters[mt_rand(0, 24)] . mt_rand(0,9) . $characters[mt_rand(0, 24)];
                $urlCodeQuery = "SELECT * FROM url_data WHERE shortenedUrl = '{$urlCode}'";
                $urlCodeResult = mysqli_query($conn, $urlCodeQuery);
            } while (mysqli_num_rows($urlCodeResult) > 0);

            $urlQuery = "INSERT INTO url_data (initialUrl, shortenedUrl) VALUES ('{$url}', '{$urlCode}')";
            if( mysqli_query($conn, $urlQuery)) {

                // getting the shortened url and formating it
                $shortenedUrl = $_SERVER['HTTP_HOST'] . str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']) . $urlCode;
                
                header('Location: urlcopy.php?code=' . $urlCode);
                die();

            } else {
                $errorMessage = 'Error: ' . mysqli_error($conn);
            }
        } else {
            $errorMessage = 'Please add a valid url';
        }
    }
?>  
<!DOCTYPE html>
    <?php require('inc/header.php'); ?>
    <div class="main">
        <h1>URL SHORTENER</h1>
        <div class="wrapper">
            <form action="" method="POST">
                <div class="input-container">
                    <input type="text" name="url" placeholder="Shorten the link here..." value="<?php echo $shortenedUrl ? $url : ''; ?>">
                    <span> <?php echo $errorMessage; ?> </span>
                </div>
                <button name="submit">Shorten URL</button>
            </form>
        </div>
</body>
</html>