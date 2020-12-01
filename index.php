<?php
    $errorMessage = '';
    $copyUrl = '';
    $url = '';
    if(isset($_POST['submit'])) {
        if(filter_var($_POST['url'], FILTER_VALIDATE_URL)) {
            require('inc/connect.php');
            $url = mysqli_real_escape_string($conn, $_POST['url']);
            $characters = 'abcdefghjklmnoqprstuvwxyz';

            // perform a loop if the random 5 string character exists in the database
            do {
                $shortenedUrl = $characters[mt_rand(0, 24)] . mt_rand(0,9) . $characters[mt_rand(0, 24)] . mt_rand(0,9) . $characters[mt_rand(0, 24)];
                $querySelect = "SELECT * FROM url_data WHERE shortenedUrl = '{$shortenedUrl}'";
                $resultSelectQuery = mysqli_query($conn, $querySelect);
            } while (mysqli_num_rows($resultSelectQuery) > 0);
            
            $query = "INSERT INTO url_data (initialUrl, shortenedUrl) VALUE ('{$url}', '{$shortenedUrl}')";
            if(!mysqli_query($conn, $query)) {
                $errorMessage = 'Error: ' . mysqli_error($conn);
            } else {
                // getting the shortened url and formating it
                $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] = 'on') ? 'https' : 'http';
                $baseUrl .= '://' . $_SERVER['HTTP_HOST'];
                $copyUrl .= $baseUrl . str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']) . $shortenedUrl;
            }
        } else {
            $errorMessage = 'Please add a valid url';
        } 
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Url shortener</title>
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Url shortener</a></li>
            <li><a href="showCount.php">Url click count</a></li>
        </ul>
    </nav>
    <div class="main">
        <h1>URL SHORTENER</h1>
        <div class="wrapper">
            <form action="" method="POST">
                <div class="input-container">
                    <input type="text" name="url" placeholder="Shorten the link here..." value="<?php echo $copyUrl ? $url : ''; ?>">
                    <span> <?php echo $errorMessage; ?> </span>
                </div>
                <button name="submit">Shorten URL</button>
            </form>
        </div>

        <div class="wrapper copy-to-clipboard <?php echo $copyUrl ? 'active' : ''; ?> ">
            <form action="">
                <div class="input-container">
                    <input type="text" value="<?php echo $copyUrl; ?>" class="copy-text">
                </div>
                <button id="copy">Copy</button>
            </form>
        </div> 
    </div>
<script src="js/script.js"></script>
</body>
</html>