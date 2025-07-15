<?php
    require_once __DIR__ . '/init.php';
    // 세션 시작
    if(isset($_SESSION['user_id']) && isset($_COOKIE['usercookie'])) {
        $userid = $_SESSION['user_id'];
        $stmt = $db_connect->prepare('Select * from priv_info WHERE id = ?');
        $stmt->execute([$userid]);
        $user = $stmt->fetch();
    }
    else{
        header('Location: index.php');
        exit();
    }
    $err = '';
?>

<!DOCTYPE html>
<html>
    <head>
s        <title>Future Burger</title>
        <link rel="stylesheet" href="/css/style.css">
    </head>
    <body>
        <?php ?>
        <form class="form-privacy" method="POST" action="update_privInfo.php">
            <div class="middle">
                <p name="verify">Please type your password again : <input type="password" id="verify" placeholder=""/></p>
                <button type="submit">Verify</button>
            </div>
        </form>

        <script>       
        </script>
    </body>
    </head>
</html>