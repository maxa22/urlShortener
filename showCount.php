<?php
    $errorMessage = '';
    $clickCount = 0;
    $url = '';
    $baseUrl = $_SERVER['HTTP_HOST'] . str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
    if(isset($_GET['submit'])) {
        $url = trim($_GET['shortUrl']);
        if(!empty($url)) {
            require('inc/connect.php');
             $url = mysqli_real_escape_string($conn, $url);
             // getting the last 5 characters of the url
             if(strlen($url) > 5) {
                 $shortUrlArray = explode('/', $url);
                 $shortUrl = $shortUrlArray[count($shortUrlArray) - 1];
             }

             $query = "SELECT * FROM url_data WHERE shortenedUrl = '{$shortUrl}' ";
             $result = mysqli_query($conn, $query);
             if($result) {
                $data = mysqli_fetch_assoc($result);
                $queryCount = "SELECT * FROM count_data WHERE id = '{$data['id']}'";
                $queryCountResult = mysqli_query($conn, $queryCount);
                if($queryCountResult) {
                    $queryCountData = mysqli_fetch_assoc($queryCountResult);
                    $clickCount = $queryCountData['clickCount'];
                } else {
                    $errorMessage = 'Error: ' . mysqli_error($conn);
                }
             } else {
                 $errorMessage = 'Error: ' . mysqli_error($conn);
                 $count = 0;
             }
        } else {
            $errorMessage = 'Field can\'t be empty';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Url click count</title>
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Url shortener</a></li>
            <li><a href="showCount.php">Url click count</a></li>
        </ul>
    </nav>
    <div class="main">
    <div class="count-container">
        <h1>URL clink count</h1>
        <span id="number-of-clicks"><?php echo $clickCount; ?></span>
    </div>

        <div class="wrapper">
            <form action="" method="GET">
                <div class="input-container">
                    <input type="text" name="shortUrl" placeholder="<?php echo $baseUrl . 'abcde'; ?>" value="<?php echo $url ? $url : ''; ?>">
                    <span> <?php echo $errorMessage; ?> </span>
                </div>
                <button name="submit">Track clicks</button>
            </form>
        </div>
    </div>
</body>
</html>