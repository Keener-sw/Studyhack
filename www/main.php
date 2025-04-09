<?php 
session_start();
                if(isset($_SESSION['userid']))
                {
                    $userid = $_SESSION['userid'];
                }
                else
                {
                    header('Location = login.php');
                    exit();
                }
                ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>나의 페이지</title>
        <link rel="stylesheet" href="style.css">
    </head>
        <body>
            <form>
            <p><img src="../img/pro_burger.png" alt="profile_img" width="150" height="150"></p>
            <h1>Welcome back, <?php echo htmlspecialchars($userid);?></h1>
            </form>
        </body>
</html>