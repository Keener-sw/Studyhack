<?php 
require_once(__DIR__ ."/init.php");
if(isset($_SESSION['user_id'])) {
    if(isset($_COOKIE['usercookie'])) {
        $userid = $_SESSION['user_id'];
    } else {
        header('Location: login.php');
        exit();
    }
} else {
    header('Location: login.php');
    exit();
}

// 검색 기능 처리
$search = $_GET['search'] ?? '';
$search_field = $_GET['search_field'] ?? 'post_title';
$params = [];
if(isset($_SESSION['is_admin']) && $_SESSION['user_id'] === 'admin') {
    // 관리자일 경우 모든 게시글을 조회
    $where = "1=1"; // 모든 게시글 조회
    //echo "관리자 모드: 모든 게시글을 조회합니다.";
} else {
    $where = "post_private = 0";
}
$allowed_fields = ['post_title', 'post_content', 'post_owner'];
if (!in_array($search_field, $allowed_fields)) {
    $search_field = 'post_title';
}
if ($search !== '') {
    $where .= " AND ({$search_field} LIKE :search)";
    $params[':search'] = "%{$search}%";
}

$sql = "SELECT post_num, post_title, post_owner, post_date FROM onboard WHERE $where ORDER BY post_num DESC";
$stmt = $db_connect->prepare($sql);
$stmt->execute($params);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>PublicBoard</title>
        <?php require_once __DIR__ .'/layout/navi_main.php'; ?>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <div class="middle">
            <h1>Share your Thoughts! It's Free!</h1>
            <form method="GET" action="public_board.php" style="margin-bottom: 20px; width: 55%; display: flex; flex-direction: row; align-items: center;">
                <select name="search_field" 
                    style="height: 50px; border-radius: 5px; border: none; font-size: 1em; margin-right: 8px;
                           background: rgba(0,0,0,0.6); color: #0ff; box-shadow: 0 0 10px #0ff; padding: 0 10px;">
                    <option value="post_title" <?= $search_field === 'post_title' ? 'selected' : '' ?>>제목</option>
                    <option value="post_content" <?= $search_field === 'post_content' ? 'selected' : '' ?>>내용</option>
                    <option value="post_owner" <?= $search_field === 'post_owner' ? 'selected' : '' ?>>작성자</option>
                </select>
                <input type="text" name="search" placeholder="검색할 내용을 입력하시오." value="<?= htmlspecialchars($search) ?>" style="width: 42%; height: 50px; border-radius: 5px; border: none; padding: 0 10px; font-size: 1em; margin-bottom: 0; background: rgba(0,0,0,0.6); color: #0ff; box-shadow: inset 0 0 10px #0ff;">
                <button type="submit" style="width: 50px; height: 50px; border-radius: 5px; border: none; background: #0ff; color: #222; font-weight: bold; margin-left: 8px;">검색</button>
            </form>
            <table class="neon-table">
                <thead>
                    <tr>
                        <th>글 번호</th>
                        <th>제목</th>
                        <th>작성자</th>
                        <th>날짜</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($posts): ?>
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td><?= htmlspecialchars($post['post_num']) ?></td>
                            <td>
                                <a href="board_read.php?post_num=<?= htmlspecialchars($post['post_num']) ?>" class="post-title">
                                    <?= htmlspecialchars($post['post_title']) ?>
                                </a>
                            </td>
                            <td><?= htmlspecialchars($post['post_owner']) ?></td>
                            <td><?= htmlspecialchars($post['post_date']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">게시글이 없습니다.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table><br>
            <button type="button" onclick="location.href='create_content.php'">Create Post</button>
        </div>
    </body>
</html>