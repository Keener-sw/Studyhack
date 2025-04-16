<?php
session_start();

// DB 연결
$host = 'mysql-container';  // Docker 컨테이너
$db   = 'users';
$user = 'root';
$pass = 'admin';
//mysql 연결시도 PDO 클래스
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(attribute: PDO::ATTR_ERRMODE, value:PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB 연결 실패: " . $e->getMessage());
}

// 폼이 제출되었는지 확인
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $pwd = password_hash($_POST["pwd"], PASSWORD_DEFAULT); // 비밀번호 암호화
    $name = $_POST["name"];
    $email = $_POST["email"];

    // INSERT 쿼리 실행
    $sql = "INSERT INTO priv_info (id, pwd, name, email) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([$id, $pwd, $name, $email]);
        echo "회원가입 성공!";
    } catch (PDOException $e) {
        echo "회원가입 실패: " . $e->getMessage();
    }
}
?>

<!-- 회원가입 폼 -->
<h2>회원가입</h2>
<form method="POST" action="register.php">
    아이디: <input type="text" name="id" required><br>
    비밀번호: <input type="password" name="pwd" required><br>
    이름: <input type="text" name="name" required><br>
    이메일: <input type="email" name="email" required><br>
    <button type="submit">Register</button>
</form>