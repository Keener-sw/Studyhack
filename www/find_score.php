<?php
    session_start();
    $host = 'mysql-container';
    $db = 'users';
    $user = 'root';
    $pass = 'admin';
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
        $pdo->setAttribute(attribute: PDO::ATTR_ERRMODE, value:PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("DB 연결 실패: " . $e->getMessage());
    }

    $userid = $_SESSION['user_id'];
    $stmt = $pdo->prepare('Select * from score WHERE id = ?');
    $stmt->execute([$userid]);  
    $user = $stmt->fetch();
    if($user){
        echo json_encode(['score' => $user['score']]);
    }
    else{
        
    }
?>