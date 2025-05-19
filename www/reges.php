<?php
require_once __DIR__ . '/init.php';
/*session_start();
require_once __DIR__ . '/../config/db_config.php';
// DB 연결 설정

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB 연결 실패: " . $e->getMessage());
}
*/
// JSON 데이터 받아오기
$data = json_decode(file_get_contents(filename: 'php://input'), associative: true);

// 입력값 꺼내기
$id = $data['id'];
$pwd = password_hash($data['pwd'], PASSWORD_DEFAULT);
$name = $data['name'];
$email = $data['email'];
$nickname = $data['nickname'];

// INSERT 실행
try {
    $stmt = $db_connect->prepare("INSERT INTO priv_info (id, pwd, name, email, nickname) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$id, $pwd, $name, $email, $nickname]);
    echo "회원가입 성공!";
} catch (PDOException $e) {
    if (str_contains($e->getMessage(), 'Integrity constraint')) {
        echo "이미 존재하는 아이디 또는 이메일입니다.";
    } else {
        echo "가입 실패: " . $e->getMessage();
    }
}
?>