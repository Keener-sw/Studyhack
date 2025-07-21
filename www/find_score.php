<!--사용하지 않음-->
<?php
    session_start();
    require_once __DIR__ . '/../config/db_config.php';
    try{
        $db_connect = new PDO("mysql:host=".db_host.";dbname=".db_name.";charset=utf8",db_root,db_pw);
        $db_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        echo "". $e->getMessage();
        die("DB connection error : ". $e->getMessage());
    }
    // DB 연결 설정

    $userid = $_SESSION['user_id'];
    $stmt = $db_connect->prepare('Select * from score WHERE id = ?');
    $stmt->execute([$userid]);
    $user = $stmt->fetch();
    echo $user;
    if($user){
        echo json_encode(['score' => $user['score']]);
    }
    else{
        echo json_encode(['score' => 'NOT Found']);
    }
?>
