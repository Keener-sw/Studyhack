<?php
    require_once __DIR__ . '/init.php';
    if($_GET['success'] ?? false) {
        echo "<script>alert('게시글이 성공적으로 저장되었습니다.'); location.replace('public_board.php');</script>";
    } elseif($_GET['error'] ?? false) {
        echo $_SESSION['form_error'];
        $title = $_SESSION['form_data']['post_title'] ?? '';
        $content = $_SESSION['form_data']['post_content'] ?? '';
        $private = $_SESSION['form_data']['private'] ?? 0;
        $error = $_SESSION['form_error'] ?? '';
        unset($_SESSION['form_data'], $_SESSION['form_error']);
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
        <title>Create Content</title>
        <?php require_once __DIR__ . '/layout/navi_main.php'; ?>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <form method="POST" action="create_content_process.php" style="width: 1000px;">
            <input type="text" id="title" name="post_title"style="width: 800px; height:30px; margin-bottom: 20px; flex: none;"/>
            <textarea id="content" name="post_content" style="width: 800px; height:600px; margin-bottom: 20px; flex: none;"></textarea>
            <button type="submit">Create</button>
            <input type="checkbox" name="private" value="1" />private
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>" />
        </form>
    </body>
</html>