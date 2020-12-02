<?php 
    $errorMessage = '';
    if(isset($_GET['message'])) {
        $errorMessage = $_GET['message'];
    }
?>
<!DOCTYPE html>
    <?php require('inc/header.php'); ?>
    <div class="main">
        <h1>URL SHORTENER</h1>
        <div class="wrapper">
            <form action="urlcopy.php" method="POST">
                <div class="input-container">
                    <input type="text" name="url" placeholder="Shorten the link here...">
                    <span><?php echo $errorMessage ?></span>
                </div>
                <button name="submit">Shorten URL</button>
            </form>
        </div>
</body>
</html>