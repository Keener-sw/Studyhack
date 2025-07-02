<?php
    require_once __DIR__ . '/../init.php';
    // 세션 시작

    $stmt = $db_connect->prepare('UPDATE priv_info SET nickname = ? WHERE id = ?');
    $stmt->execute([$_POST['nickname'], $userid]);
        if($stmt->rowCount() > 0){
            $err = '닉네임 변경에 성공했습니다.';
        }
        else{
            $err = ('닉네임 변경에 실패했습니다.');
        }

?>