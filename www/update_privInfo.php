<?php
    require_once __DIR__ . '/init.php';
    // 세션 시작
    if(isset($_SESSION['user_id']) && isset($_COOKIE['usercookie'])) {
        $userid = $_SESSION['user_id'];
        $stmt = $db_connect->prepare('SELECT * FROM priv_info WHERE id = ?');
        $stmt->execute([$userid]);
        $user = $stmt->fetch();
    }
    else{
        header('Location: index.php');
        exit();
    }
    $err = '';

    // POST 처리
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nickname = trim($_POST['nickname'] ?? '');
        $password = $_POST['password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_new_password = $_POST['confirm_new_password'] ?? '';
        $nickname_checked = $_POST['nickname_checked'] ?? '';

        // 비밀번호 확인
        $stmt = $db_connect->prepare('SELECT pwd FROM priv_info WHERE id = ?');
        $stmt->execute([$userid]);
        $row = $stmt->fetch();
        $pw_correct = password_verify($password, $row['pwd']);

        if ($nickname === '' && $new_password === '' && $confirm_new_password === '') {
            $err = "변경할 정보가 없습니다.";
        } else if (!$pw_correct) {
            $err = "현재 비밀번호가 올바르지 않습니다.";
        } else {
            // 닉네임만 변경
            if ($nickname !== '' && $new_password === '' && $confirm_new_password === '') {
                if ($nickname_checked !== '1') {
                    $err = "닉네임 중복확인을 해주세요.";
                } else {
                    $stmt = $db_connect->prepare('UPDATE priv_info SET nickname = ? WHERE id = ?');
                    $stmt->execute([$nickname, $userid]);
                    $user['nickname'] = $nickname;
                    $err = "닉네임이 변경되었습니다.";
                }
            }
            // 비밀번호 변경 포함
            else if ($new_password !== '' || $confirm_new_password !== '' || $nickname !== '') {
                if ($new_password !== $confirm_new_password) {
                    $err = "새 비밀번호가 일치하지 않습니다.";
                } else if ($new_password === '') {
                    if ($nickname !== '') {
                        if ($nickname_checked !== '1') {
                            $err = "닉네임 중복확인을 해주세요.";
                        } else {
                            $stmt = $db_connect->prepare('UPDATE priv_info SET nickname = ? WHERE id = ?');
                            $stmt->execute([$nickname, $userid]);
                            $user['nickname'] = $nickname;
                            $err = "닉네임이 변경되었습니다.";
                        }
                    } else {
                        $err = "새 비밀번호를 입력하세요.";
                    }
                } else {
                    $hashed = password_hash($new_password, PASSWORD_DEFAULT);
                    $stmt = $db_connect->prepare('UPDATE priv_info SET pwd = ? WHERE id = ?');
                    $stmt->execute([$hashed, $userid]);
                    $err = "비밀번호가 변경되었습니다.";
                    // 닉네임도 같이 입력된 경우
                    if ($nickname !== '') {
                        if ($nickname_checked !== '1') {
                            $err = "닉네임 중복확인을 해주세요.";
                        } else {
                            $stmt = $db_connect->prepare('UPDATE priv_info SET nickname = ? WHERE id = ?');
                            $stmt->execute([$nickname, $userid]);
                            $user['nickname'] = $nickname;
                            $err .= " 닉네임도 변경되었습니다.";
                        }
                    }
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Future Burger</title>
        <link rel="stylesheet" href="/css/style.css">
        <?php   require_once __DIR__ .'/layout/navi_main.php'; ?>
        <script src="/js/privinfo.js"></script>
    </head>
    <body>
        <form class="form-privacy" method="POST" autocomplete="off">
            <div class="middle">
                <p id="id">ID : <?php echo htmlspecialchars($user['id']); ?></p>
                <p id="name">Name: <?php echo htmlspecialchars($user['name']); ?></p>
                <p style="display:flex; gap:20px; margin:20px;">
                    Nickname: <span id="current-nickname"><?php echo htmlspecialchars($user['nickname']); ?></span>
                    <input type="text" id="nickname" name="nickname" placeholder="Type new nickname!"/>
                    <button type="button" id="check-nickname">중복확인</button>
                </p>
                <input type="hidden" name="nickname_checked" id="nickname_checked" value="0">
                <p id="nickname-msg" style="color:#0ff;"></p>
                <p style="color:red;"><?php echo htmlspecialchars($err); ?></p>
                <p id="password">Current Password: <input type="password" name="password" id="password-input" placeholder="Type your current password!"/></p>
                <p id="password">New Password: <input type="password" name="new_password" id="new-password" placeholder="Type your new password!"/></p>
                <p id="password">Confirm New Password: <input type="password" name="confirm_new_password" id="confirm-new-password" placeholder="Confirm your new password!"/></p>
                <button type="submit" id="update-btn">Update</button>
            </div>
        </form>
    </body>
</html>