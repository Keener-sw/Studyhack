<?php
  require_once __DIR__ . '/init.php';
  // 세션 시작
  if(isset($_SESSION['user_id'])) {
      if(isset($_COOKIE['usercookie'])) {
          header('Location: main.php');
          exit();
      } else {
          session_destroy();
          setcookie('usercookie', '', time() - 3600, '/');
      }
  }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Future Burger</title>
        <?php   require_once __DIR__ .'/layout/navi_index.php'; ?>
        <link rel="stylesheet" href="/css/style.css">
    </head>
    <body>
        <div class="middle">
            <div class="title">Welcome to the Future Burger</div>
                <img src="/img/mainburger.png" alt="로고" class="main-logo">
        </div>
    </body>
</html>
