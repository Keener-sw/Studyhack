<?php
require_once __DIR__ . '/init.php' ;


// POST로 전달된 파라미터
$title      = $_POST['post_title'] ?? '';
$content    = $_POST['post_content'] ?? '';
$private     = $_POST['private'] ?? 0;
$owner   = $_SESSION['user_id'];
$csrf_token = $_POST['csrf_token'] ?? '';
// SQL 쿼리 작성 및 실행 
$sql = "INSERT INTO onboard (post_title, post_content, post_private, post_owner) VALUES (?, ?, ?, ?)";
$stmt = $db_connect->prepare($sql);
$success = $stmt->execute([$title, $content, $private, $owner]);

if ($success) {
    // 성공 시 리다이렉트
    $stmt = null;
    $db_connect = null;
    header("Location: create_content.php?success=1");
    exit;
} else {
    // 실패 시 기존 입력값을 세션에 저장
    $_SESSION['form_data'] = [
        'post_title'   => $title,
        'post_content' => $content,
        'private'      => $private
    ];
    $_SESSION['form_error'] = "게시글 저장에 실패했습니다. 다시 시도해 주세요.";

    $stmt = null;
    $db_connect = null;
    header("Location: create_content.php");
    exit;
}
?>