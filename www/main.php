<?php 
require_once(__DIR__ ."/init.php");
if(isset($_SESSION['user_id'])) {
      if(isset($_COOKIE['usercookie'])) {
          $userid = $_SESSION['user_id'];
      } else {
            header('Location: login.php');
            exit();
      }
  }
else {
    header('Location: login.php');
    exit();
}
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Future Burger</title>
        <?php   require_once __DIR__ .'/layout/navi_main.php'; ?>
        <link rel="stylesheet" href="../css/style.css">
    </head>
        <body>
            <form>
            <p><img src="../img/pro_burger.png" alt="profile_img" width="150" height="150"></p>
            <h1>Welcome back, <?php echo htmlspecialchars($userid);?></h1>
            <button type="button" onclick="location.href='public_board.php'">Get inside</button>
            </form>
        </body>
</html>