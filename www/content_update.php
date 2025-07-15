<?php
require_once __DIR__ . '/init.php';

// 게시글 번호 받기
$post_num = $_GET['post_num'] ?? $_POST['post_num'] ?? null;
if (!$post_num) {
    header('Location: public_board.php');
    exit();
}

// 게시글 조회
$stmt = $db_connect->prepare("SELECT * FROM onboard WHERE post_num = ?");
$stmt->execute([$post_num]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    echo "<script>alert('존재하지 않는 게시글입니다.'); location.href='public_board.php';</script>";
    exit();
}

// 로그인 및 소유자 확인
if (!isset($_SESSION['user_id']) || !isset($_COOKIE['usercookie']) || $_SESSION['user_id'] != $post['post_owner']) {
    echo "<script>alert('수정 권한이 없습니다.'); location.href='public_board.php';</script>";
    exit();
}

// 수정 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $title = $_POST['post_title'] ?? '';
    $content = $_POST['post_content'] ?? '';
    $private = $_POST['private'] ?? 0;

    $update_stmt = $db_connect->prepare("UPDATE onboard SET post_title = ?, post_content = ?, post_private = ? WHERE post_num = ? AND post_owner = ?");
    $result = $update_stmt->execute([$title, $content, $private, $post_num, $_SESSION['user_id']]);

    if ($result) {
        echo "<script>alert('수정이 완료되었습니다.'); location.href='board_read.php?post_num={$post_num}';</script>";
        exit();
    } else {
        $error = "수정에 실패했습니다. 다시 시도해 주세요.";
    }
} else {
    $title = $post['post_title'];
    $content = $post['post_content'];
    $private = $post['post_private'];
    $error = '';
}

// CSRF 토큰 생성
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>게시글 수정</title>
        <?php require_once __DIR__ . '/layout/navi_main.php'; ?>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <form method="POST" action="content_update.php" style="width: 1000px;">
            <?php if ($error): ?>
                <div style="color:red;"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <input type="hidden" name="post_num" value="<?= htmlspecialchars($post_num) ?>" />
            <input type="text" id="title" name="post_title" style="width: 800px; height:30px; margin-bottom: 20px; flex: none;" value="<?= htmlspecialchars($title) ?>"/>
            <textarea id="content" name="post_content" style="width: 800px; height:600px; margin-bottom: 20px; flex: none;"><?= htmlspecialchars($content) ?></textarea>
            <button type="submit" name="update">Update</button>
            <input type="checkbox" name="private" value="1" <?= $private ? 'checked' : '' ?> />private
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>" />
        </form>
    </body>
</html>
