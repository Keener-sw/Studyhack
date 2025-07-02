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
    $err = '';
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
                <p style="display=flex; gap:20px;">Nickname: <?php echo $user['nickname']; ?>
                <input type="text" id="nickname" placeholder="Type new nickname!">
                <button type="button" onclick=change_nick()>Change!</button>
                <p><?php echo $err ?></p>
            </p>
                <p id="email">E-Mail: <?php echo $user['email']; ?></p>
            </div>
        </form>

        <script>    
            function change_nick(){
                if(document.getElementById('nickname').value == '' || document.getElementById('nickname').value == $user['nickname']){
                    $err = '새로운 닉네임을 입력해주세요.';
                    return;
                }
                else{
                    $err = 'something wrong';
                }
                fetch('change_nick.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        'nickname': document.getElementById('nickname').value
                    })
                })
            }    
        </script>
    </body>
    </head>
</html>