<?php
require_once __DIR__ . '/init.php';

// 게시글 번호 받기
$post_num = $_GET['post_num'] ?? null;
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
$is_owner = false;
if (isset($_SESSION['user_id']) && isset($_COOKIE['usercookie'])) {
    if ($_SESSION['user_id'] == $post['post_owner']) {
        $is_owner = true;
    }
} else {
    echo "<script>alert('Please login again'); location.href='login.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?= htmlspecialchars($post['post_title']) ?></title>
        <?php require_once __DIR__ .'/layout/navi_index.php'; ?>
        <link rel="stylesheet" href="/css/style.css">
        <style>
            .read-form {
                width: 1000px;
                margin: 60px auto 0 auto;
                background: rgba(0,0,0,0.4);
                border-radius: 15px;
                box-shadow: 0 0 20px rgba(0,255,255,0.3), 0 0 40px rgba(255,0,255,0.2);
                padding: 40px 60px 30px 60px;
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            .read-group {
                width: 100%;
                margin-bottom: 30px;
                display: flex;
                flex-direction: column;
                align-items: flex-start;
            }
            .read-label {
                font-weight: bold;
                color: #fff;
                text-shadow: 0 0 5px #0ff;
                margin-bottom: 8px;
                font-size: 1.1em;
            }
            .read-title {
                width: 95%;
                height: 30px;
                font-size: 1.1em;
                padding: 10px;
                background: rgba(0,0,0,0.6);
                color: #0ff;
                border: none;
                border-radius: 5px;
                box-shadow: inset 0 0 10px #0ff;
                margin-bottom: 10px;
                line-height: 1.4;
                word-break: break-all;
            }
            .read-content {
                width: 95%;
                min-height: 200px;
                font-size: 1em;
                padding: 10px;
                background: rgba(0,0,0,0.6);
                color: #0ff;
                border: none;
                border-radius: 5px;
                box-shadow: inset 0 0 10px #0ff;
                line-height: 1.6;
                white-space: pre-line;
                word-break: break-all;
            }
            .read-actions {
                margin-top: 20px;
                width: 800px;
                display: flex;
                gap: 20px;
                justify-content: flex-end;
            }
            .read-actions form {
                display: inline;
            }
        </style>
    </head>
    <body>
        <div class="read-form">
            <div class="read-group">
                <span class="read-label">제목</span>
                <div class="read-title"><?= htmlspecialchars($post['post_title']) ?></div>
            </div>
            <div class="read-group">
                <span class="read-label">내용</span>
                <div class="read-content"><?= nl2br(htmlspecialchars($post['post_content'])) ?></div>
            </div>
            <?php if ($is_owner): ?>
                <div class="read-actions">
                    <form method="GET" action="public_board.php">
                        <button type="submit">목록</button>
                    </form>
                    <form method="GET" action="content_update.php">
                        <input type="hidden" name="post_num" value="<?= htmlspecialchars($post['post_num']) ?>">
                        <button type="submit" name="update">수정</button>
                    </form>
                    <form method="POST" action="delete_content_process.php" onsubmit="return confirm('정말 삭제하시겠습니까?');">
                        <input type="hidden" name="post_num" value="<?= htmlspecialchars($post['post_num']) ?>">
                        <button type="submit" name="delete">삭제</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </body>
</html>