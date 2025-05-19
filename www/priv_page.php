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
        header('Location: index1.php');
        exit();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Future Burger</title>
        <link rel="stylesheet" href="/css/style.css">
    </head>
    <body>
        <form class="form-privacy">
            <div class="middle">
                <p id="id">ID :    <?php echo $user['id']; ?></p>
                <p id="name">Name:    <?php echo $user['name']; ?></p>
                <p style="display=flex; gap:10px">Nickname: <?php echo $user['nickname']; ?>
                <input type="text" id="nickname" placeholder="Type new nickname!">
                <button type="button" onclick="change_nick()">Change!</button>
            </p>
                <p id="email">E-Mail: <?php echo $user['email']; ?></p>
            </div>
        </form>
    </body>
    </head>
</html>