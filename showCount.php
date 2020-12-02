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
             if(mysqli_num_rows($result) > 0) {
                $data = mysqli_fetch_assoc($result);
                $queryCount = "SELECT * FROM count_data WHERE id = '{$data['id']}'";
                $queryCountResult = mysqli_query($conn, $queryCount);
                if(mysqli_num_rows($queryCountResult) > 0) {
                    $queryCountData = mysqli_fetch_assoc($queryCountResult);
                    $clickCount = $queryCountData['clickCount'];
                } else {
                    $errorMessage = 'Error: ' . mysqli_error($conn);
                }
             } else {
                 $errorMessage = 'Error: Incorrect url';
                 $count = 0;
             }
        } else {
            $errorMessage = 'Field can\'t be empty';
        }
    }

?>

<!DOCTYPE html>
    <?php require('inc/header.php'); ?>
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